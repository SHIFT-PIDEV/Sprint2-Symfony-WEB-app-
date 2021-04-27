<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Paymentmethod;
use App\Form\PaymentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

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
    public function success(Request $request,\Swift_Mailer $mailer)
    {   
        $message = (new \Swift_Message('Order Confirmation'))
            ->setFrom('upgradiapp@gmail.com')
            ->setTo('fedisaid.ghourabi@esprit.tn')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'checkout/mail.html',
                    ['request' => $request]
                ),
                'text/html'
            );
        $mailer->send($message);


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
    public function stripe (Request $request){
        /*$stripe = new \Stripe\StripeClient("sk_test_51IUvWkGDv01GvjnlNOkQChbbj5HQVtFKplAjyhw4FrufGbRF3HPwL1cOAFJmvH0b7uRvNgiF7X7onkeHDRwRiPeH00qEINi8FO");
        $charge = $stripe->charges->create([
            'amount' => 2000,
            'currency' => 'usd',
            'source' => $request->request->get('stripeToken'), // obtained with Stripe.js
            'description' => 'My First Test Charge (created for API docs)'
        ]);*/
        // Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey('sk_test_51IUvWkGDv01GvjnlNOkQChbbj5HQVtFKplAjyhw4FrufGbRF3HPwL1cOAFJmvH0b7uRvNgiF7X7onkeHDRwRiPeH00qEINi8FO');

// Token is created using Stripe Checkout or Elements!
// Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];
        $charge = \Stripe\Charge::create([
            'amount' => 999,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token,
        ]);
    }
    /**
     * @Route("/checkout/info", name="pdf")
     */
    public function pdf(): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled',TRUE);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file

        $html = $this->renderView('checkout/list.html.twig', [
            'nom' => $this->getDoctrine()
                ->getRepository(Paymentmethod::class)->findAll(),

        ]);

        $dompdf->loadHtml($html);
        // Load HTML to Dompdf

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);


    }

}
