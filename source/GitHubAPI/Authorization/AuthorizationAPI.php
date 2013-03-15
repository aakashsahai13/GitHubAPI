<?php

namespace GitHubAPI\Authorization;

use GitHubAPI\AbstractAPI;

class AuthorizationAPI extends AbstractAPI
{
    public function createAuthorization(array $parameters = array())
    {
        $validParameters = array(
            'scopes' => null,
            'note' => null,
            'note_url' => null,
            'client_id' => null,
            'client_secret' => null,
        );
        $params = $this->processParameters($validParameters, $parameters);
        $api = 'POST /authorizations';
        $authData = $this->doAPIRequest($api, $params);
        if ($authData === false) {
            return false;
        }
        $auth = Authorization::createEntity($authData);
        return $auth;
    }
}
