<?php

namespace GitHubAPI;

class GitHubAPI extends AbstractAPI
{

    public function __get($apiName)
    {
        switch (strtolower($apiName)) {
            case 'search':
                $api = new Search\SearchAPI;
                break;
            case 'user':
                $api = new User\UserApi;
                break;
        }
        
        $api->authentication = $this->authentication;
        $api->configuration = $this->configuration;
        return $api;
    }

}