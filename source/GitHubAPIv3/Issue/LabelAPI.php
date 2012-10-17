<?php

namespace GitHubAPIv3\Issue;

use GitHubAPIv3\AbstractAPI;

class LabelAPI extends AbstractAPI
{
    public function getLabels($owner, $repo)
    {
        $api = "GET /repos/$owner/$repo/labels";
        $labels = $this->doAPIRequest($api);

        $labelEntities = array();
        foreach ($labels as $label) {
            $labelEntities[] = $this->createEntity(__NAMESPACE__ . '\Label', $label);
        }
        return $labelEntities;
    }

    public function createLabel($owner, $repo, array $data)
    {
        $data = $this->doAPIRequest("POST /repos/$owner/$repo/labels", $data);
        if ($data === false) {
            throw new \RuntimeException(
                'Could not create label',
                null,
                new \GitHubAPIv3\Exception\GitHubErrorsException($this->lastResponseBodyDecoded['message'], $this->lastResponseBodyDecoded['errors'])
            );
        }
        return $this->createEntity(__NAMESPACE__ . '\Label', $data);
    }

    public function createLabelWithEntity($owner, $repo, Label $label)
    {
        $data = $this->createArrayFromUpdatedProperties($label);
        $data = $this->doAPIRequest("POST /repos/$owner/$repo/labels", $data);
        if ($data === false) {
            throw new \RuntimeException(
                'Could not create label',
                null,
                new \GitHubAPIv3\Exception\GitHubErrorsException($this->lastResponseBodyDecoded['message'], $this->lastResponseBodyDecoded['errors'])
            );
        }
        $this->synchronizeEntity($label, $data);
    }

    public function deleteLabel($owner, $repo, $name)
    {
        $data = $this->doAPIRequest("DELETE /repos/$owner/$repo/labels/$name");
        if ($data !== false) { // sucess will return an empty string
            return true;
        }
        return false;
    }

}
