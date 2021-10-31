<?php

namespace App\Tests\Entity;

use App\Entity\Project;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    const PROJECT_NAME = "Project Test Name";

    public function testName()
    {
        $project = $this->init();
        $project->setName(self::PROJECT_NAME);

        $this->assertEquals(self::PROJECT_NAME, $project->getName());
    }

    private function init()
    {
        return new Project();
    }
}
