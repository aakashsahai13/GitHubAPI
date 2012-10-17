<?php

namespace GitHubAPIv3\Repository;

use GitHubAPIv3\AbstractEntity;

class Repository extends AbstractEntity
{
    protected $url;
    protected $htmlUrl;
    protected $cloneUrl;
    protected $gitUrl;
    protected $sshUrl;
    protected $svnUrl;
    protected $mirrorUrl;
    protected $id;
    protected $owner;
    protected $name;
    protected $fullName;
    protected $description;
    protected $homepage;
    protected $language;
    protected $private;
    protected $fork;
    protected $forks;
    protected $watchers;
    protected $size;
    protected $masterBranch;
    protected $openIssues;
    protected $pushedAt;
    protected $createdAt;
    protected $updatedAt;

    public function getUrl()
    {
        return $this->url;
    }

    public function getHtmlUrl()
    {
        return $this->htmlUrl;
    }

    public function getCloneUrl()
    {
        return $this->cloneUrl;
    }

    public function getGitUrl()
    {
        return $this->gitUrl;
    }

    public function getSshUrl()
    {
        return $this->sshUrl;
    }

    public function getSvnUrl()
    {
        return $this->svnUrl;
    }

    public function getMirrorUrl()
    {
        return $this->mirrorUrl;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getHomepage()
    {
        return $this->homepage;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getPrivate()
    {
        return $this->private;
    }

    public function getFork()
    {
        return $this->fork;
    }

    public function getForks()
    {
        return $this->forks;
    }

    public function getWatchers()
    {
        return $this->watchers;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getMasterBranch()
    {
        return $this->masterBranch;
    }

    public function getOpenIssues()
    {
        return $this->openIssues;
    }

    public function getPushedAt()
    {
        return $this->pushedAt;
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
