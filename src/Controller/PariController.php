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
        $date = $request->request->get('date');
        if(time() > $date){
            return new Response(json_encode(array('error' => 'Il est trop tard pour parier sur ce match')));
        }
        elseif( $score_team1 == null || $score_team2 == null || empty($team1) || empty($team2) || empty($date)){
            return new Response(json_encode(array('error' => 'erreur de donnees survenue')));
        }

        $pari->setIdMatch($team1.'_'.$team2.'_'.$date);
        $pari->setScoreTeam1($score_team1);
        $pari->setScoreTeam2($score_team2);
        $pari->setUser($this->getUser());

        $repository = $this->getDoctrine()->getRepository(Pari::class);
        $result = $repository->findOneBy(array(
            'user' => $this->getUser(),
            'id_match' => $pari->getIdMatch()
        ));

        if($result){
            $result->setScoreTeam1($score_team1);
            $result->setScoreTeam2($score_team2);
            $em = $this->getDoctrine()->getManager();
            $em->persist($result);
            $em->flush();
            return new Response(json_encode(array('success' => 'pari modifie')));
        }
        else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pari);
            $em->flush();
            return new Response(json_encode(array('success' => 'pari enregistre')));
        }

    }
}