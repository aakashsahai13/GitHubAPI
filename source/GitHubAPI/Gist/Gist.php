<?php

namespace GitHubAPI\Gist;

use GitHubAPI\AbstractEntity;

class Gist extends AbstractEntity
{

    protected static $propertyEntityMap = array(
        'user' => 'GitHubAPI\User\BasicUser',
    );

    protected $id;
    protected $url;
    protected $forksUrl;
    protected $commitsUrl;
    protected $gitPullUrl;
    protected $gitPushUrl;
    protected $htmlUrl;
    protected $description;
    protected $public;
    protected $user;
    protected $files;
    protected $comments;
    protected $commentsUrl;
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

    public function getForksUrl()
    {
        return $this->forksUrl;
    }

    public function getCommitsUrl()
    {
        return $this->commitsUrl;
    }

    public function getGitPullUrl()
    {
        return $this->gitPullUrl;
    }

    public function getGitPushUrl()
    {
        return $this->gitPushUrl;
    }

    public function getHtmlUrl()
    {
        return $this->htmlUrl;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function isPublic()
    {
        return ($this->public == '1');
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function getCommentsUrl()
    {
        return $this->commentsUrl;
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
