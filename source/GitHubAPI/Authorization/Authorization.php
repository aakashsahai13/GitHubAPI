<?php

namespace GitHubAPI\Authorization;

use GitHubAPI\AbstractEntity;

class Authorization extends AbstractEntity
{
    protected $id;
    protected $url;
    protected $scopes;
    protected $token;
    protected $app;
    protected $note;
    protected $noteUrl;
    protected $updatedAt;
    protected $createdAt;

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getScopes()
    {
        return $this->scopes;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getApp()
    {
        return $this->app;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function getNoteUrl()
    {
        return $this->noteUrl;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

}
