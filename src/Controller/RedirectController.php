<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{

    /**
     * @Route("/backoffice", name="back")
     */
    public function backOffice(): Response
    {
        return $this->render('DashbordBack.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    /**
     * @Route("/frontoffice", name="front")
     */
    public function frontoffice(): Response
    {
        return $this->render('Front_Body.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('login.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    /**
     * @Route("/signup", name="signup")
     */
    public function signup(): Response
    {
        return $this->render('signup.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
