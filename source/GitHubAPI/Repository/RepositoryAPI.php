<?php

namespace GitHubAPI\Repository;

use GitHubAPI\AbstractAPI;

class RepositoryAPI extends AbstractAPI
{


    /**
     * @link http://developer.github.com/v3/repos/#list-your-repositories
     */
    public function getOwnerRepositories($owner)
    {
        $repos = $this->doAPIRequest("GET /users/$owner/repos");
        if ($repos === false || $repos === array()) {
            return false;
        }
        $repoEntities = array();
        foreach ($repos as $repo) {
            $repoEntities[] = Repository::createEntity($repo);
        }
        return $repoEntities;
    }

}
