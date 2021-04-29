<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Reclamation;
use App\Form\DemandeType;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/demande")
 */
class DemandeController extends AbstractController
{
    private $entityManager;

    public function __construct( EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }
    private function getData(): array
    {
        /**
         * @var $Demande demande[]
         */
        $list = [];
        $users = $this->entityManager->getRepository(Demande::class)->findAll();

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
     * @Route("/new", name="demande_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cv = $form->get('cv')->getData();
            //on génère un nouveau nom de fichier
            $fichier1 = md5(uniqid()) . '.' . $cv->guessExtension();
            //on copie le fichier dans le dossier uploads
            $cv->move(
                $this->getParameter('images_directory'),
                $fichier1
            );
            //on stocke l'image dans la base de données
            $demande->setCv($fichier1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();


            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo("hajouwa1998@gmail.com")
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'emails/try.html.twig'

                    )
                    ,
                    'text/html'
                );

            $mailer->send($message);
            return $this->redirectToRoute('list_demandeF');
        }

        return $this->render('page/demande/new.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(),
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

        return $this->redirectToRoute('list_demande');
    }

    /**
     * @Route("/pdf", name="demandepdf")
     */
    public function indexpdf(): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled',TRUE);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file

        $html = $this->renderView('demande/indexp.html.twig', [
            'demandes' => $this->getDoctrine()
                ->getRepository(Demande::class)->findAll(),

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
     * @Route("/listdemande", name="list_demande", methods={"GET"}")
     */
    /**
     * @Route("/listdemande", name="list_demande", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $demandes = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findAll();
        $pagination = $paginator->paginate(
            $demandes,
            $request->query->getInt('page', 1), 5
        );
        return $this->render('demande/index.html.twig', [
            'demandes' => $pagination,
        ]);
    }

    /**
     * @Route("/listdemandeF", name="list_demandeF", methods={"GET"})
     */
    public function ListF(Request $request, PaginatorInterface $paginator): Response
    {
        $demandes = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findAll();
        $pagination = $paginator->paginate(
            $demandes,
            $request->query->getInt('page', 1), 5


        );

        return $this->render('page/demande/index.html.twig', [
            'demandes' => $pagination,
        ]);
    }

    /**
     * @Route("/{id}", name="demande_show", methods={"GET"})
     */
    public function show(Demande $demande): Response
    {
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
        ]);
    }



    /**
     * @Route("/{id}/editF", name="demande_editF", methods={"GET","POST"})
     */
    public function editF(Request $request, Demande $demande): Response
    {
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cv = $form->get('cv')->getData();
            //on génère un nouveau nom de fichier
            $fichier1 = md5(uniqid()) . '.' . $cv->guessExtension();
            //on copie le fichier dans le dossier uploads
            $cv->move(
                $this->getParameter('images_directory'),
                $fichier1
            );
            //on stocke l'image dans la base de données
            $demande->setCv($fichier1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();

            return $this->redirectToRoute('list_demandeF');
        }

        return $this->render('page/demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}F", name="demande_deleteF", methods={"POST"})
     */
    public function deleteF(Request $request, Demande $demande): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list_demandeF');
    }
    /**
     * @Route("/{id}/traiterd", name="traiter_editd", methods={"GET","POST"})
     */
    public function traiter_edit(Request $request, Demande $demande, PaginatorInterface $paginator, \Swift_Mailer $mailer): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $demande->setStatus(1);
        $entityManager->persist($demande);
        $entityManager->flush();
        $demandes = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findAll();
        $pagination = $paginator->paginate(
            $demandes,
            $request->query->getInt('page', 1), 5);
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo("hajouwa1998@gmail.com")
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/try2.html.twig'

                )
                ,
                'text/html'
            );

        $mailer->send($message);
        return $this->render('demande/index.html.twig', [
            'demandes' => $pagination,
        ]);
    }
    /**
     * @Route("/{id}", name="demande_delete", methods={"POST"})
     */
    public function delete(Request $request, Demande $demande): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list_demande');
    }

    /**
     *@Route("/searchajax", name="ajaxsearch")
     */
    public function search(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Demande::class);
        $requestString = $request->get('searchValue');
        $demande = $repository->findDemandeByName($requestString);
        $jsonContent = $Normalizer->normalize($demande, 'json', ['Groups' => 'demande:read']);
        $retour = json_encode($jsonContent);
        return new Response($retour);

    }

}
