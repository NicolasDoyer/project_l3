<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Utils\MatchApi;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TheSeer\Tokenizer\Exception;


class MatchController extends Controller {

    function index(Request $request) {
        if($this->getUser()->getTeam() == null){
            $this->addFlash('error', "Il vous faut un groupe pour accéder à d'autres pages !");
            return $this->redirectToRoute('index');
        }
       $matches = MatchApi::getMatches();
       $paris = $this->getUser()->getParis();

       foreach($paris as $pari){
           $matchInfo = $pari->getIdMatch();
           foreach ($matches as $key => $match){
               $timstamp = date_create_from_format("d/m/Y|", $match['date'])->getTimestamp();
               if($match['team1'].'_'.$match['team2'].'_'.$timstamp == $matchInfo){
                   $matches[$key]['pari_team1'] = $pari->getScoreTeam1();
                   $matches[$key]['pari_team2'] = $pari->getScoreTeam2();
               }
           }
       }

       return $this->render('match.html.twig', array( 'matches' => $matches));
    }

    function getFromId(Request $request){
        return new Response('ok');
    }
}