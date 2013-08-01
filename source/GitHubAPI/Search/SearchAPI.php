<?php

namespace GitHubAPI\Search;

use GitHubAPI\AbstractAPI;
use GitHubAPI\User\BasicUser;

class SearchAPI extends AbstractAPI
{
    protected $entityRootPath = array('items');
    
    public function findUsers(array $parameters = array())
    {
        $parameters = $this->processParameters(
            array('q' => null, 'sort' => null, 'order' => array('desc', 'asc')),
            $parameters
        );
        
        $api = 'GET /search/users';
        if ($parameters) {
            $api .= '?' . http_build_query($parameters);
        }
        $sus = $this->doAPIRequest($api);
        if ($sus == false) {
            return array();
        }
        
        return $this->getEntitiesFromData($sus);
    }
    
    protected function getEntitiesFromData($data)
    {
        $userEntities = array();
        foreach ($data['items'] as $su) {
            $userEntities[] = BasicUser::createEntity($su);
        }
        return $userEntities;
    }
}
