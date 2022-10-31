<?php

namespace App\Tests\Entity;

use App\Entity\Package;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    const PACKAGE_TYPE = Package::TYPE_COMPOSER;

    public function testType()
    {
        $package = $this->init();
        $package->setType(self::PACKAGE_TYPE);

        $this->assertEquals(self::PACKAGE_TYPE, $package->getType());
    }

    public function testPath()
    {
        $path = "package-lock.json";
        $package = $this->init();
        $package->setPath($path);

        $this->assertEquals($path, $package->getPath());
    }

    private function init()
    {
        return new Package();
    }
}
