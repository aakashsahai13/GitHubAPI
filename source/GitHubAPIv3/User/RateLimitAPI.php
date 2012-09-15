<?php

namespace GitHubAPIv3\User;

use GitHubAPIv3\AbstractAPI;

class RateLimitAPI extends AbstractAPI
{
    protected static $rateLimit = array();

    public static function setRateLimitFromHeader($remaining, $limit, $rateLimitScope = null)
    {
        if ($rateLimitScope == null) {
            // @todo
            return;
        }
        if (is_string($rateLimitScope)) {
            self::$rateLimit[$rateLimitScope] = array('remaining' => $remaining, 'limit' => $limit, 'fromHeader' => true);
        }
    }

    public function getRateLimit($which = null)
    {
        if (isset($this->accessToken) && isset(self::$rateLimit[$this->accessToken])) {
            return self::$rateLimit[$this->accessToken];
        }

        $api = 'GET /rate_limit';
        $info = $this->doAPIRequest($api);
        return $info['rate'];
    }
}