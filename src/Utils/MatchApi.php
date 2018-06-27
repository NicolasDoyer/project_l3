<?php

namespace App\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SebastianBergmann\Comparator\DateTimeComparator;

class MatchApi{

    static private $base_url = "http://daudenthun.fr/api/";

    public static function getMatches(){

        $client = new Client();
        try{
            $result = $client->request('GET', self::$base_url.'listing');
            $result = json_decode($result->getBody(), true);
            $matches = array();

            foreach ($result as $data){
                $team1 = array_keys($data)[0];
                $timstamp = date_create_from_format("d/m/Y+|", $data[$team1]['date'])->getTimestamp();
                $betClosed = (time() > $timstamp);

                array_push($matches,array(
                    "team1" => $team1,
                    "team2" => $data[$team1]['vs'],
                    "score" => $data[$team1]['score'],
                    "live"  => $data[$team1]['live'],
                    "date"  => $data[$team1]['date'],
                    "timestamp" => $timstamp,
                    "betClosed" => $betClosed
                ));
            }
            return $matches;

        }catch(GuzzleException $e){
            return array();
        }
    }

}