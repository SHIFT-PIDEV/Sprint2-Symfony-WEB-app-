<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\PanierType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier/addtocart", name="add_cart")
     */
    public function addtocart(Request $request): Response
    {
        $Panier = new Panier();
        $form = $this->createForm(PanierType::class,$Panier);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Panier);

            $entityManager->flush();

            return $this->redirectToRoute('list_cart');

        }

        return $this->render("panier/addtocart.html.twig", [
            "form_title" => "Ajouter au panier",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/panier/listcart", name="list_cart")
     */
    public function listcart(Request $request)
    {
        $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();

        return $this->render('panier/list_cart.html.twig', [
            "idcour" => $panier,]);
    }
    /**
     * @Route("/panier/delete/{id}", name="delete_cart")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $panier = $entityManager->getRepository(Panier::class)->find($id);
        $entityManager->remove($panier);
        $entityManager->flush();
        return $this->redirectToRoute('list_cart');
    }
    /**
     * @Route("/panier/edit/{id}", name="edit_cart")
     */
    public function editQuestion(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $panier = $entityManager->getRepository(Panier::class)->find($id);
        $form = $this->createForm(PanierType::class,$panier);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

            return $this->redirectToRoute('list_cart');

        }

        return $this->render("panier/edit_cart.html.twig", [
            "form_title" => "Modifier un element",
            "form" => $form->createView(),
        ]);
    }
}
