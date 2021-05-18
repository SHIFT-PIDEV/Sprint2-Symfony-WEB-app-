<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Examen;
use App\Entity\Inscripexam;
use App\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class MobileRatingController extends AbstractController
{
    /**
     * @Route("/mobile/rating", name="mobile_rating")
     */
    public function listRating(SerializerInterface $serializer)
    {
        $rate = $this->getDoctrine()->getRepository(Rating::class)->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rate);
        return new JsonResponse($formatted);
    }





    /**
     * @Route("/mobile/newcomment", name="new_commentaireMobile")
     */
    public function new(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $rating = new Rating();
        $client= new Client();
        $idexam=$request->get('idexam');

        $com=$request->get('commentaire');


        $client=$entityManager->getRepository(Client::class)->find(4);
        $exam = $entityManager->getRepository(Examen::class)->find($idexam);
        $rating->setIdexam($idexam);
        $rating->setIdclient(4);
        $rating->setCommentaire($com);
        $rating->setRate(2);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rating);
        $entityManager->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rating);
        return new JsonResponse($formatted);



    }

}
