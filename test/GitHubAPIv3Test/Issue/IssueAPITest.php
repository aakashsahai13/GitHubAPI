<?php

namespace GitHubAPIv3Test\Issue;

use GitHubAPIv3\Issue\IssueAPI;

class IssueAPITest extends \GitHubAPIv3Test\AbstractAPITestCase
{
    /** @var IssueAPI */
    protected $issueApi;

    public function setup()
    {
        $this->issueApi = $this->getApiMock('GitHubAPIv3\Issue\IssueAPI');
        $this->apiResponse = new TestAsset\IssueAPIResponse();
    }

    public function testGetRepositoryIssues()
    {
        $this->assertApiUrl('GET /repos/anOwner/aProject/issues');
        $issues = $this->issueApi->getRepositoryIssues('anOwner', 'aProject');
        $issue = $issues[0];
        $this->assertInstanceOf('GitHubAPIv3\Issue\Issue', $issue);
    }

}