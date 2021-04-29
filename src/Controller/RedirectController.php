<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{

    /**
     * @Route("/backend", name="back")
     */
    public function backend(): Response
    {
        return $this->render('dashboard.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
