<?php

namespace GitHubAPIv3\Issue;

use GitHubAPIv3\AbstractEntity;

class Comment extends AbstractEntity
{
    protected static $propertyEntityMap = array(
        'user' => 'GitHubAPIv3\User\BasicUser'
    );

    protected $id;
    protected $url;
    protected $body;
    protected $user;
    protected $createdAt;
    protected $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}
