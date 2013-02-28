<?php

namespace GitHubAPITest;

abstract class AbstractResponse
{
    abstract public function getResponse(array $args);
}