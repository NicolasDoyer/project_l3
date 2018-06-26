<?php
/**
 * Created by PhpStorm.
 * User: masterinfo
 * Date: 26/06/18
 * Time: 09:45
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RankingController extends Controller
{
    public function view(){
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

        return $this->render('ranking.html.twig',array('rank'=>$rank));


    }
}