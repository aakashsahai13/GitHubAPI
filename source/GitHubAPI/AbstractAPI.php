<?php

namespace GitHubAPI;

abstract class AbstractAPI
{

    /** @var array */
    protected static $apiData = array(
        'rate' => array(),
        'last_links' => array(
            'first' => null,
            'prev' => null,
            'next' => null,
            'last' => null
        ),
        'last_request' => array(
            'headers' => null,
            'api' => null,
            'content' => null
        ),
        'last_response' => array(
            'metadata' => null,
            'content' => null
        ),
        'calls' => 0
    );

    /** @var string */
    protected $authentication = null;
    
    protected $configuration = null;

    /**
     * @return array
     */
    public static function getApiData()
    {
        return self::$apiData;
    }

    /**
     * @signature __construct(string $authentication) 40 byte auth code
     * @signature __construct(string $username, string $password) Github Username, Github Password
     * @signature __construct(array $authentication) array('username' => 'xx', 'password' => xxx)
     *
     * @param string|array $authentication
     */
    public function __construct($authentication = null, $configuration = null)
    {
        if ($authentication) {
            $this->setAuthentication($authentication);
        }
        if ($configuration) {
            $this->setConfiguration($configuration);
        }
    }

    /**
     * @signature __construct(string $authentication) 40 byte auth code
     * @signature __construct(string $username, string $password) Github Username, Github Password
     * @signature __construct(array $authentication) array('username' => 'xx', 'password' => xxx)
     *
     * @param string|array $authentication
     * @throws \InvalidArgumentException
     */
    public function setAuthentication($authentication)
    {
        if (is_string($authentication) && strlen($authentication) == 40) {
            $this->authentication = $authentication;
        } elseif (func_num_args() == 2) {
            $this->authentication = array(
                'username' => func_get_arg(0),
                'password' => func_get_arg(1)
            );
        } elseif (is_array($authentication) && isset($authentication['username']) && isset($authentication['password'])) {
            $this->authentication = $authentication;
        } elseif ($authentication !== null) {
            throw new \InvalidArgumentException('Authentication should either be an access token from github, or an array("username"=>xxx,"password"=>xxx)');
        }
    }
    
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    public static function getLastLinks()
    {
        return self::$apiData['last_links'];
    }

    public static function getLastPages()
    {
        $lastLinks = self::$apiData['last_links'];
        $lastNums = array();
        foreach ($lastLinks as $name => $uri) {
            if ($uri && preg_match('/page=(\d)/', $uri, $matches)) {

            }
        }
    }

    protected function doAPIRequest($api, array $content = array())
    {
        self::$apiData['last_request']['api'] = $api;
        self::$apiData['last_request']['content'] = $content;
        self::$apiData['calls']++;

        list($method, $urlPath) = explode(' ', $api, 2);

        $headers = array(
            'Accept' => 'application/vnd.github.full+json',
            'Content-type' => 'application/json'
        );
        
        // add in token
        if (is_string($this->authentication)) {
            $headers['Authorization'] = 'token ' . $this->authentication . "\r\n";
        } elseif (is_array($this->authentication)) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->authentication['username'] . ':' . $this->authentication['password']) . "\r\n";
        }
        
        if (isset($this->configuration['header']) && is_array($this->configuration['header'])) {
            $headers = array_merge($headers, $this->configuration['header']);
        }

        $headerString = '';
        foreach ($headers as $name => $value) {
            $headerString .= $name . ': ' . $value . "\r\n";
        }

        self::$apiData['last_request']['headers'] = $headers;

        // set method and json header
        $httpOptions = array(
            'method' => $method,
            'header' => $headerString,
            'ignore_errors' => true,
            'follow_location' => false
        );

        if ($content) {
            $httpOptions['content'] = json_encode($content);
        }

        // set context and get contents
        $context = stream_context_create(array(
            'http' => $httpOptions,
            'ssl' => array('verify_peer' => true)
        ));

        // reset last request data

        // is it the full url? or the one from the documentation?
        $urlPath = (strpos($urlPath, 'http') !== false) ? $urlPath : 'https://api.github.com' . $urlPath;

        $fh = fopen($urlPath, 'r', false, $context);
        self::$apiData['last_response']['metadata'] = $metadata = stream_get_meta_data($fh);
        self::$apiData['last_response']['content'] = $content = stream_get_contents($fh);
        fclose($fh);

        self::$apiData['last_links'] = array('first' => null, 'prev' => null, 'next' => null, 'last' => null);

        // get rate limit information
        if (get_class($this) !== __NAMESPACE__ . '\RateLimitAPI') {
            foreach ($metadata['wrapper_data'] as $header) {
                if (strpos($header, 'X-RateLimit-Remaining:') === 0) {
                    $rlRemaining = substr($header, 23);
                }
                if (strpos($header, 'X-RateLimit-Limit') === 0) {
                    $rlLimit = substr($header, 18);
                }
                if (stripos($header, 'content-type: application/json') === 0) {
                    $decodedContent = json_decode($content, true);
                }
                if (strpos($header, 'Link:') === 0) {
                    $links = substr($header, 6);
                    $links = explode(', ', $links);
                    foreach ($links as $link) {
                        $matches = array();
                        if (preg_match('#<(.*)>; rel="(\w+)"#', $link, $matches)) {
                            self::$apiData['last_links'][$matches[2]] = $matches[1];
                        }
                    }
                }
            }
            if (isset($rlRemaining) && isset($rlLimit) && isset($this->authentication) && is_string($this->authentication)) {
                self::$apiData['rate'][$this->authentication] = array('remaining' => $rlRemaining, 'limit' => $rlLimit);
            }
        }

        // any 200 level code is fine
        if (substr($metadata['wrapper_data'][0], 9, 2) !== '20') {
            return false;
        }

        if (isset($decodedContent)) {
            return $decodedContent;
        } else {
            return $content;
        }

    }

    protected function processParameters($validParameters, $parameters)
    {
        $cleanParameters = array();
        foreach ($parameters as $n => $v) {
            if (array_key_exists($n, $validParameters)) {
                $cleanParameters[$n] = $v;
            }
        }
        return $cleanParameters;
    }
    
    protected function getEntitiesFromData($data)
    {
        throw new \RuntimeException('This method must be called from an Entity returning API');
    }

}
