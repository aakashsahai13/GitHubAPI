<?php

namespace GitHubAPI\PullRequest;

use GitHubAPI\AbstractAPI;

class PullRequestAPI extends AbstractAPI
{

    public function getPullRequests($user, $repo, array $parameters = array())
    {
        $parameters = $this->processParameters(
            array('page' => null, 'per_page' => null, 'state' => array('open', 'closed')),
            $parameters
        );
        
        $api = "GET /repos/$user/$repo/pulls";
        if ($parameters) {
            $api .= '?' . http_build_query($parameters);
        }
        $prs = $this->doAPIRequest($api);
        if ($prs == false) {
            return array();
        }

        $prsEntities = array();
        foreach ($prs as $pr) {
            $prsEntities[] = PullRequest::createEntity($pr);
        }
        return $prsEntities;
    }

    public function getPullRequest($user, $repo, $number)
    {
        $api = "GET /repos/:user/:repo/pulls/:number";

    }

}