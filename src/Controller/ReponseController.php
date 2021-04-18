<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Form\ReponseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    /**
     * @Route("/question/addreponse", name="add_reponse")
     */
    public function addreponse(Request $request): Response
    {
        $reponse = new Reponse();
        $form = $this->createForm(ReponseType::class,$reponse);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($reponse);

            $entityManager->flush();

            return $this->redirectToRoute('list_reponse');

        }

        return $this->render("reponse/addreponse.html.twig", [
            "form_title" => "Ajouter une reponse",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/reponse/delete_reponse/{idReponse}", name="delete_reponse")
     */
    public function deleteReponse(int $idReponse): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reponse = $entityManager->getRepository(Reponse::class)->find($idReponse);
        $entityManager->remove($reponse);
        $entityManager->flush();
        return $this->redirectToRoute('list_reponse');
    }
    /**
     * @Route("/reponse/listreponse", name="list_reponse")
     */
    public function listReponse(Request $request)
    {
        $reponse = $this->getDoctrine()->getRepository(Reponse::class)->findAll();

        return $this->render('reponse/reponses.html.twig', [
            "reponse" => $reponse,]);
    }
    /**
     * @Route("/reponse/edit_reponse/{idReponse}", name="edit_reponse")
     */
    public function editReponse(Request $request, int $idReponse): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $Reponse = $entityManager->getRepository(Reponse::class)->find($idReponse);
        $form = $this->createForm(ReponseType::class,$Reponse);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

            return $this->redirectToRoute('list_reponse');

        }

        return $this->render("reponse/edit_reponse.html.twig", [
            "form_title" => "Modifier une reponse",
            "form" => $form->createView(),
        ]);
    }
}
