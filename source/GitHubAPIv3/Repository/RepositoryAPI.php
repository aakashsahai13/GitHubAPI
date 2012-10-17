<?php

namespace GitHubAPIv3\Repository;

use GitHubAPIv3\AbstractAPI;

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
            $repoEntities[] = $this->createEntity(__NAMESPACE__ . '\Repository', $repo);
        }
        return $repoEntities;
    }

}
