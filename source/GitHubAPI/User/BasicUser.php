<?php

namespace GitHubAPI\User;

use GitHubAPI\AbstractEntity;

class BasicUser extends AbstractEntity
{
    protected $login;
    protected $id;
    protected $avatarUrl;
    protected $gravatarId;
    protected $url;
    protected $htmlUrl;
    protected $followersUrl;
    protected $followingUrl;
    protected $gistsUrl;
    protected $starredUrl;
    protected $subscriptionsUrl;
    protected $organizationsUrl;
    protected $reposUrl;
    protected $eventsUrl;
    protected $receivedEventsUrl;
    protected $type;

    public function getLogin()
    {
        return $this->login;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    public function getGravatarId()
    {
        return $this->gravatarId;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getHtmlUrl()
    {
        return $this->htmlUrl;
    }

    public function getType()
    {
        return $this->type;
    }
    
    public static function __set_state(array $state)
    {
        $basicUser = new self;
        foreach ($state as $n => $v) {
            $basicUser->{$n} = $v;
        }
        return $basicUser;
    }

}
