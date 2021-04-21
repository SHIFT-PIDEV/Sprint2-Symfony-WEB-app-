<?php

namespace App\Controller;

use App\Entity\Examen;
use App\Entity\Inscripexam;
use App\Entity\Reponse;
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
    public function new(Request $request , int $idexam,\Swift_Mailer $mailer): Response
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

            // block mailing

            $message = (new \Swift_Message('You Got Mail!'))
                ->setFrom('space.upgardi@gmail.com')
                ->setTo($inscripexam->getEmail())
                ->setBody(' <p>Bonjour '.$inscripexam->getPrenom().' '.$inscripexam->getNom().',</p>'
                    .'<p> Votre inscription est validée le :'.  $inscripexam->getDateinscri()->format('Y-m-d') .',</p>'
                    .'<p>  vous etes inscrits dans lexamen : '.$exam->getTitre().',</p>'
                    .'<p>  qui aura lieu le '.$inscripexam->getIdexam()->getDate()->format('Y-m-d').',</p>'
                    .'<p>  on vous souhaite une bonne chance ! BYE BYE . </p>'
                    .'<a href="http://127.0.0.1:8000/examen/listexamenF"> consulter notre site ');
            $mailer->send($message);
            // endblock mailing

            return $this->redirectToRoute('list_mes_exam');
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
     * @Route("/passageexam/{idinscri}", name="passage_exam")
     */
    public function PassageExam(int $idinscri)
    {   $entityManager = $this->getDoctrine()->getManager();
        $inscri =new inscripexam;
        $inscripexam = $entityManager->getRepository(Inscripexam::class)->find($idinscri);

       //$r1 = $entityManager->getRepository(Reponse::class)->find($inscripexam->getIdexam()->getQ());
        $r1 = $entityManager->getRepository(Reponse::class)->findBy(array('reponsec' => $inscripexam->getIdexam()->getQ()));
        $r2 = $entityManager->getRepository(Reponse::class)->findBy(array('reponsec' => $inscripexam->getIdexam()->getQq()));
        $r3 = $entityManager->getRepository(Reponse::class)->findBy(array('reponsec' => $inscripexam->getIdexam()->getQqq()));



        return $this->render('inscripexam/Passage_examen.html.twig', [
            "inscripexam" => $inscripexam, "r1" => $r1 ,"r2" => $r2 ,"r3" => $r3 ,
        ]);
    }

}
