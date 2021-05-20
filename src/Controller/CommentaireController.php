<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\Event;
use App\Repository\CommentaireRepository;
use App\Repository\EventRepository;
use App\Repository\InscrieventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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

    /* ******************** partie JSON  ************/
    /**
     * @route("/getCommsJSON/{idevent}",name="AllCommsJSON")
     * @param $idevent
     * @param CommentaireRepository $repo
     * @param NormalizerInterface $normalizer
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     */
    public  function commsList($idevent,CommentaireRepository $repo,NormalizerInterface $normalizer,Request $request): Response
    {
        $event=$this->getDoctrine()->getRepository(Event::class)->find($idevent);
        $comms=$repo->findBy([
            'event'=>$event
        ]);
        $jsonContent = $normalizer->normalize($comms, 'json',['groups'=>'com']);
        $r=json_encode($jsonContent);
        return new Response($r);

    }
    /**
     * @param Request $request
     * @param NormalizerInterface $formatter
     * @return Response
     * @throws ExceptionInterface
     * @Route("/addCommJSON",name="addCommm")
     */
    public function addCommm(Request $request,NormalizerInterface $formatter){
        $comm=new Commentaire();
        $client=$this->getDoctrine()->getRepository(Client::class)->find($request->get('idclient'));
        $event=$this->getDoctrine()->getRepository(Event::class)->find($request->get('idevent'));
        $comm->setClient($client);
        $comm->setEvent($event);
        $comm->setDatecomm(new \DateTime());
        $comm->setDesccomm($request->get('desc'));
        $mn=$this->getDoctrine()->getManager();
        $mn->persist($comm);
        $mn->flush();
        $jsonContent =$formatter->normalize($comm,'json',['groups'=>'com']);

        return new Response(json_encode($jsonContent));
    }


}
