<?php

namespace GitHubAPI\User;

use GitHubAPI\AbstractAPI;

class UserAPI extends AbstractAPI
{

    /**
     * @param string $user
     * @return User
     */
    public function getUser($user)
    {
        $api = 'GET /users/' . $user;
        $userData = $this->doAPIRequest($api);
        if ($userData === false) {
            return false;
        }
        return User::createEntity($userData);
    }

    /**
     * http://developer.github.com/v3/users/#get-the-authenticated-user
     * @return AuthenticatedUser
     */
    public function AuthenticatedUser()
    {
        if (!$this->authentication) {
            throw new \RuntimeException('This API requires authentication');
        }

        $api = 'GET /user';
        $userData = $this->doAPIRequest($api);
        return User::createEntity($userData);
    }

    /**
     * @param AuthenticatedUser $user
     * @return bool
     */
    public function updateAuthenticatedUser(AuthenticatedUser $user)
    {

        return true;
    }

    public function getFollowers($username = null, array $parameters = array())
    {
        $parameters = $this->processParameters(
            array(
                'page' => null, 'per_page' => null,
            ),
            $parameters
        );

        $api = ($username) ? 'GET /users/' . $username . '/followers' : 'GET /user/followers';

        if ($parameters) {
            $api .= '?' . http_build_query($parameters);
        }

        $followersData = $this->doAPIRequest($api);
        $followers = array();
        foreach ($followersData as $followerData) {
            $followers[] = BasicUser::createEntity($followerData);
        }
        return $followers;
    }

    public function getFollowing($username = null, array $parameters = array())
    {
        $parameters = $this->processParameters(
            array(
                'page' => null, 'per_page' => null,
            ),
            $parameters
        );

        $api = ($username) ? 'GET /users/' . $username . '/following' : 'GET /user/following';

        if ($parameters) {
            $api .= '?' . http_build_query($parameters);
        }

        $followingsData = $this->doAPIRequest($api);
        $followings = array();
        foreach ($followingsData as $followerData) {
            $followings[] = BasicUser::createEntity($followerData);
        }
        return $followings;
    }

}