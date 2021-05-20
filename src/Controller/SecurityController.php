<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        //return $this->render('security/login.html.twig');
        return $this->redirectToRoute('app_login');
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @param $email
     * @param $mdp
     * @param ClientRepository $clientRep
     * @param NormalizerInterface $normalizer
     * @Route("/getUserJson/{email}/{mdp}",name="getUserJson")
     * @return Response
     * @throws ExceptionInterface
     */
    public function getClient($email,$mdp,ClientRepository $clientRep,NormalizerInterface $normalizer): Response
    {
       $client= $clientRep->findBy([
            'email'=>$email,
            'mdp'=>$mdp
        ]);
        $jsonContent = $normalizer->normalize($client, 'json',['groups'=>'cl']);
        $r=json_encode($jsonContent);
        return new Response($r);
    }
}
