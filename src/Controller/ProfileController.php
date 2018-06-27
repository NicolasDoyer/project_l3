<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller {

    function index(Request $request) {

        $user = $this->getUser();
        $team = $user->getTeam();

        return $this->render('profile.html.twig', array("team" => $team));

    }

    function deleteAction(Request $request) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($user);
        $em->flush();

        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();

        return $this->redirectToRoute("index");
    }
}