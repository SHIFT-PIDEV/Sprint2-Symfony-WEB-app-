<?php

namespace App\Controller;


use App\Entity\Demande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class DemandeMobile extends AbstractController
{
    /**
     * @Route("/mobile/demande", name="mobile_demande")
     */
    public function listDemande (SerializerInterface $serializer)
    {
        $demande = $this->getDoctrine()->getRepository(Demande::class)->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($demande);
        return new JsonResponse($formatted);
    }





    /**
     * @Route("/mobile/newdemande", name="new_demandeMobile")
     */
    public function new(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $demande = new Demande();


        $objet=$request->get('objet');
        $description=$request->get('description');
        $cv=$request->get('cv');

        $demande->setObjet($objet);
        $demande->setDescription($description);
        $demande->setCv($cv);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($demande);
        $entityManager->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($demande);
        return new JsonResponse($formatted);



    }
    /**
     * @Route("/mobile/rechercherdemande", name="mobile_Rech_demande")
     */
    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString = $request->get('titre');

        $demande = $em->getRepository(Demande::class)->findEntitiesByString($requestString);
        if(!$demande)
        {
            $result['demande']['error']="demande introuvable :( ";

        }else{
            $result['demande']=$this->getRealEntities($demande);
        }

        return new JsonResponse($result);


    }
    public function getRealEntities($demande){
        foreach ($demande    as $demandes){
            $realEntities[$demandes->getId()] = [$demandes->getObjet(), $demandes->getDescription(),  $demandes->getCv()];
        }
        return $realEntities;
    }

    /**
     * @Route("/mobile/delete_demande", name="delete_demande")
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $demande = $entityManager->getRepository(Demande::class)->find($id);
        $entityManager->remove($demande);
        $entityManager->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($demande);
        return new JsonResponse($formatted);


    }
}