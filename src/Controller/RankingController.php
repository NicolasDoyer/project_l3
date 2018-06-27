<?php
/**
 * Created by PhpStorm.
 * User: masterinfo
 * Date: 26/06/18
 * Time: 09:45
 */

namespace App\Controller;


use App\Utils\MatchApi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RankingController extends Controller
{
    public function view(){

        $team = $this->getUser()->getTeam();

        if($this->getUser()->getTeam() == null){
            $this->addFlash('error', "Il vous faut un groupe pour accéder à d'autres pages !");
            return $this->redirectToRoute('index');
        }

        $rank = $this->getUser()->getTeam()->getUsers()->toArray();

        usort($rank, function ($a,$b){
            if($a->getScore() == $b->getScore()){
                return 0;
            }
            if($a->getScore() < $b->getScore()){
                return 1;
            }
            return -1;
        });

        $this->updateAllTeamMembersScore($team);
        return $this->render('ranking.html.twig',array('rank'=>$rank));


    }

    public function updateAllTeamMembersScore($team)
    {
        $members = $team->getUsers()->toArray();
        $matches = MatchApi::getMatches();
        $em = $this->getDoctrine()->getManager();

        foreach ($members as $member){
            $scoreToAdd = 0;
            $paris = $member->getParis();
            foreach ($paris as $pari){
                if($pari->getResult() == null){
                    foreach ($matches as $match){
                        // match correspond to pari
                        if(!$match['live'] && $match['score'] && $match['team1'].'_'.$match['team2'].'_'.$match['timestamp'] == $pari->getIdMatch()){

                            $noWinnerMatch = false;
                            $noWinnerPari  = false;

                            if($match['score'][0] == $match['score'][1]){
                                $noWinnerMatch = true;
                            }
                            if($pari->getScoreTeam1() == $pari->getScoreTeam2()){
                                $noWinnerPari = true;
                            }

                            if(!$noWinnerMatch)
                                $winnerMatch = ($match['score'][0] > $match['score'][1]) ? 0 : 1;
                            if(!$noWinnerPari)
                                $winnerPari = ($pari->getScoreTeam1() > $pari->getScoreTeam2()) ? 0 : 1;

                            // score exact
                            if($pari->getScoreTeam1() == $match['score'][0] && $pari->getScoreTeam2() == $match['score'][1]){
                                $scoreToAdd += 20;
                                $pari->setResult(20);
                            }
                            // vainqueur sans score
                            elseif(isset($winnerPari) && isset($winnerMatch) && $winnerMatch == $winnerPari){
                                $scoreToAdd += 5;
                                $pari->setResult(5);
                            }
                            // mal parié
                            elseif($noWinnerPari && !$noWinnerMatch || !$noWinnerMatch && $noWinnerPari){
                                $pari->setResult(0);
                            }

                            $em->persist($pari);
                            $em->flush();
                        }
                    }
                }
            }

            $member->setScore($member->getScore() + $scoreToAdd);
            $em->persist($member);
            $em->flush();
        }
    }
}