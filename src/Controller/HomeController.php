<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends Controller {

    function index(Request $request) {

        $team = new Team();
        $form = $this->createForm(TeamType::class, $team, array(
            'action' => $this->generateUrl('team_create')
        ));
        return $this->render('home.html.twig',
            array('form' => $form->createView())
        );
    }
}