<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Examen;
use App\Entity\Inscripexam;
use App\Entity\Reponse;
use App\Form\InscripexamType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class MobileExamController extends AbstractController
{
    /////////////////////////////////////Block webservice des examens ///////////////////
    /**
     * @Route("/mobile/exam", name="mobile_exam")
     */
    public function listexamen(SerializerInterface $serializer)
    {
        $examen = $this->getDoctrine()->getRepository(Examen::class)->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($examen);
        return new JsonResponse($formatted);
    }

    /////////////////////////////////////EndBlock webservice des examens ///////////////////





    /////////////////////////////////////Block webservice des inscription ///////////////////
    /**
     * @Route("/mobile/newinscri", name="inscripexam_newmobile")
     */
    public function new(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $inscripexam = new Inscripexam();
        $client= new Client();
        $idexam=$request->get('idexam');

        $nom=$request->get('nom');
        $prenom=$request->get('prenom');
        $email=$request->get('email');

        $client=$entityManager->getRepository(Client::class)->find(4);
        $exam = $entityManager->getRepository(Examen::class)->find($idexam);
        $inscripexam->setIdexam($exam);
        $inscripexam->setIdclient($client);
        $inscripexam->setNom($nom);
        $inscripexam->setPrenom($prenom);
        $inscripexam->setEmail($email);




            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inscripexam);
            $entityManager->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($inscripexam);
        return new JsonResponse($formatted);



    }

    /**
     * @Route("/mobile/mesexamens", name="list_mes_exam")
     */
    public function mesExamens(Request $request)
    {   $entityManager = $this->getDoctrine()->getManager();

        $idc=4;

        $inscripexam = $entityManager->getRepository(Inscripexam::class)->findBy(array('idclient' => $idc));

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($inscripexam);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/mobile/delete_inscrimobile", name="delete_inscripexamMobile")
     */
    public function delete(Request $request)
    {
        $idinscri = $request->get('idinscri');
        $entityManager = $this->getDoctrine()->getManager();
        $inscripexam = $entityManager->getRepository(Inscripexam::class)->find($idinscri);
        $entityManager->remove($inscripexam);
        $entityManager->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($inscripexam);
        return new JsonResponse($formatted);


    }

    /**
     * @Route("/mobile/passageexammobile", name="passage_examMobile")
     */
    public function PassageExam(Request $request)
    {
        $idexam=$request->get('idexam');
        $entityManager = $this->getDoctrine()->getManager();

        $inscripexam = $entityManager->getRepository(Examen::class)->find($idexam);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($inscripexam);
        return new JsonResponse($formatted);



    }
    /////////////////////////////////////EndBlock webservice des inscription ///////////////////
}
