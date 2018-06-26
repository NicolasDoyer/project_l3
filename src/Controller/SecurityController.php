<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController{

  public function login(AuthenticationUtils $helper) :Response {

    $authError = $helper->getLastAuthenticationError();
    if($authError) {
      $this->addFlash('error', 'Mot de passe ou  email invalide');
    }
    return $this->render('Security/login.html.twig', [
      'last_username' => $helper->getLastUsername()
    ]);
  }

  public function logout(){
    throw new \Exception('This should never be reached !');
  }
}
