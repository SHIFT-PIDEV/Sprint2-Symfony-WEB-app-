<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Examen;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Console\Output\OutputInterface;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(): Response
    {

    }
    /**
     * @Route("/verifLogin", name="verif_Login")
     */
    public function verifLogin(Request $request,PaginatorInterface $paginator ): Response
    {
        $login = $_GET['login'];
        $mdp  =$_GET['mdp'];
        $client = $this->getDoctrine()->getRepository(Client::class)->findOneBy(array('username' => $login ,'mdp' => $mdp));

        if($login=="admin" && $mdp=="admin")
        {
            return $this->render('DashbordBack.html.twig',[]);
        }
        else if($client == null)
        {
            return $this->render('signup.html.twig');
        }
        else{
            $examen = $this->getDoctrine()->getRepository(Examen::class)->findAll();
            $pagination = $paginator->paginate(
                $examen,
                $request->query->getInt('page', 1), /*page number*/
                3 /*limit per page*/
            );


            return $this->render('examen/FrontExamen_list.html.twig',[
                "examen" =>$pagination,"client"=>$client,
            ]);
        }





    }
}
