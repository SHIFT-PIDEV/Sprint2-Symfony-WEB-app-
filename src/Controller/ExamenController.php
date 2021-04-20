<?php

namespace App\Controller;

use App\Entity\Examen;
use App\Entity\Question;
use App\Form\ExamenType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ExamenController extends AbstractController
{

    /**
     * @Route("/examen/addexamen", name="add_examen")
     */
    public function addexamen(Request $request,\Swift_Mailer $mailer): Response
    {
        $Examen = new Examen();
        $form = $this->createForm(ExamenType::class,$Examen);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Examen);

            $entityManager->flush();

            // block mailing

            $message = (new \Swift_Message('You Got Maillllll!'))
                ->setFrom('space.upgardi@gmail.com')
                ->setTo('youssefelmahdi.bouchouicha@esprit.tn')
                ->setBody('new exam in the list check our site thanks');
            $mailer->send($message);
            // endblock mailing

            return $this->redirectToRoute('list_examen');

        }

        return $this->render("examen/addexamen.html.twig", [
            "form_title" => "Ajouter un Examen",
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/examen/delete_examen/{idExamen}", name="delete_examen")
     */
    public function deleteExamen(int $idExamen): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $examen = $entityManager->getRepository(Examen::class)->find($idExamen);
        $entityManager->remove($examen);
        $entityManager->flush();

       return $this->redirectToRoute('list_examen');
    }
    /**
     * @Route("/examen/listexamen", name="list_examen")
     */
    public function listExamen(Request $request, PaginatorInterface $paginator)
    {
        $examen = $this->getDoctrine()->getRepository(Examen::class)->findAll();
        $pagination = $paginator->paginate(
            $examen,
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );


        return $this->render('examen/examens.html.twig',[
            "examen" =>$pagination,
            ]);
    }

    /**
     * @Route("/examen/edit_examen/{idExamen}", name="edit_examen")
     * @param Request $request
     * @param int $idExamen
     * @param $mailer
     * @return Response
     */
    public function editExamen(Request $request, int $idExamen): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $Examen = $entityManager->getRepository(Examen::class)->find($idExamen);
        $form = $this->createForm(ExamenType::class,$Examen);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

                //block SMS
            $basic  = new \Vonage\Client\Credentials\Basic("42f59c7b", "3XaRw1fJ8FnfuRMy");
            $client = new \Vonage\Client($basic);

            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS("21620823189", "UPGRADI.TN", 'Examen modifier avec succes')
            );

            $message = $response->current();

            if ($message->getStatus() == 0) {
                echo "The message was sent successfully\n";
            } else {
                 echo "The message failed with status: " . $message->getStatus() . "\n";
            }
            //end block SMS


            return $this->redirectToRoute('list_examen');

        }

        return $this->render("examen/edit_examen.html.twig", [
            "form_title" => "Modifier un examen",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/examen/listexamenAfterRech", name="list_examenAfterRech")
     */
    public function researchByTitre(Request $request)
    {   $entityManager = $this->getDoctrine()->getManager();
        $examen = $entityManager->getRepository(Examen::class)->findAll();
        if($request->isMethod("GET"))
        {
            $titre=$request->get('searchbar');

            $examen = $entityManager->getRepository(Examen::class)->findBy(array('titre' => $titre));

        }
        return $this->render('examen/examensAfterRech.html.twig', [
            "examen" => $examen,]);
    }
////////////////////////////////////Front //////////////////
    /**
     * @Route("/examen/listexamenF", name="list_examen_Front")
     */
    public function listExamenFront(Request $request, PaginatorInterface $paginator)
    {
        $examen = $this->getDoctrine()->getRepository(Examen::class)->findAll();
        $pagination = $paginator->paginate(
            $examen,
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );


        return $this->render('examen/FrontExamen_list.html.twig',[
            "examen" =>$pagination,
        ]);
    }

}
