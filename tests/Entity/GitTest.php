<?php

namespace App\Tests\Entity;

use App\Entity\Git;
use PHPUnit\Framework\TestCase;

class GitTest extends TestCase
{
    const NAME = "Git Name Test";

    public function testName()
    {
        $git = $this->init();
        $git->setName(self::NAME);

        $this->assertEquals(self::NAME, $git->getName());
    }

    public function testRepositoryName()
    {
        $repo = "test/test";
        $git = $this->init();
        $git->setRepositoryName($repo);

        $this->assertEquals($repo, $git->getRepositoryName());
    }

    public function testBaseUrl()
    {
        $baseUrl = "github.com";
        $git = $this->init();
        $git->setBaseUrl($baseUrl);

        $this->assertEquals($baseUrl, $git->getBaseUrl());
    }

    public function testProvider()
    {
        $provider = "Github";
        $git = $this->init();
        $git->setProvider($provider);

        $this->assertEquals($provider, $git->getProvider());
    }

    public function testBranch()
    {
        $branch = "develop";
        $git = $this->init();
        $git->setBranch($branch);

        $this->assertEquals($branch, $git->getBranch());
    }

    private function init()
    {
        return new Git();
    }
}
