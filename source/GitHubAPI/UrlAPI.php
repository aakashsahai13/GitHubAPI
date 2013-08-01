<?php

namespace GitHubAPI;

class UrlAPI extends AbstractAPI
{
    protected $url = null;
    protected $originalApi = null;

    public function __construct($url, $originalApi = null)
    {
        $this->url = $url;
        $this->originalApi = $originalApi;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getOriginalApi()
    {
        return $this->originalApi;
    }

    public function call()
    {
        $list = $this->doAPIRequest('GET ' . $this->url);
        if (!$list) {
            throw new \RuntimeException('Data was not returned by this url');
        }
        return $this->originalApi->getEntitiesFromData($list);
    }
}