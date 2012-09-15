<?php

namespace GitHubAPIv3;

abstract class AbstractAPI
{
    /** @var string */
    protected $accessToken = null;


    protected $lastRequestMetadata = null;
    protected $lastRequestBody = null;
    protected $lastRequestBodyDecoded = null;

    public function __construct($accessToken = null)
    {
        $this->accessToken = $accessToken;
    }

    protected function doAPIRequest($api, array $content = array())
    {
        list($method, $urlPath) = explode(' ', $api, 2);

        // set method and json header
        $httpOptions = array(
            'method' => $method,
            'header' => "Accept: application/json\r\nContent-type: application/json\r\n",
            'ignore_errors' => true,
        );

        // add in token
        if ($this->accessToken) {
            $httpOptions['header'] .= 'Authorization: token ' . $this->accessToken . "\r\n";
        }

        if ($content) {
            $httpOptions['content'] = json_encode($content);
        }

        // set context and get contents
        $context = stream_context_create(array('http' => $httpOptions));

        // reset last request data
        $this->lastRequestMessage = $this->lastRequestMetadata = null;

        // is it the full url? or the one from the documentation?
        $urlPath = (strpos($urlPath, 'http') !== false) ? $urlPath : 'https://api.github.com' . $urlPath;

        $fh = fopen($urlPath, 'r', false, $context);
        $this->lastRequestBody = stream_get_contents($fh);
        $this->lastRequestMetadata = stream_get_meta_data($fh);
        fclose($fh);

        $this->lastRequestBodyDecoded = json_decode($this->lastRequestBody, true);

        // get rate limit information
        if (get_class($this) !== __NAMESPACE__ . '\RateLimitAPI') {
            foreach ($this->lastRequestMetadata['wrapper_data'] as $index => $header) {
                if (strpos($header, 'X-RateLimit-Remaining:') === 0) {
                    $rlRemaining = substr($header, 23);
                }
                if (strpos($header, 'X-RateLimit-Limit') === 0) {
                    $rlLimit = substr($header, 18);
                }
            }
            if (isset($rlRemaining) && isset($rlLimit)) {
                RateLimitAPI::setRateLimitFromHeader($rlRemaining, $rlLimit, $this->accessToken);
            }
        }

        if (substr($this->lastRequestMetadata['wrapper_data'][0], 9, 3) !== '200') {
            return false;
        }

        return $this->lastRequestBodyDecoded;
    }

    protected function createEntity($type, $data)
    {
        $entity = new $type;
        $this->synchronizeEntity($entity, $data);
        return $entity;
    }

    protected function synchronizeEntity(AbstractEntity $entity, $data)
    {
        $ro = new \ReflectionObject($entity);

        foreach ($data as $dName => $dValue) {
            $dName = lcfirst(str_replace(' ' , '', ucwords(str_replace('_', ' ', $dName))));

            if ($ro->hasProperty($dName)) {
                $prop = $ro->getProperty($dName);
                $prop->setAccessible(true);
                $prop->setValue($entity, $dValue);
            }
        }
    }

    protected function createArrayFromUpdatedProperties(AbstractEntity $entity)
    {
        $aProperties = array();
        foreach ($entity->getUpdatedProperties() as $name) {
            $property = preg_replace(
                '/(^|[a-z])([A-Z])/',
                '\\1_\\2',
                $name
            );
            $aProperties[$property] = $entity->{'get' . $name}();
        }
        return $aProperties;
    }

}