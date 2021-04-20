<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\Event;
use App\Repository\InscrieventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    /**
     * @param $idComm
     * @param $idEvent
     * @param $idClient
     * @param InscrieventRepository $repository2
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/upgradi/deleteComm/{idComm}/{idEvent}/{idClient}",name="deleteComm")
     */
    public function removeComm($idComm,$idEvent,$idClient,InscrieventRepository $repository2){
        $insTable=$repository2->getByIdEvent($idEvent);

        $comm=$this->getDoctrine()->getRepository(Commentaire::class)->find($idComm);
        $em=$this->getDoctrine()->getManager();
        $em->remove($comm);
        $em->flush();
        $this->addFlash('successCommDelete',"Your Comment deleted successfully");
        return $this->redirectToRoute('eventDetails',['idClient'=>$idClient,'idEvent'=>$idEvent, 'inscriptions'=>$insTable]);

    }

}
