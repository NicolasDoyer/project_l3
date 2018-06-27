<?php

namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ErrorControllerTest extends WebTestCase
{

    public function test404()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/coucoua');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}