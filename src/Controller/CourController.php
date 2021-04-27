<?php

namespace App\Controller;

use App\Entity\Cour;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Form\CourType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Vonage\Voice\NCCO\NCCO;


class CourController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct( EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }
    private function getData(): array
    {
        /**
         * @var $cour Cour[]
         */
        $list = [];
        $users = $this->entityManager->getRepository(Cour::class)->findAll();

        foreach ($users as $cour) {
            $list[] = [
                $cour->getIdcour(),
                $cour->getNom(),
                $cour->getFormateur() ,
                $cour->getDescription() ,
                $cour->getImg() ,
                $cour->getPrix(),
                $cour-> getNiveau(),
                $cour-> getDuration(),


            ];
        }
        return $list;
    }

    /**
     * @Route("/export",  name="export")
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Cour List');

        $sheet->getCell('A1')->setValue('id');
        $sheet->getCell('B1')->setValue('nom');
        $sheet->getCell('C1')->setValue('formateur');
        $sheet->getCell('D1')->setValue('Description');
        $sheet->getCell('E1')->setValue('Image');
        $sheet->getCell('F1')->setValue('Prix');
        $sheet->getCell('G1')->setValue('Niveau');
        $sheet->getCell('H1')->setValue('Duration');
        $sheet->getCell('I1')->setValue('categorie');


        // Increase row cursor after header write
        $sheet->fromArray($this->getData(),null, 'A2', true);


        $writer = new Xlsx($spreadsheet);

        $writer->save('helloworld.xlsx');

        return $this->redirectToRoute('list_cour');
    }

    /**
     * @Route("/cour/addcour", name="add_cour")
     */
    public function addcour(Request $request,\Swift_Mailer $mailer): Response
    {
        $cour = new Cour();
        $form = $this->createForm(CourType::class,$cour);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($cour);

            $entityManager->flush();
            // block mailing

            $message = (new \Swift_Message('You Got Maillllll!'))
                ->setFrom('upgradisite1@gmail.com')
                ->setTo('mohamedaziz.ghorbel@esprit.tn')
                ->setBody('new cour in the list check our site thanks');
            $mailer->send($message);
            // endblock mailing

            return $this->redirectToRoute('list_cour');

        }

        return $this->render("cour/addcour.html.twig", [
            "form_title" => "Ajouter un cour",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/cour/delete_cour/{idCour}", name="delete_cour")
     */
    public function deleteCour(int $idCour): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cour = $entityManager->getRepository(cour::class)->find($idCour);
        $entityManager->remove($cour);
        $entityManager->flush();
        return $this->redirectToRoute('list_cour');
    }

    /**
     * @Route("/cour/listcour", name="list_cour")
     */
    public function listCour(Request $request,PaginatorInterface $paginator)
    {
        $cour = $this->getDoctrine()->getRepository(Cour::class)->findAll();

        $pagination = $paginator->paginate(
            $cour, $request->query->getInt('page', 1), 2);

        return $this->render('cour/cours.html.twig',["cour"=>$pagination]);
    }
    /**
     * @Route("/cour/edit_cour/{idCour}", name="edit_cour")
     */
    public function editCour(Request $request, int $idCour): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $Cour = $entityManager->getRepository(Cour::class)->find($idCour);
        $form = $this->createForm(CourType::class,$Cour);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

            return $this->redirectToRoute('list_cour');

        }

        return $this->render("cour/edit_cour.html.twig", [
            "form_title" => "Modifier un cour",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/cour/listcourAfterRech", name="list_courAfterRech")
     */
    public function researchByNom(Request $request)
    {   $entityManager = $this->getDoctrine()->getManager();
        $cour = $entityManager->getRepository(Cour::class)->findAll();
        if($request->isMethod("GET"))
        {
            $nom=$request->get('searchbar');

            $cour = $entityManager->getRepository(Cour::class)->findBy(array('nom' => $nom));

        }
        return $this->render('cour/coursAfterRech.html.twig', [
            "cour" => $cour,]);
    }
    ////////////////////////////////////Front //////////////////
    /**
     * @Route("/cour/listcourF", name="list_cour_Front")
     */
    public function listCourFront(Request $request, PaginatorInterface $paginator)
    {
        $cour = $this->getDoctrine()->getRepository(Cour::class)->findAll();

        $pagination = $paginator->paginate(
            $cour, $request->query->getInt('page', 1), 2


        );


        return $this->render('cour/FrontCour_list.html.twig',[
            "cour" =>$pagination,
        ]);
    }
    /**
     *@Route("/searchajax", name="ajaxsearch")
     */
    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $cour = $em->getRepository(Cour::class)->findEntitiesByString($requestString);
        if(!$cour)
        {
            $result['cour']['error']="cour introuvable :( ";

        }else{
            $result['cour']=$this->getRealEntities($cour);
        }
        return new Response(json_encode($result));

    }
    public function getRealEntities($cour){
        foreach ($cour as $cour){
            $realEntities[$cour->getIdcour()] = [$cour->getNom()];
        }
        return $realEntities;
    }


    /**
     * @Route("/cour/courDetails/{idcour}", name="cour_details")
     */
    public function aff_courdetails(int $idcour)
    {   $entityManager = $this->getDoctrine()->getManager();

        $cour = $entityManager->getRepository(cour::class)->find($idcour);


        return $this->render('cour/FrontCourDetails.html.twig', [
            "cour" => $cour,]);
    }
    /////////////////////////////////metier trie///////////////
    /**
     * @Route("/cour/listCourASC", name="listCour_ASC")
     */
    public function sortASCService(Request $request, PaginatorInterface $paginator)
    {
        $cour = $this->getDoctrine()->getRepository(Cour::class)->findBy(array(),array("prix"=>"ASC"));


        $pagination = $paginator->paginate(
            $cour,
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render("cour/FrontCour_listASC.html.twig", [
            "cour" => $pagination,
        ]);

    }
    /**
     *@Route("/cour/listCourDESC", name="listCour_DESC")
     */
    public function sortDESCService(Request $request, PaginatorInterface $paginator)
    {
        $cour = $this->getDoctrine()->getRepository(Cour::class)->findBy(array(),array("prix"=>"DESC"));


        $pagination = $paginator->paginate(
            $cour,
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render("cour/FrontCour_listDESC.html.twig", [
            "cour" => $pagination,
        ]);
    }
}
