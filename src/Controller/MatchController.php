<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Utils\MatchApi;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TheSeer\Tokenizer\Exception;


class MatchController extends Controller {

    function index(Request $request) {
       $matches = MatchApi::getMatches();
       return $this->render('match.html.twig', array( 'matches' => $matches));
    }
}