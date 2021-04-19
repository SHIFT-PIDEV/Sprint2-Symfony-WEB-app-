<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\InscrieventRepository;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class EventController extends AbstractController
{
    /**
     * @Route("/upgradi/events", name="upgradi")
     * @param EventRepository $repository
     * @return Response
     */
    public function index(EventRepository $repository): Response
    {
        $events=$repository->findAll();

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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("event/addEvent",name="addEvent")
     */
    public function addEvent(Request $request){
        $event =new Event();
        $form =$this->createForm(EventType::class,$event);
        //$form->add('Submit',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            $this->addFlash('success',"Event Created successfully");
            return $this->redirectToRoute('allEvents');
        }
        else{
            $this->addFlash('notsuccess',"Check your inputs");
        }
        return $this->render('event/addEvent.html.twig',array(
            'form'=>$form->createView()
        ));

    }

    /**
     * @param $idEvent
     * @param EventRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("admin/event/{idEvent}",name="updateEvent",methods="GET|POST")
     */
    public function updateEvent($idEvent,EventRepository $repository,Request $request){
        $event=$repository->find($idEvent);
        $form =$this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success',"Event updated successfully");
            return $this->redirectToRoute('allEvents');
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
     * @param EventRepository $repository
     * @param InscrieventRepository $repository2
     * @return Response
     * @Route("/upgradi/eventDetails/{idEvent}", name="eventDetails")
     */
    public function eventDetails($idEvent,EventRepository $repository,InscrieventRepository $repository2): Response
    {
        $event=$repository->find($idEvent);
        $insTable=$repository2->getByIdEvent($idEvent);
        return $this->render("front/eventDetails.html.twig",array(
            'event'=>$event,
            'inscriptions'=>$insTable
        ));
    }
}
