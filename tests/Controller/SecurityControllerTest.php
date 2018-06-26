<?php

namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    public function testLogin()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('form')->count());
        $this->assertGreaterThan(0, $crawler->filter('input[id=username]')->count());
        $this->assertGreaterThan(0, $crawler->filter('input[id=password]')->count());

    }
}