<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\Event;
use App\Entity\Likeevent;
use App\Form\CommentaireType;
use App\Form\EventType;
use App\Repository\CommentaireRepository;
use App\Repository\EventRepository;
use App\Repository\InscrieventRepository;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Snipe\BanBuilder\CensorWords;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/*import pour la partie mobile */

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

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
            /*$image->move(
                $this->getParameter('java_directory'),
                $fichier1
            );*/

            $event->setPic($fichier1);
            $var="/images/events.png";
            $event->setImage("$var");

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
            $image->move(
                $this->getParameter('java_directory'),
                $fichier1
            );
            //on stocke l'image dans la base de données
            $event->setPic($fichier1);
            $var="/images/".$fichier1."";
            $event->setImage("$var");
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
        $censor = new CensorWords;
        $lang = array('fr','en-us');
        $censor->setDictionary($lang);
        return $this->render("front/eventDetails.html.twig",array(
            'event'=>$event,
            'client'=>$client,
            'form'=>$form->createView(),
            'censor'=>$censor,
            'commentaires'=>$CommentairesList
        ));
    }

    /**
     * @param Event $event
     * @param LikeRepository $likeRepository
     * @param FlashyNotifier $flashy
     * @return JsonResponse|RedirectResponse
     * @Route("/event/{idevent}/like",name="likeevent")
     */
    public function gestionDesLike(Event $event,LikeRepository $likeRepository,FlashyNotifier $flashy)
    {

        $client=$this->getUser();
        if(!$client){
            $flashy->mutedDark('You should be connected to react with an event');
            return $this->redirectToRoute('app_login');
        }
        elseif($event->isLikedByUser($client)){
            $like=$likeRepository->findOneBy([
                'event'=>$event,
                'client'=>$client
            ]);
            $em=$this->getDoctrine()->getManager();
            $em->remove($like);
            $em->flush();
        }

        else{
            $like1=new Likeevent();
            $like1->setEvent($event)
                ->setClient($client);
            $em=$this->getDoctrine()->getManager();
            $em->persist($like1);
            $em->flush();
        }

        return $this->json([
            'code'=>200,'message'=>'ca marche bien',
            'nbLikes'=>$likeRepository->count(['event'=>$event])
        ],
            200);
       // return $this->redirectToRoute('firstPage');
    }

    /* ******************** partie JSON  ************/
    /**
     * @route("/AllUsersJSON",name="AllUsersJSON")
     * @param EventRepository $repo
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     */
    public  function EventList(EventRepository  $repo,NormalizerInterface $normalizer): Response
    {
        $events=$repo->findAll();
        $jsonContent = $normalizer->normalize($events, 'json',['groups'=>'US']);

        $r=json_encode($jsonContent);
        return new Response($r);

    }

    /**
     * @param Request $request
     * @param NormalizerInterface $formatter
     * @return Response
     * @throws ExceptionInterface
     * @Route("/addLikeJSON",name="addLikeJSON")
     */
    public function addLike(Request $request,NormalizerInterface $formatter){
        $like=new Likeevent();
        $client=$this->getDoctrine()->getRepository(Client::class)->find($request->get('idclient'));
        $event=$this->getDoctrine()->getRepository(Event::class)->find($request->get('idevent'));

        $like->setClient($client);
        $like->setEvent($event);
        $mn=$this->getDoctrine()->getManager();
        $mn->persist($like);
        $mn->flush();
        $jsonContent =$formatter->normalize($like,'json',['groups'=>'like']);

        return new Response(json_encode($jsonContent));
    }
    /**
     * @param Request $request
     * @param NormalizerInterface $formatter
     * @return Response
     * @throws ExceptionInterface
     * @Route("/deleteLikeJSON",name="deleteLikeJSON")
     */
    public function deleteLike(Request $request,NormalizerInterface $formatter){
        $like=$this->getDoctrine()->getRepository(Likeevent::class)->findAll();
        $client=$this->getDoctrine()->getRepository(Client::class)->find($request->get('idclient'));
        $event=$this->getDoctrine()->getRepository(Event::class)->find($request->get('idevent'));
        $like1=$this->getDoctrine()->getRepository(Likeevent::class)->findOneBy([
            'client'=>$client,
            'event'=>$event
        ]);
        $mn=$this->getDoctrine()->getManager();
        if($like1!=null){
            $mn->remove($like1);
            $mn->flush();
        }

        $jsonContent =$formatter->normalize($like,'json',['groups'=>'like']);

        return new Response(json_encode($jsonContent));
    }
    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     * @Route("/like/testLikeExist/{idclient}/{idevent}",name="testLike")
     */
    public function getLike(Request $request,NormalizerInterface $normalizer){
        $client=$this->getDoctrine()->getRepository(Client::class)->find($request->get('idclient'));
        $event=$this->getDoctrine()->getRepository(Event::class)->find($request->get('idevent'));
        $like= $this->getDoctrine()->getRepository(Likeevent::class)->findBy([
            'client'=>$client,
            'event'=>$event
        ]);

        $jsonContent1 =$normalizer->normalize($like,'json',['groups'=>'like']);
        return new Response(json_encode($jsonContent1));
    }

    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     * @Route ("/MyEventsJSON",name="MyEventsJSON")
     */
    public function myEventsJSON(Request $request,NormalizerInterface $normalizer): Response
    {
        $client=$this->getDoctrine()->getRepository(Client::class)->find($request->get('idclient'));
        $events= array();
        $n=sizeof($client->getInscriptions());
        for( $i=0;$i<$n;$i++){
            $events[$i]=$this->getDoctrine()->getRepository(Event::class)->find($client->getInscriptions()[$i]->getEvent()->getidevent());
        }
        $jsonContent=$normalizer->normalize($events,'json',['groups'=>'US']);
        $r=json_encode($jsonContent);
        return new Response($r);
    }
}
