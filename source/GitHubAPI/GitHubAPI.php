<?php

namespace GitHubAPI;

class GitHubAPI extends AbstractAPI
{

    /**
     * @return User\RateLimitAPI
     */
    public function getRateLimitApi()
    {
        return new User\RateLimitAPI($this->authentication);
    }

    /**
     * @return User\UserAPI
     */
    public function getUserApi()
    {
        return new User\UserAPI($this->authentication);
    }

    /**
     * @return Gist\GistAPI
     */
    public function getGistApi()
    {
        return new Gist\GistAPI($this->authentication);
    }

}