<?php

namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MatchControllerTest extends WebTestCase
{

    public function testMatch()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/matches');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

    }
}