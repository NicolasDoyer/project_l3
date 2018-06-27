<?php

namespace App\Tests\Utils;
use App\Utils\MatchApi;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MatchApiTest extends WebTestCase
{

    public function testApiResult()
    {
        $matches = MatchApi::getMatches();
        $this->assertGreaterThan(0,count($matches));
    }
}