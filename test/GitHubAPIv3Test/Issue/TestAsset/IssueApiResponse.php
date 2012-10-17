<?php

namespace GitHubAPIv3Test\Issue\TestAsset;

use GitHubAPIv3Test\AbstractResponse;

class IssueAPIResponse extends AbstractResponse
{
    public function getResponse(array $args)
    {
        $url = $args[0];
        $content = $args[1];

        $filename = str_replace(array(' ', '/'), ':', $url) . '.json';
        if (file_exists(__DIR__ . '/' . $filename)) {
            return json_decode(file_get_contents(__DIR__ . '/' . $filename), true);
        } else {
            return array();
        }
    }

}
