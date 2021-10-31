<?php

namespace App\Tests\Entity;

use App\Entity\Package;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    const PACKAGE_TYPE = Package::TYPE_COMPOSER;

    public function testName()
    {
        $package = $this->init();
        $package->setType(self::PACKAGE_TYPE);

        $this->assertEquals(self::PACKAGE_TYPE, $package->getType());
    }

    private function init()
    {
        return new Package();
    }
}
