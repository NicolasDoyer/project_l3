<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TeamController extends Controller {

    public function createAction(Request $request){

        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $repository = $this->getDoctrine()->getRepository(Team::class);

            do{
                $tag = Team::generateTag();
            }while($repository->findOneBy(['tag' => $tag]));

            $team->setTag($tag);
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();

            $user = $this->getUser();
            $user->setTeam($team);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('index');
        }
    }

    public function joinAction(Request $request){

        $user = $this->getUser();
        $teamTag = $request->request->get('tag');
        $repository = $this->getDoctrine()->getRepository(Team::class);
        $team = $repository->findOneBy(array('tag' => $teamTag));

        if($team){
            $user->setTeam($team);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success','Team joined !');
        }
        else{
            $this->addFlash('error', 'Tag does not exist');
        }

        return $this->redirectToRoute('index');
    }
}