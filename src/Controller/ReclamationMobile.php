<?php

namespace App\Controller;


use App\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ReclamationMobile extends AbstractController
{
    /**
     * @Route("/mobile/reclamation", name="mobile_reclamation")
     */
    public function listReclamation (SerializerInterface $serializer)
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse($formatted);
    }





    /**
     * @Route("/mobile/newreclamation", name="new_reclamationMobile")
     */
    public function new(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reclamation = new Reclamation();


        $objet=$request->get('objet');
        $description=$request->get('description');



        $reclamation->setObjet($objet);
        $reclamation->setDescription($description);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reclamation);
        $entityManager->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse($formatted);



    }
    /**
     * @Route("/mobile/recherchereclamation", name="mobile_Rech_reclamation")
     */
    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString = $request->get('titre');

        $reclamation = $em->getRepository(Reclamation::class)->findEntitiesByString($requestString);
        if(!$reclamation)
        {
            $result['reclamation']['error']="reclamation introuvable :( ";

        }else{
            $result['reclamation']=$this->getRealEntities($reclamation);
        }

        return new JsonResponse($result);


    }
    public function getRealEntities($reclamation){
        foreach ($reclamation    as $reclamations){
            $realEntities[$reclamations->getId()] = [$reclamations->getObjet(), $reclamations->getDescription()];
        }
        return $realEntities;
    }

    /**
     * @Route("/mobile/delete_reclamation", name="delete_reclamation")
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $reclamation = $entityManager->getRepository(Reclamation::class)->find($id);
        $entityManager->remove($reclamation);
        $entityManager->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse($formatted);


    }
}