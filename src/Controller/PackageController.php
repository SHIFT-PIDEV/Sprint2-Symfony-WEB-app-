<?php

namespace App\Controller;

use App\Entity\Package;
use App\Form\PackageType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PackageController extends AbstractController
{
    /**
     * @Route("/package/addpackage", name="add_package")
     */
    public function addpackage(Request $request): Response
    {
        $package = new Package();
        $form = $this->createForm(PackageType::class,$package);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($package);

            $entityManager->flush();

            return $this->redirectToRoute('list_package');

        }

        return $this->render("package/addpackage.html.twig", [
            "form_title" => "Ajouter un package",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/package/deletepackage/{idPackage}", name="delete_package")
     */
    public function deletePackage(int $idPackage): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $package = $entityManager->getRepository(Package::class)->find($idPackage);
        $entityManager->remove($package);
        $entityManager->flush();
        return $this->redirectToRoute('list_package');
    }
    /**
     * @Route("/package/pack", name="list_package")
     */
    public function listPackage(Request $request,PaginatorInterface $paginator)
    {
        $package = $this->getDoctrine()->getRepository(Package::class)->findAll();

        $pagination = $paginator->paginate(
            $package, $request->query->getInt('page', 1), 1);

        return $this->render('package/packages.html.twig',["package"=> $pagination]);
    }
}
