<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomeController extends Controller {
    function index() {
        return $this->render('home.html.twig');
    }
}