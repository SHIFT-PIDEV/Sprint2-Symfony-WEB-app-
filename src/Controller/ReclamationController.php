<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Demande;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    private $entityManager;

    public function __construct( EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }
    /**
     *@Route("/searchajax", name="ajaxsearch")
     */
    public function search(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Reclamation::class);
        $requestString = $request->get('searchValue');
        $reclamation = $repository->findDemandeByName($requestString);
        $jsonContent = $Normalizer->normalize($reclamation, 'json', ['Groups' => 'reclamation:read']);
        $retour = json_encode($jsonContent);
        return new Response($retour);

    }

    /**
     * @Route("/listreclamation", name="list_reclamation", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $reclamations = $this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findAll();
        $pagination = $paginator->paginate(
            $reclamations,
            $request->query->getInt('page', 1), 5
        );

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $pagination,
        ]);
    }
    /**
     * @Route("/export",  name="export")
     */
    public function export(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Reclamation List');

        $sheet->getCell('A1')->setValue('id');
        $sheet->getCell('B1')->setValue('objet');
        $sheet->getCell('C1')->setValue('description');

        // Increase row cursor after header write
        $sheet->fromArray($this->getData(),null, 'A2', true);


        $writer = new Xlsx($spreadsheet);

        $writer->save('helloworld.xlsx');

        return $this->redirectToRoute('list_reclamation');
    }
    /**
     * @Route("/pdf", name="reclamationpdf")
     */
    public function indexpdf(): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled',TRUE);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file

        $html = $this->renderView('reclamation/indexp.html.twig', [
            'reclamations' => $this->getDoctrine()
                ->getRepository(Reclamation::class)->findAll(),

        ]);

        $dompdf->loadHtml($html);
        // Load HTML to Dompdf

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);


    }

    /**
     * @Route("/listreclamationR", name="list_reclamationR", methods={"GET"})
     */
    public function indexR(Request $request, PaginatorInterface $paginator): Response
    {
        $reclamations = $this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findAll();
        $pagination = $paginator->paginate(
            $reclamations,
            $request->query->getInt('page', 1), 5
        );
        return $this->render('page/reclamation/index.html.twig', [
            'reclamations' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="reclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo("hajouwa1998@gmail.com")
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'emails/try0.html.twig'

                    )
                    ,
                    'text/html'
                );

            $mailer->send($message);
            return $this->redirectToRoute('list_reclamationR');
        }

        return $this->render('page/reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{id}/editR", name="reclamation_editR", methods={"GET","POST"})
     */
    public function editR(Request $request, Reclamation $reclamation): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('list_reclamationR');
        }

        return $this->render('page/reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}R", name="reclamation_deleteR", methods={"POST"})
     */
    public function deleteR(Request $request, Reclamation $reclamation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list_reclamationR');
    }
    /**
     * @Route("/{id}", name="reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list_reclamation');
    }

    private function getData(): array
    {
        /**
         * @var Reclamation reclamation[]
         */
        $list = [];
        $users = $this->entityManager->getRepository(Reclamation::class)->findAll();

        foreach ($users as $user) {
            $list[] = [
                $user->getId(),
                $user->getObjet(),
                $user->getDescription()
            ];
        }
        return $list;
    }
    /**
     * @Route("/{id}/traiter", name="traiter_edit", methods={"GET","POST"})
     */
    public function traiter_edit(Request $request, Reclamation $reclamation,  PaginatorInterface $paginator, \Swift_Mailer $mailer): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $reclamation->setStatus(1);
        $entityManager->persist($reclamation);
        $entityManager->flush();
        $reclamations = $this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findAll();
        $pagination = $paginator->paginate(
            $reclamations,
            $request->query->getInt('page', 1), 7);
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo("hajouwa1998@gmail.com")
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/try1.html.twig'

                )
                ,
                'text/html'
            );

        $mailer->send($message);
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $pagination,
        ]);
    }
    /**
     *@Route("/searchajax", name="ajaxsearch")
     */
    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $reclamation = $em->getRepository(Reclamation::class)->findEntitiesByString($requestString);
        if(!$reclamation)
        {
            $result['reclamation']['error']="Reclamation introuvable :( ";

        }else{
            $result['reclamation']=$this->getRealEntities($reclamation);
        }
        return new Response(json_encode($result));

    }
    public function getRealEntities($reclamations){
        foreach ($reclamations as $reclamation){
            $realEntities[$reclamation->getId()] = [$reclamation->getObjet(),$reclamation->getDescription()];
        }
        return $realEntities;
    }

}
