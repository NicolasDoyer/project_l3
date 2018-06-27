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


class MatchController extends Controller
{

    function index(Request $request)
    {

        $this->updateUserScore($this->getUser());

        if ($this->getUser()->getTeam() == null) {
            $this->addFlash('error', "Il vous faut un groupe pour accéder à d'autres pages !");
            return $this->redirectToRoute('index');
        }
        $matches = MatchApi::getMatches();
        $paris = $this->getUser()->getParis();

        foreach ($paris as $pari) {
            $matchInfo = $pari->getIdMatch();
            foreach ($matches as $key => $match) {
                $timstamp = date_create_from_format("d/m/Y+|", $match['date'])->getTimestamp();
                if ($match['team1'] . '_' . $match['team2'] . '_' . $timstamp == $matchInfo) {
                    $matches[$key]['pari_team1'] = $pari->getScoreTeam1();
                    $matches[$key]['pari_team2'] = $pari->getScoreTeam2();
                    $matches[$key]['pari_result'] = $pari->getResult();
                }
            }
        }
        return $this->render('match.html.twig', array('matches' => $matches));
    }

    function getFromId(Request $request)
    {
        return new Response('ok');
    }

    public function updateUserScore($user)
    {
        $matches = MatchApi::getMatches();
        $em = $this->getDoctrine()->getManager();
        $scoreToAdd = 0;
        $paris = $user->getParis();
        foreach ($paris as $pari) {
            if ($pari->getResult() == null) {
                foreach ($matches as $match) {
                    // match correspond to pari
                    if (!$match['live'] && $match['score'] && $match['team1'] . '_' . $match['team2'] . '_' . $match['timestamp'] == $pari->getIdMatch()) {

                        $noWinnerMatch = false;
                        $noWinnerPari = false;

                        if ($match['score'][0] == $match['score'][1]) {
                            $noWinnerMatch = true;
                        }
                        if ($pari->getScoreTeam1() == $pari->getScoreTeam2()) {
                            $noWinnerPari = true;
                        }

                        if (!$noWinnerMatch)
                            $winnerMatch = ($match['score'][0] > $match['score'][1]) ? 0 : 1;
                        if (!$noWinnerPari)
                            $winnerPari = ($pari->getScoreTeam1() > $pari->getScoreTeam2()) ? 0 : 1;

                        // score exact
                        if ($pari->getScoreTeam1() == $match['score'][0] && $pari->getScoreTeam2() == $match['score'][1]) {
                            $scoreToAdd += 20;
                            $pari->setResult(20);
                        } // vainqueur sans score
                        elseif (isset($winnerPari) && isset($winnerMatch) && $winnerMatch == $winnerPari) {
                            $scoreToAdd += 5;
                            $pari->setResult(5);
                        } // mal parié
                        elseif ($noWinnerPari && !$noWinnerMatch || !$noWinnerMatch && $noWinnerPari) {
                            $pari->setResult(0);
                        }

                        $em->persist($pari);
                        $em->flush();
                    }
                }
            }
        }

        $user->setScore($user->getScore() + $scoreToAdd);
        $em->persist($user);
        $em->flush();
    }
}

