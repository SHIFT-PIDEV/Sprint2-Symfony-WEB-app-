<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Event;
use App\Entity\Inscrievent;
use App\Repository\InscrieventRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Monolog\Formatter\NormalizerFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class InscrieventController extends AbstractController
{
    /**
     * @Route("/inscrievent", name="inscrievent")
     */
    public function index(): Response
    {
        return $this->render('inscrievent/index.html.twig', [
            'controller_name' => 'InscrieventController',
        ]);
    }

    /**
     * @param FlashyNotifier $flashy
     * @param $idClient
     * @param $idEvent
     * @param InscrieventRepository $repository
     * @param \Swift_Mailer $mailer
     * @return Response
     * @route("/upgradi/eventDetails/inscription/{idClient}/{idEvent}",name="sinscrire")
     */
    public function addInscriEvent(FlashyNotifier $flashy,$idClient,$idEvent,InscrieventRepository $repository,\Swift_Mailer $mailer): Response
    {
        $insTest=$repository->findOneByIdClientIdEvent($idClient,$idEvent);
        $client=$this->getDoctrine()->getRepository(Client::class)->find($idClient);
        $event=$this->getDoctrine()->getRepository(Event::class)->find($idEvent);
        if($insTest==null){
            $ins=new Inscrievent();
            $ins->setClient($client);
            $ins->setEvent($event);
            $ins->setDateinscri(new \DateTime());

            $em=$this->getDoctrine()->getManager();
            $em->persist($ins);
            $em->flush();
            /*
             * SEND MAIL
             */
            $message = (new \Swift_Message('Upgradi'))
                ->setFrom('hamdiskander5@gmail.com')
                ->setTo($client->getEmail())
                ->setBody(
                    $this->renderView(
                        'front/email.html.twig',
                        ['client' => $client,'event'=>$event]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $s="votre inscription à l'événement <<".$event->getNomevent().
                ">> a été enregistrée avec succès mr ".$client->getNom()." please click here to check your mail";
            $flashy->success($s, 'https://mail.google.com/mail/u/0/#inbox');

            /*     */
            return $this->redirectToRoute('myEvents',['idclient'=>$idClient]);
        }
        else{
            $this->addFlash('warning',"vous êtes déjà inscrit à l'événement <<".$event->getNomevent().
                ">> mr ".$client->getNom()." ");
            $s1="vous êtes déjà inscrit à l'événement <<".$event->getNomevent().
                ">> mr ".$client->getNom()." ";
            $flashy->primaryDark($s1);
            return $this->redirectToRoute('myEvents',['idclient'=>$idClient]);
        }

    }

    /**
     * @param $idClient
     * @param $idEvent
     * @param InscrieventRepository $repository
     * @return Response
     * @Route("/upgradi/eventDetails/annuler/{idClient}/{idEvent}",name="annulation")
     */
    public function annulerInscri($idClient,$idEvent,InscrieventRepository $repository,FlashyNotifier $flashy): Response
    {
        $ins=$repository->findOneByIdClientIdEvent($idClient,$idEvent);
        $event=$this->getDoctrine()->getRepository(Event::class)->find($idEvent);
        $client=$this->getDoctrine()->getRepository(Client::class)->find($idClient);
        if($ins!=null){
            $em=$this->getDoctrine()->getManager();
            $em->remove($ins);
            $em->flush();
            $s="votre inscription à l'événement <<".$event->getNomevent().
                ">> a été Supprimer avec succès mr ".$client->getNom()."";
            $flashy->info($s);
            return $this->redirectToRoute('myEvents',['idclient'=>$idClient]);
        }
        else{

            $s1="vous n'avez pas faire l'inscription à l'événement <<".$event->getNomevent().
                ">>  ".$client->getNom()." ";
            $flashy->error($s1);
            return $this->redirectToRoute('eventDetails',['idEvent'=>$idEvent,'idClient'=>$idClient]);
        }

    }

    /**
     * @param $idevent
     * @param InscrieventRepository $repository
     * @return Response
     * @Route("/event/allEvents/inscriptions/{idevent}", name="lesInscriptions")
     */
    public function inscriOfIdEvent($idevent,InscrieventRepository $repository): Response
    {
        //$inscriptions=$repository->getByIdEvent($idevent);
        $event=$this->getDoctrine()->getRepository(Event::class)->find($idevent);
        return $this->render("event/inscriptions.html.twig",array(
           // 'inscriptions'=>$inscriptions,
            'event'=>$event

        ));
    }

    /**
     * @param FlashyNotifier $flashyNotifier
     * @param $idclient
     * @param InscrieventRepository $repository
     * @return Response
     * @Route("/upgradi/myEvents/{idclient}",name="myEvents")
     */
    public function inscriOfClient(FlashyNotifier $flashy,$idclient,InscrieventRepository $repository): Response
    {
        //$inscriptions=$repository->getByIdClient($idclient);
        $client=$this->getDoctrine()->getRepository(Client::class)->find($idclient);
        $events= array();
        $n=sizeof($client->getInscriptions());
        for( $i=0;$i<$n;$i++){
            $events[$i]=$this->getDoctrine()->getRepository(Event::class)->find($client->getInscriptions()[$i]->getEvent()->getidevent());
        }
        return $this->render("front/myEvents.html.twig",array(
            'events'=>$events

        ));
    }

    /* Partie JSON*/
    /**
     * @param Request $request
     * @param NormalizerInterface $formatter
     * @return Response
     * @throws ExceptionInterface
     * @Route("/sinscrire/newInscriJSON",name="newInscriJSON")
     */
    public function addInscri(Request $request,NormalizerInterface $formatter){
        $inscri=new Inscrievent();
        $client=$this->getDoctrine()->getRepository(Client::class)->find($request->get('idclient'));
        $event=$this->getDoctrine()->getRepository(Event::class)->find($request->get('idevent'));

        $inscri->setClient($client);
        $inscri->setEvent($event);
        $inscri->setDateinscri(new \DateTime());
        $mn=$this->getDoctrine()->getManager();
        $mn->persist($inscri);
        $mn->flush();
        $jsonContent =$formatter->normalize($inscri,'json',['groups'=>'ins']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     * @Route("/sinscrire/testInscriExist/{idclient}/{idevent}",name="test")
     */
    public function getInscri(Request $request,NormalizerInterface $normalizer){
        $client=$this->getDoctrine()->getRepository(Client::class)->find($request->get('idclient'));
        $event=$this->getDoctrine()->getRepository(Event::class)->find($request->get('idevent'));
       $inscri= $this->getDoctrine()->getRepository(Inscrievent::class)->findBy([
           'client'=>$client,
            'event'=>$event
        ]);

       $jsonContent1 =$normalizer->normalize($inscri,'json',['groups'=>'ins']);
        return new Response(json_encode($jsonContent1));
    }
}
