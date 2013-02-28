<?php

namespace GitHubAPITest\Issue;

use GitHubAPI\Issue\IssueAPI;

class IssueAPITest extends \GitHubAPITest\AbstractAPITestCase
{
    /** @var IssueAPI */
    protected $issueApi;

    public function setup()
    {
        $this->issueApi = $this->getApiMock('GitHubAPI\Issue\IssueAPI');
        $this->apiResponse = new TestAsset\IssueAPIResponse();
    }

    public function testGetRepositoryIssues()
    {
        $this->assertApiUrl('GET /repos/anOwner/aProject/issues');
        $issues = $this->issueApi->getRepositoryIssues('anOwner', 'aProject');
        $issue = $issues[0];
        $this->assertInstanceOf('GitHubAPI\Issue\Issue', $issue);
    }

}