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

    private function init()
    {
        return new Git();
    }
}
