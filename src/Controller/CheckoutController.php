<?php

namespace App\Controller;

use App\Entity\Paymentmethod;
use App\Form\PaymentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout/add", name="add_pm")
     */
    public function add(Request $request): Response
    {
        $Paymentmethod = new Paymentmethod();
        $form = $this->createForm(PaymentType::class,$Paymentmethod);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Paymentmethod);

            $entityManager->flush();

            return $this->redirectToRoute('list_pm');

        }

        return $this->render("checkout/add.html.twig", [
            "form_title" => "Ajouter une methode de payement",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/checkout/list", name="list_pm")
     */
    public function list(Request $request)
    {
        $Paymentmethod = $this->getDoctrine()->getRepository(Paymentmethod::class)->findAll();

        return $this->render('checkout/list.html.twig', [
            "nom" => $Paymentmethod,]);
    }
    /**
     * @Route("/checkout/success", name="success")
     */
    public function success(Request $request)
    {

        return $this->render('checkout/success.html.twig');
    }
    /**
     * @Route("/checkout/delete/{id}", name="delete_pm")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Paymentmethod = $entityManager->getRepository(Paymentmethod::class)->find($id);
        $entityManager->remove($Paymentmethod);
        $entityManager->flush();
        return $this->redirectToRoute('add_pm');
    }
    /**
     * @Route("/checkout/edit/{id}", name="edit_pm")
     */
    public function edit(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $Paymentmethod = $entityManager->getRepository(Paymentmethod::class)->find($id);
        $form = $this->createForm(PaymentType::class,$Paymentmethod);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

            return $this->redirectToRoute('list_pm');

        }

        return $this->render("checkout/edit.html.twig", [
            "form_title" => "Modifier vos informations",
            "form" => $form->createView(),
        ]);
    }
}
