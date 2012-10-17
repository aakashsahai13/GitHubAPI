<?php

namespace GitHubAPIv3Test;

abstract class AbstractResponse
{
    abstract public function getResponse(array $args);
}