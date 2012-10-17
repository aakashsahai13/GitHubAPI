<?php

namespace GitHubAPIv3\Search;

use GitHubAPIv3\AbstractAPI;

class SearchAPI extends AbstractAPI
{


    public function searchByEmail($email)
    {
        $users = $this->doAPIRequest("GET /legacy/user/email/$email");
        if ($users === false || $users === array()) {
            return false;
        }
        return $this->createEntity('GitHubAPIv3\User\User', $users['user']);
    }

    public function searchUserByKeyword($keyword)
    {
        $users = $this->doAPIRequest("GET /legacy/user/search/$keyword");
        if ($users === false || $users['users'] === array()) {
            return false;
        }
        $entities = array();
        foreach ($users['users'] as $user) {
            $entities[] = $this->createEntity('GitHubAPIv3\User\User', $user);
        }
        return $entities;
    }

}
