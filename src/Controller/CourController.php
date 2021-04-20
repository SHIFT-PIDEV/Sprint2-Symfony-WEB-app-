<?php

namespace App\Controller;

use App\Entity\Cour;
use App\Form\CourType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


class CourController extends AbstractController
{
    /**
     * @Route("/cour/addcour", name="add_cour")
     */
    public function addcour(Request $request): Response
    {
        $cour = new Cour();
        $form = $this->createForm(CourType::class,$cour);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($cour);

            $entityManager->flush();

            return $this->redirectToRoute('list_cour');

        }

        return $this->render("cour/addcour.html.twig", [
            "form_title" => "Ajouter un cour",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/cour/delete_cour/{idCour}", name="delete_cour")
     */
    public function deleteCour(int $idCour): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cour = $entityManager->getRepository(cour::class)->find($idCour);
        $entityManager->remove($cour);
        $entityManager->flush();
        return $this->redirectToRoute('list_cour');
    }

    /**
     * @Route("/cour/listcour", name="list_cour")
     */
    public function listCour(Request $request,PaginatorInterface $paginator)
    {
        $cour = $this->getDoctrine()->getRepository(Cour::class)->findAll();

        $pagination = $paginator->paginate(
            $cour, $request->query->getInt('page', 1), 2);

        return $this->render('cour/cours.html.twig',["cour"=>$pagination]);
    }
    /**
     * @Route("/cour/edit_cour/{idCour}", name="edit_cour")
     */
    public function editCour(Request $request, int $idCour): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $Cour = $entityManager->getRepository(Cour::class)->find($idCour);
        $form = $this->createForm(CourType::class,$Cour);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

            return $this->redirectToRoute('list_cour');

        }

        return $this->render("cour/edit_cour.html.twig", [
            "form_title" => "Modifier un cour",
            "form" => $form->createView(),
        ]);
    }
    ////////////////////////////////////Front //////////////////
    /**
     * @Route("/examen/listcourF", name="list_cour_Front")
     */
    public function listCourFront(Request $request, PaginatorInterface $paginator)
    {
        $cour = $this->getDoctrine()->getRepository(Cour::class)->findAll();

        $pagination = $paginator->paginate(
            $cour, $request->query->getInt('page', 1), 2


        );


        return $this->render('cour/FrontCour_list.html.twig',[
            "cour" =>$pagination,
        ]);
    }

    /**
     * @Route("/cour/courDetails/{idcour}", name="cour_details")
     */
    public function aff_courdetails(int $idcour)
    {   $entityManager = $this->getDoctrine()->getManager();

        $cour = $entityManager->getRepository(cour::class)->find($idcour);


        return $this->render('cour/FrontCourDetails.html.twig', [
            "cour" => $cour,]);
    }
}
