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
        $date = new \DateTime('now');
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

    /**
     *@Route("/searchajax", name="ajaxsearch")
     */
    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $examen = $em->getRepository(Examen::class)->findEntitiesByString($requestString);
        if(!$examen)
        {
            $result['examen']['error']="examen introuvable :( ";

        }else{
            $result['examen']=$this->getRealEntities($examen);
        }
        return new Response(json_encode($result));

    }
    public function getRealEntities($examen){
        foreach ($examen as $examen){
            $realEntities[$examen->getId()] = [$examen->getTitre()];
        }
        return $realEntities;
    }


    /**
     * @Route("/examen/listexamenFDetail/{id}", name="list_examen_Front_d")
     */
    public function listExamenFrontDetail(Request $request ,int $id)
    {
        $examen = $this->getDoctrine()->getRepository(Examen::class)->find($id);
         return $this->render('examen/FrontExamen_listDetails.html.twig',[
            "examen" =>$examen,
        ]);
    }
    ////////////////////////////////////////end front ///////////////////
    /////////////////////Start block Metier trier DQL////////////////////
    /**
     * @Route("/examen/listExamenASC", name="listExamen_ASC")
     */
    public function sortASCService(Request $request, PaginatorInterface $paginator)
    {
        $examen = $this->getDoctrine()->getRepository(Examen::class)->findBy(array(),array("prix"=>"ASC"));


        $pagination = $paginator->paginate(
            $examen,
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render("examen/FrontExamen_listASC.html.twig", [
            "examen" => $pagination,
        ]);

    }
    /**
     *@Route("/examen/listExamenDESC", name="listExamen_DESC")
     */
    public function sortDESCService(Request $request, PaginatorInterface $paginator)
    {
        $examen = $this->getDoctrine()->getRepository(Examen::class)->findBy(array(),array("prix"=>"DESC"));


        $pagination = $paginator->paginate(
            $examen,
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render("examen/FrontExamen_listDESC.html.twig", [
            "examen" => $pagination,
        ]);
    }
    /**
     *@Route("/examen/listExamenTitreASC", name="listExamen_TITRE")
     */
    public function sortTitreService(Request $request, PaginatorInterface $paginator)
    {
        $examen = $this->getDoctrine()->getRepository(Examen::class)->findBy(array(),array("titre"=>"ASC"));


        $pagination = $paginator->paginate(
            $examen,
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render("examen/FrontExamen_listTitre.html.twig", [
            "examen" => $pagination,
        ]);
    }
    /**
     *@Route("/examen/listExamenDateASC", name="listExamen_DATE")
     */
    public function sortDateService(Request $request, PaginatorInterface $paginator)
    {
        $examen = $this->getDoctrine()->getRepository(Examen::class)->findBy(array(),array("date"=>"ASC"));


        $pagination = $paginator->paginate(
            $examen,
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render("examen/FrontExamen_listDate.html.twig", [
            "examen" => $pagination,
        ]);
    }

    /////////////////////endblock Metier trier DQL////////////////////
}
