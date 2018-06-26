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
        $rank = $this->getUser()->getTeam()->getUsers();


        return $this->render('ranking.html.twig',array('rank'=>$rank));


    }
}