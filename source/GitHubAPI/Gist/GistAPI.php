<?php

namespace GitHubAPI\Gist;

use GitHubAPI\AbstractAPI;

class GistAPI extends AbstractAPI
{

    public function getUserGists($user, array $parameters = array())
    {
        $parameters = $this->processParameters(
            array(
                'page' => null, 'per_page' => null,
            ),
            $parameters
        );

        $api = "GET /users/$user/gists";

        if ($parameters) {
            $api .= '?' . http_build_query($parameters);
        }

        $gistsDatas = $this->doAPIRequest($api);
        $gists = array();
        foreach ($gistsDatas as $gistsData) {
            $gists[] = Gist::createEntity($gistsData);
        }
        return $gists;
    }

}
