<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Paymentmethod;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class MobilePanierController extends AbstractController
{
    /**
     * @Route("/mobile/panier", name="mobile_panier")
     * @throws ExceptionInterface
     */
    public function listpanier(SerializerInterface $serializer)
    {
        $cart = $this->getDoctrine()->getRepository(Cart::class)->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($cart);
        return new JsonResponse($formatted);
    }
    public function getRealEntities($cart){
        foreach ($cart as $cart){
            $realEntities[$cart->getId()] = [$cart->getNom(),  $cart->getPrix()];
        }
        return $realEntities;
    }

    /**
     * @Route("/mobile/delcart", name="delcart")
     */
    public function delete(Request $request)
    {
        $idcart = $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $cart = $entityManager->getRepository(Cart::class)->find($idcart);
        $entityManager->remove($cart);
        $entityManager->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($cart);
        return new JsonResponse($formatted);


    }
}