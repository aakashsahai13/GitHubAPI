<?php

namespace GitHubAPI\Issue;

use GitHubAPI\AbstractAPI;

class CommentAPI extends AbstractAPI
{
    public function getComments($owner, $repo, $number)
    {
        $comments = $this->doAPIRequest("GET /repos/$owner/$repo/issues/$number/comments");
        if ($comments === false) {
            return false;
        }
        $commentEntities = array();
        foreach ($comments as $comment) {
            $commentEntities[] = Comment::createEntity($comment);
        }
        return $commentEntities;
    }

    public function getComment($owner, $repo, $id)
    {

    }

    public function createComment($owner, $repo, $number, $body)
    {
        $ret = $this->doAPIRequest("POST /repos/$owner/$repo/issues/$number/comments", array('body' => $body));
        if ($ret === false) {
            return false;
        }
        return true;
    }

    public function editComment($owner, $repo, $id)
    {

    }

    public function deleteComment($owner, $repo, $id)
    {

    }

}
