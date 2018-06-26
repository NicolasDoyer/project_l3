<?php
/**
 * Created by PhpStorm.
 * User: masterinfo
 * Date: 26/06/18
 * Time: 09:45
 */

namespace App\Controller;


use App\Entity\Pari;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PariController extends Controller
{
    public function create(Request $request){

        $pari = new Pari();
        $team1 = $request->request->get('team1');
        $team2 = $request->request->get('team2');
        $score_team1 = $request->request->get('score_team1');
        $score_team2 = $request->request->get('score_team2');
        $date = strtotime($request->request->get('date'));

        $pari->setIdMatch($team1.'_'.$team2.'_'.$date);
        $pari->setScoreTeam1($score_team1);
        $pari->setScoreTeam2($score_team2);
        $pari->setUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($pari);
        $em->flush();

        return new Response('ok');
    }
}