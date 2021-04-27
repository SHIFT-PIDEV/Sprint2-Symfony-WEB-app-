<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/addcategorie", name="add_categorie")
     */
    public function addcategorie(Request $request): Response
    {
        $Categorie = new Categorie();
        $form = $this->createForm(CategorieType::class,$Categorie);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Categorie);

            $entityManager->flush();

            return $this->redirectToRoute('list_categorie');

        }

        return $this->render("categorie/addcategorie.html.twig", [
            "form_title" => "Ajouter une categorie",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/categorie/delete_categorie/{idCategorie}", name="delete_categorie")
     */
    public function deleteCategorie(int $idCategorie): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categorie = $entityManager->getRepository(Categorie::class)->find($idCategorie);
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('list_categorie');
    }
    /**
     * @Route("/categorie/listcategorie", name="list_categorie")
     */
    public function listCategorie(Request $request)
    {
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        return $this->render('categorie/categories.html.twig', [
            "categorie" => $categorie,]);
    }
    /**
     * @Route("/categorie/edit_categorie/{idCategorie}", name="edit_categorie")
     */
    public function editCategorie(Request $request, int $idCategorie): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $Categorie = $entityManager->getRepository(Categorie::class)->find($idCategorie);
        $form = $this->createForm(CategorieType::class,$Categorie);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('list_categorie');

        }

        return $this->render("categorie/edit_categorie.html.twig", [
            "form_title" => "Modifier une categorie",
            "form" => $form->createView(),
        ]);
    }
}
