<?php

namespace GitHubAPI\Exception;

class GitHubErrorsException extends \Exception
{
    protected $errors = array();

    public function __construct($message, array $githubErrors)
    {
        parent::__construct($message);
        $this->errors = $githubErrors;
    }
}