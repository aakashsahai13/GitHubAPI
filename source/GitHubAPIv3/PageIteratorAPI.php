<?php

namespace GitHubAPIv3;

class PageIteratorAPI extends AbstractAPI implements \Iterator
{

    protected $api = null;
    protected $entities = false;
    protected $entityType = null;
    protected $page = 1;
    protected $position = 0;

    public function __construct(AbstractAPI $api)
    {
        $this->api = $api;
    }

    public function __call($method, $args)
    {
        $this->entities = call_user_func_array(array($this->api, $method), $args);
        if (isset($this->entities[0])) {
            $this->entityType = get_class($this->entities[0]);
        }
    }

    public function current()
    {
        if ($this->entities === false) {
            throw new \RuntimeException('An API call must be made before iteration can occur.');
        }
        return $this->entities[$this->position];
    }

    public function next()
    {
        if ($this->entities === false) {
            throw new \RuntimeException('An API call must be made before iteration can occur.');
        }
        $this->position++;
    }

    public function key()
    {
        if ($this->entities === false) {
            throw new \RuntimeException('An API call must be made before iteration can occur.');
        }
        return $this->position;
    }

    public function valid()
    {
        if ($this->entities === false) {
            throw new \RuntimeException('An API call must be made before iteration can occur.');
        }
        if (isset($this->entities[$this->position])) {
            return true;
        } elseif (!isset($this->entities[$this->position]) && self::$apiData['last_links']['next'] === null) {
            return false;
        } else {
            $urlApi = new UrlAPI(self::$apiData['last_links']['next'], $this->entityType);
            $urlApi->authentication = $this->api->authentication; // get authentication
            $this->entities = array_merge($this->entities, $urlApi->call());
            $this->page++;
            return (isset($this->entities[$this->position]));
        }
    }

    public function rewind()
    {
        if ($this->entities === false) {
            throw new \RuntimeException('An API call must be made before iteration can occur.');
        }
        $this->position = 0;
    }

    public function getPage()
    {
        return $this->page;
    }

}
