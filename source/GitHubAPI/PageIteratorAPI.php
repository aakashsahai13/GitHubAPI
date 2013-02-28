<?php

namespace GitHubAPI;

class PageIteratorAPI
{

    protected $api = null;

    public function __construct(AbstractAPI $api)
    {
        $this->api = $api;
    }

    public function __call($method, $args)
    {
        $rm = new \ReflectionMethod(get_class($this->api), $method);
        foreach ($rm->getParameters() as $position => $rParameter) {
            if (!isset($args[$position])) {
                $args[$position] = null;
            }
            if ($rParameter->getName() == 'parameters') {
                if (!is_array($args[$position])) {
                    $args[$position] = array();
                }
                if (!isset($args[$position]['per_page'])) {
                    $args[$position]['per_page'] = 100;
                }
                break;
            }
        }
        $entities = call_user_func_array(array($this->api, $method), $args);
        if ($entities == false) {
            return array();
        }
        if (!is_array($entities)) {
            throw new \BadMethodCallException(__CLASS__ . ' can only be used with methods that return an array of entities, or something that can be paginated');
        }
        $pageIterator = new PageIterator(
            $this->api,
            $entities
        );
        return $pageIterator;
    }

}
