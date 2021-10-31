<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    const USER_EMAIL = "test@test.fr";

    public function testName()
    {
        $user = $this->init();
        $user->setEmail(self::USER_EMAIL);

        $this->assertEquals(self::USER_EMAIL, $user->getEmail());
    }

    private function init()
    {
        return new User();
    }
}
