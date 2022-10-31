<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class GitTest extends ApiTestCase
{
    public function testSomething(): void
    {
        static::createClient()->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }
}
