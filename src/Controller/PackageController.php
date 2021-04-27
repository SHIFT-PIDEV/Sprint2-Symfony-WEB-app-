<?php

namespace App\Controller;

use App\Entity\Package;
use App\Form\PackageType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vonage\Voice\NCCO\NCCO;
use Twilio\Rest\Client;

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
            //On récupere le pic transmise
            $image=$form->get('image')->getData();
            //on génère un nouveau nom de fichier
            $fichier1=md5(uniqid()).'.'.$image->guessExtension();
            //on copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier1
            );
            //on stocke l'image dans la base de données
            $package->setImage($fichier1);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($package);

            $entityManager->flush();
           // require_once __DIR__ . '/../../vendor/autoload.php';



// Your Account SID and Auth Token from twilio.com/console
          //  $account_sid = "ACfb8b46160b4d160d8ebe08b50d01e354";
          //  $auth_token = "7f6f078694f2d844beb18fa803db0d66";
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

// A Twilio number you own with Voice capabilities
           // $twilio_number = "+17622246038";

// Where to make a voice call (your cell phone?)
         //   $to_number = "+21658494321";

           // $client = new Client($account_sid, $auth_token);
           // $client->account->calls->create(
             //   $to_number,
               // $twilio_number,
              //  array(
                 //   "url" => "http://demo.twilio.com/docs/voice.xml"
               // )
         //   );

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
    /**
     * @Route("/package/edit_package/{idPackage}", name="edit_package")
     */
    public function editPackage(Request $request, int $idPackage): Response
    {


        $entityManager = $this->getDoctrine()->getManager();

        $Package = $entityManager->getRepository(Package::class)->find($idPackage);
        $form = $this->createForm(PackageType::class,$Package);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {
            //On récupere le pic transmise
            $image=$form->get('image')->getData();
            //on génère un nouveau nom de fichier
            $fichier1=md5(uniqid()).'.'.$image->guessExtension();
            //on copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier1
            );
            //on stocke l'image dans la base de données
            $Package->setImage($fichier1);

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

            return $this->redirectToRoute('list_package');

        }

        return $this->render("package/edit_package.html.twig", [
            "form_title" => "Modifier un package",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/package/listpackageF", name="list_package_Front")
     */
    public function listPackageFront(Request $request, PaginatorInterface $paginator)
    {
        $package = $this->getDoctrine()->getRepository(Package::class)->findAll();

        $pagination = $paginator->paginate(
            $package, $request->query->getInt('page', 1), 2


        );


        return $this->render('package/FrontPackage_list.html.twig',[
            "package" =>$pagination,
        ]);
    }
    /**
     * @Route("/package/packageDetails/{idpackage}", name="package_details")
     */
    public function aff_packagedetails(int $idpackage)
    {   $entityManager = $this->getDoctrine()->getManager();

        $package = $entityManager->getRepository(Package::class)->find($idpackage);


        return $this->render('package/FrontPackageDetails.html.twig', [
            "package" => $package,]);
    }
}
