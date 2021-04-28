<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Reclamation;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{

    /**
     * @Route("/backoffice", name="back")
     */
    public function backOffice(): Response
    {
        return $this->render('DashbordBack.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    /**
     * @Route("/frontoffice", name="front")
     */
    public function frontoffice(): Response
    {
        return $this->render('Front_Body.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('login.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    /**
     * @Route("/signup", name="signup")
     */
    public function signup(): Response
    {
        return $this->render('signup.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }


    ///////////////////////////////
    ///
    /**
     * @Route("/nt", name="nt")
     */
    public function nt(Request $request, PaginatorInterface $paginator): Response
    {
        $demandes = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findAll();
        $pagination = $paginator->paginate(
            $demandes,
            $request->query->getInt('page', 1), 3
        );
        return $this->render('demande/index2.html.twig', [
            'demandes' => $pagination,
        ]);
    }
    /**
     * @Route("/ntR", name="ntR", methods={"GET"})
     */
    public function ntR(Request $request, PaginatorInterface $paginator): Response
    {
        $reclamations = $this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findAll();
        $pagination = $paginator->paginate(
            $reclamations,
            $request->query->getInt('page', 1), 3
        );
        return $this->render('reclamation/index2.html.twig', [
            'reclamations' => $pagination,
        ]);
    }
}
