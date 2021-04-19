<?php

namespace App\Controller;

use App\Entity\Examen;
use App\Entity\Inscripexam;
use App\Form\InscripexamType;
use http\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inscripexam")
 */
class InscripexamController extends AbstractController
{
    /**
     * @Route("/inscripexam", name="inscripexam_index", methods={"GET"})
     */
    public function index(): Response
    {
        $inscripexams = $this->getDoctrine()
            ->getRepository(Inscripexam::class)
            ->findAll();

        return $this->render('inscripexam/index.html.twig', [
            'inscripexams' => $inscripexams,
        ]);
    }

    /**
     * @Route("/new/{idexam}", name="inscripexam_new", methods={"GET","POST"})
     */
    public function new(Request $request , int $idexam): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $inscripexam = new Inscripexam();

        $exam = $entityManager->getRepository(Examen::class)->find($idexam);
        $inscripexam->setIdexam($exam);

        $form = $this->createForm(InscripexamType::class, $inscripexam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inscripexam);
            $entityManager->flush();
            return $this->redirectToRoute('inscripexam_index');
        }

        return $this->render('inscripexam/new.html.twig', [
            'inscripexam' => $inscripexam,'exam' => $exam,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idinscri}", name="inscripexam_show", methods={"GET"})
     */
    public function show(Inscripexam $inscripexam): Response
    {
        return $this->render('inscripexam/show.html.twig', [
            'inscripexam' => $inscripexam,
        ]);
    }

    /**
     * @Route("/{idinscri}/edit", name="inscripexam_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inscripexam $inscripexam): Response
    {
        $form = $this->createForm(InscripexamType::class, $inscripexam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inscripexam_index');
        }

        return $this->render('inscripexam/edit.html.twig', [
            'inscripexam' => $inscripexam,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/inscripexam/delete_inscripexam/{idinscri}", name="delete_inscripexam")
     */
    public function delete(int $idinscri): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $inscripexam = $entityManager->getRepository(Inscripexam::class)->find($idinscri);
        $entityManager->remove($inscripexam);
        $entityManager->flush();

        return $this->redirectToRoute('list_mes_exam');
    }
    /**
     * @Route("/inscripexam/mesexamens", name="list_mes_exam")
     */
    public function mesExamens(Request $request)
    {   $entityManager = $this->getDoctrine()->getManager();

            $idc=4;
            $inscripexam = $entityManager->getRepository(Inscripexam::class)->findBy(array('idclient' => $idc));


        return $this->render('inscripexam/mes_examens.html.twig', [
            "inscripexam" => $inscripexam,
            ]);
    }
    /**
     * @Route("/inscripexam/passageexam/{idinscri}", name="passage_exam")
     */
    public function PassageExam(int $idinscri)
    {   $entityManager = $this->getDoctrine()->getManager();
        $inscripexam = $entityManager->getRepository(Inscripexam::class)->find($idinscri);
        return $this->render('inscripexam/Passage_examen.html.twig', [
            "inscripexam" => $inscripexam,
        ]);
    }
}
