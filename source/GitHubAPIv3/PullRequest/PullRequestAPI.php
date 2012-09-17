<?php

namespace GitHubAPIv3\PullRequest;

use GitHubAPIv3\AbstractAPI;

class PullRequestAPI extends AbstractAPI
{

    public function getPullRequests($user, $repo)
    {
        $api = "GET /repos/$user/$repo/pulls";
        $prs = $this->doAPIRequest($api);
        $prsEntities = array();
        foreach ($prs as $pr) {
            $prsEntities[] = $this->createEntity(__NAMESPACE__ . '\PullRequest', $pr);
        }
        return $prsEntities;
    }

    public function getPullRequest($user, $repo, $number)
    {
        $api = "GET /repos/:user/:repo/pulls/:number";

    }

}