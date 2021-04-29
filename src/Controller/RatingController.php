<?php

namespace App\Controller;

use App\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RatingController extends AbstractController
{
    /**
     * @Route("/rating", name="rating")
     */
    public function index(): Response
    {
        return $this->render('rating/index.html.twig', [
            'controller_name' => 'RatingController',
        ]);
    }
    /**
     * @Route("/addrating", name="add_rating")
     */
    public function addexamen(Request $request): Response
    {
        $rate = new Rating();
        $requestString = $request->get('ratedIndex');
        $commentaire = $request->get('com');
        $idexam = $request->get('idexam');
        $idclient = $request->get('idclient');
        $rate=$rate->setRate($requestString);
        $rate=$rate->setCommentaire($commentaire);
        $rate=$rate->setIdexam($idexam);
        $rate=$rate->setIdclient($idclient);


        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($rate);

        $entityManager->flush();







    }
}
