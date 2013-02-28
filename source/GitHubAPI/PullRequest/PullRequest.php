<?php

namespace GitHubAPI\PullRequest;

use GitHubAPI\AbstractEntity;

class PullRequest extends AbstractEntity
{
    protected static $propertyEntityMap = array(
        'milestone' => 'GitHubAPI\Issue\Milestone',
        'assignee'  => 'GitHubAPI\User\BasicUser',
        'user'      => 'GitHubAPI\User\BasicUser'
    );

    protected $url;
    protected $htmlUrl;
    protected $diffUrl;
    protected $patchUrl;
    protected $number;
    protected $state;
    protected $title;
    protected $body;
    protected $createdAt;
    protected $updatedAt;
    protected $closedAt;
    protected $mergedAt;
    protected $base;
    protected $user;

    /** Issue releated */
    protected $milestone;
    protected $assignee;


    public function getUrl()
    {
        return $this->url;
    }

    public function getHtmlUrl()
    {
        return $this->htmlUrl;
    }

    public function getDiffUrl()
    {
        return $this->diffUrl;
    }

    public function getPatchUrl()
    {
        return $this->patchUrl;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getClosedAt()
    {
        return $this->closedAt;
    }

    public function getMergedAt()
    {
        return $this->mergedAt;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return \GitHubAPI\User\BasicUser
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @return \GitHubAPI\Issue\Milestone
     */
    public function getMilestone()
    {
        return $this->milestone;
    }

}
