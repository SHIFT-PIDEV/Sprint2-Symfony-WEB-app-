<?php

namespace App\Controller;

use App\Entity\Cour;
use App\Entity\Examen;
use App\Entity\Package;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class MobilecoursController extends AbstractController
{
    /**
     * @Route("/mobile/cour", name="mobile_cour")
     */
    public function listcour(SerializerInterface $serializer)
    {
        $cour = $this->getDoctrine()->getRepository(Cour::class)->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($cour);
        return new JsonResponse($formatted);
    }
    /**
     * @Route("/mobile/coursTrier", name="mobile_coursTrier")
     */
    public function listcoursTrier(SerializerInterface $serializer)
    {
        $cour = $this->getDoctrine()->getRepository(Cour::class)->findBy(array(),array("prix"=>"ASC"));


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($cour);
        return new JsonResponse($formatted);
    }
    /**
     * @Route("/mobile/package", name="mobile_package")
     */
    public function listpackage(SerializerInterface $serializer)
    {
        $pack = $this->getDoctrine()->getRepository(Package::class)->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($pack);
        return new JsonResponse($formatted);
    }
}
