<?php

namespace GitHubAPI;

class UrlAPI extends AbstractAPI
{
    protected $url = null;
    protected $entityType = null;

    public function __construct($url, $entityType = null)
    {
        $this->url = $url;
        $this->entityType = $entityType;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getEntityType()
    {
        return $this->entityType;
    }

    public function call()
    {
        $list = $this->doAPIRequest('GET ' . $this->url);
        if ($this->entityType) {
            /** @var $type AbstractEntity (actually it's a string) */
            $type = $this->entityType;
            $entities = array();
            foreach ($list as $data) {
                $entities[] = $type::createEntity($data);
            }
            return $entities;
        }
        return $list;
    }
}