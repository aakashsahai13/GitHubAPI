<?php

namespace GitHubAPIv3Test;


class AbstractAPITestCase extends \PHPUnit_Framework_TestCase
{
    protected $assertApiUrl = null;

    protected $lastFuncArgs = array();

    /** @var AbstractResponse */
    protected $apiResponse;

    protected function getApiMock($apiClass)
    {
        $mock = $this->getMock($apiClass, array('doApiRequest'));
        $mock->expects($this->any())->method('doApiRequest')->will($this->returnCallback(function () {
            $this->lastFuncArgs = func_get_args();

            if ($this->assertApiUrl) {
                $this->assertEquals($this->assertApiUrl, $this->lastFuncArgs[0]);
            }

            return $this->apiResponse->getResponse($this->lastFuncArgs);
        }));
        return $mock;
    }

    public function assertApiUrl($url)
    {
        $this->assertApiUrl = $url;
    }

}