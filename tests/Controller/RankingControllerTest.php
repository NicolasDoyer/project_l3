<?php

namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RankingControllerTest extends WebTestCase
{

    public function testRank()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/rank');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

    }
}