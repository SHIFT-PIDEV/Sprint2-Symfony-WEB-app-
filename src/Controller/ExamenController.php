<?php

namespace App\Controller;

use App\Entity\Examen;
use App\Entity\Question;
use App\Form\ExamenType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExamenController extends AbstractController
{
    /**
     * @Route("/examen/addexamen", name="add_examen")
     */
    public function addexamen(Request $request): Response
    {
        $Examen = new Examen();
        $form = $this->createForm(ExamenType::class,$Examen);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Examen);

            $entityManager->flush();

            //return $this->redirectToRoute('list_question');

        }

        return $this->render("examen/addexamen.html.twig", [
            "form_title" => "Ajouter un Examen",
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/examen/delete_examen/{idExamen}", name="delete_examen")
     */
    public function deleteExamen(int $idExamen): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $examen = $entityManager->getRepository(Examen::class)->find($idExamen);
        $entityManager->remove($examen);
        $entityManager->flush();
       return $this->redirectToRoute('list_examen');
    }
    /**
     * @Route("/examen/listexamen", name="list_examen")
     */
    public function listExamen(Request $request)
    {
        $examen = $this->getDoctrine()->getRepository(Examen::class)->findAll();

        return $this->render('examen/examens.html.twig', [
            "examen" => $examen,]);
    }
    /**
     * @Route("/examen/edit_examen/{idExamen}", name="edit_examen")
     */
    public function editExamen(Request $request, int $idExamen): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $Examen = $entityManager->getRepository(Examen::class)->find($idExamen);
        $form = $this->createForm(ExamenType::class,$Examen);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

            return $this->redirectToRoute('list_examen');

        }

        return $this->render("examen/edit_examen.html.twig", [
            "form_title" => "Modifier un examen",
            "form" => $form->createView(),
        ]);
    }
}
