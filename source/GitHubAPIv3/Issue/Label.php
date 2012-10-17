<?php

namespace GitHubAPIv3\Issue;

use GitHubAPIv3\AbstractEntity;

class Label extends AbstractEntity
{
    protected $url;
    protected $name;
    protected $color;

    public function getUrl()
    {
        return $this->url;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->updatedProperties['name'] = true;
        $this->name = $name;
        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->updatedProperties['color'] = true;
        $this->color = $color;
        return $this;
    }

}