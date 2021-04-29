<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Form\CouponType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CouponController extends AbstractController
{
    /**
     * @Route("/coupon/addcoupon", name="add_coupon")
     */
    public function addcoupon(Request $request,\Swift_Mailer $mailer)
    {
        $Coupon = new Coupon();
        $form = $this->createForm(CouponType::class,$Coupon);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Coupon);

            $entityManager->flush();
            $this->addFlash('success', 'Coupon envoyé avec succes.');

            $message = (new \Swift_Message('Coupon Created'))
                ->setFrom('upgradiapp@gmail.com')
                ->setTo('yasmine.chelbyii@gmail.com')
                ->setBody(
                    'Coupon affecté'
                );
            $mailer->send($message);

            return $this->redirectToRoute('list_coupon');

        }

        return $this->render("coupon/addcoupon.html.twig", [
            "form_title" => "Ajouter Coupon",
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/coupon/listcoupon", name="list_coupon")
     */
    public function listcoupon(Request $request)
    {
        $Coupon = $this->getDoctrine()->getRepository(Coupon::class)->findAll();

        return $this->render('coupon/listcoupon.html.twig', [
            "val" => $Coupon,]);
    }
    /**
     * @Route("/coupon/delete/{id}", name="delete_coupon")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Coupon = $entityManager->getRepository(Coupon::class)->find($id);
        $entityManager->remove($Coupon);
        $entityManager->flush();
        return $this->redirectToRoute('list_coupon');
    }
    /**
     * @Route("/coupon/edit/{id}", name="edit_coupon")
     */
    public function edit(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $Coupon = $entityManager->getRepository(Coupon::class)->find($id);
        $form = $this->createForm(CouponType::class,$Coupon);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

            return $this->redirectToRoute('list_coupon');

        }

        return $this->render("coupon/editcoupon.html.twig", [
            "form_title" => "Modifier un element",
            "form" => $form->createView(),
        ]);
    }

}
