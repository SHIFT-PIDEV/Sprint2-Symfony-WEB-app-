<?php

namespace App\Controller;

use App\Entity\Rating;
use App\Form\RatingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RatingController extends AbstractController
{
    /**
     * @Route("/rating/addrating", name="add_rating")
     */
    public function addrating(Request $request): Response
    {
        $Rating = new Rating();
        $form = $this->createForm(RatingType::class,$Rating);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Rating);

            $entityManager->flush();


            return $this->redirectToRoute('list_rating');

        }

        return $this->render("rating/addrating.html.twig", [
            "form_title" => "Ajouter votre avis:",
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/rating/listrating", name="list_rating")
     */
    public function listrating(Request $request)
    {
        $Rating = $this->getDoctrine()->getRepository(Rating::class)->findAll();

        return $this->render('rating/listrating.html.twig', [
            "commentaire" => $Rating,]);
    }
    /**
     * @Route("/rating/delete/{id}", name="delete_rating")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Rating = $entityManager->getRepository(Rating::class)->find($id);
        $entityManager->remove($Rating);
        $entityManager->flush();
        return $this->redirectToRoute('list_rating');
    }
    /**
     * @Route("/rating/edit/{id}", name="edit_rating")
     */
    public function edit(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $Rating = $entityManager->getRepository(Rating::class)->find($id);
        $form = $this->createForm(RatingType::class,$Rating);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

            return $this->redirectToRoute('list_rating');

        }

        return $this->render("rating/editrating.html.twig", [
            "form_title" => "Modifier votre rating",
            "form" => $form->createView(),
        ]);
    }
}
