<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\Event;
use App\Form\CommentaireType;
use App\Form\EventType;
use App\Repository\CommentaireRepository;
use App\Repository\EventRepository;
use App\Repository\InscrieventRepository;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class EventController extends AbstractController
{
    /**
     * @Route("/", name="firstPage")
     * @param EventRepository $repository
     * @return Response
     */
    public function upgradi(EventRepository $repository): Response
    {
        $events=$repository->findAll();

        return $this->render('event/front.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/upgradi/events", name="upgradi")
     * @param EventRepository $repository
     * @return Response
     */
    public function allEvent(EventRepository $repository): Response
    {
        $events=$repository->findAll();

        return $this->render('event/front.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @param EventRepository $repository
     * @return Response
     * @Route("/upgradi/unvailableEvents", name="unvailableEvents")
     */
    public function unavailableEvents(EventRepository $repository){
        $events=$repository->findunvailableEvents();
        return $this->render('event/front.html.twig', [
            'events' => $events,
        ]);
    }
    /**
     * @param EventRepository $repository
     * @return Response
     * @Route("/upgradi/availableEvents", name="availableEvents")
     */
    public function availableEvents(EventRepository $repository){
        $events=$repository->findvailableEvents();
        return $this->render('event/front.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @param EventRepository $repository
     * @return Response
     * @Route("/upgradi/eventsTrier", name="eventsTrier")
     */
    public function lesEventsTrier(EventRepository $repository){
        $events=$repository->trier();
        return $this->render('event/front.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @param EventRepository $er
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @Route("/event/allEvents",name="allEvents")
     */
    public function allEvents(EventRepository $er,PaginatorInterface $paginator,Request $request):Response{
        $eventsList=$paginator->paginate($er->findAllVisible(),
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('event/index.html.twig',array(
            'events'=>$eventsList,
        ));
    }

    /**
     * @param EventRepository $repository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route("event/afterSearch",name="afterSearch")
     */
    public function searchEvent(EventRepository $repository,Request $request,PaginatorInterface $paginator): Response
    {
        $data=$request->get('afterSearch');
        $eventsList=$paginator->paginate($repository->findByNameOrDesc($data),
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('event/index.html.twig',array(
            'events'=>$eventsList,
        ));
    }

    /**
     * @param Request $request
     * @param FlashyNotifier $flashy
     * @return RedirectResponse|Response
     * @Route("event/addEvent",name="addEvent")
     */
    public function addEvent(Request $request,FlashyNotifier $flashy){
        $event =new Event();
        $form =$this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $image=$form->get('pic')->getData();

            $fichier1=md5(uniqid()).'.'.$image->guessExtension();

            $image->move(
                $this->getParameter('images_directory'),
                $fichier1
            );

            $event->setPic($fichier1);

            $em=$this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            $this->addFlash('success',"Event Created successfully");
            return $this->redirectToRoute('allEvents');
        }
        elseif($form->isSubmitted()&&!$form->isValid()){
           // $this->addFlash('notsuccess',"Check your inputs");
            $flashy->error('check your inputs Please');
            return $this->render('event/addEvent.html.twig',array(
                'form'=>$form->createView()
            ));
        }
        return $this->render('event/addEvent.html.twig',array(
            'form'=>$form->createView()
        ));


    }

    /**
     * @param $idEvent
     * @param EventRepository $repository
     * @return RedirectResponse
     * @Route ("admin/event/{idEvent}",name="deleteEvent", methods="delete")
     */
    public function deleteEvent($idEvent,EventRepository $repository){
      $event=$repository->find($idEvent);
      $em=$this->getDoctrine()->getManager();
      $em->remove($event);
      $em->flush();
        $this->addFlash('success',"Event deleted successfully");
        return $this->redirectToRoute('allEvents');
    }

    /**
     * @param $idEvent
     * @param EventRepository $repository
     * @param Request $request
     * @param FlashyNotifier $flashy
     * @return RedirectResponse|Response
     * @Route("admin/event/{idEvent}",name="updateEvent",methods="GET|POST")
     */
    public function updateEvent($idEvent,EventRepository $repository,Request $request,FlashyNotifier $flashy){
        $event=$repository->find($idEvent);
        $form =$this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

            //On récupere le pic transmise
            $image=$form->get('pic')->getData();
            //on génère un nouveau nom de fichier
            $fichier1=md5(uniqid()).'.'.$image->guessExtension();
            //on copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier1
            );
            //on stocke l'image dans la base de données
            $event->setPic($fichier1);

            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success',"Event updated successfully");
            return $this->redirectToRoute('allEvents');
        }
        elseif($form->isSubmitted()&&!$form->isValid()){
            $flashy->error('check your inputs Please');
            return $this->render('event/updateEvent.html.twig',array(
                'form'=>$form->createView()
            ));
        }
        return $this->render('event/updateEvent.html.twig',array(
            'form'=>$form->createView()
        ));
    }

/*
 * partie front
 */
    /**
     * @param EventRepository $sr
     * @param Request $r
     * @return Response
     * @Route("upgradi/events/afterSearch",name="afterSearch1")
     */
    public function searchEventFront(EventRepository $sr,Request $r): Response
    {
        $email=$r->get('search1');
        $events=$sr->findByNameOrDesc2($email);
        return $this->render("event/front.html.twig",array(
            'events'=>$events
        ));
    }

    /**
     * @param $idEvent
     * @param $idClient
     * @param InscrieventRepository $repository2
     * @param Request $request
     * @param CommentaireRepository $repository3
     * @return Response
     * @Route("/upgradi/eventDetails/{idEvent}/{idClient}", name="eventDetails")
     */
    public function eventDetails($idEvent,$idClient,InscrieventRepository $repository2,Request $request,CommentaireRepository $repository3): Response
    {
        $insTable=$repository2->getByIdEvent($idEvent);
        $event=$this->getDoctrine()->getRepository(Event::class)->find($idEvent);
        $client=$this->getDoctrine()->getRepository(Client::class)->find($idClient);
        /*
         * partie add Commentaire
         */
        $comm=new Commentaire();
        $comm->setEvent($event);
        $comm->setClient($client);
        $comm->setDatecomm(new \DateTime());
        $form=$this->createForm(CommentaireType::class,$comm);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($comm);
            $em->flush();
            $this->addFlash('successComm',"Your Comment added successfully");
            return $this->redirectToRoute('eventDetails',['idClient'=>$idClient,'idEvent'=>$idEvent]);
        }
        /*
         * partie affichage commentaires
         */
        $CommentairesList=$event->getComms();

        return $this->render("front/eventDetails.html.twig",array(
            'event'=>$event,
            'client'=>$client,
            'form'=>$form->createView(),
            'commentaires'=>$CommentairesList
        ));
    }
}
