<?php

namespace App\Controller;

use App\Application\DataBaseApplication;
use App\Entity\Utilisateur;
use App\Form\ExcelUploadType;

use App\Service\FileService;

use Doctrine\ORM\EntityManagerInterface;
use Exception;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Symfony\Component\Routing\Attribute\Route;

final class DatabaseController extends AbstractController
{
    private EntityManagerInterface $em;
    private FileService $file_service;
    private DataBaseApplication $database_application;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->file_service = new FileService();
        $this->database_application = new DataBaseApplication($em);
        

    }

    #[Route('/database', name: 'app_database')]
    public function index(Request $request, SessionInterface $session): Response
    {
        $error = "";
        $session_value = $session->get('access');

        if (is_null($session_value)) {
            return $this->redirectToRoute('access');
        }

        $form = $this->createForm(ExcelUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $file = $form->get('excelFile')->getData();


            try {
                
                $this->database_application->parse_datetime($file->getClientOriginalName());
                $this->database_application->insertUsers($this->file_service->parseExcel($file->getPathName()));
            } 
            catch (Exception $e) {
                dd($e);
                $error = $e->getMessage();
            }
        }
        return $this->render('database/index.html.twig', [
            'form' => $form->createView(),
            'utilisateurs' => $this->em->getRepository(Utilisateur::class)->findAll(),
            'error' => $error
        ]);
    }


    #[Route('/info/{id}', name: 'fetch_user_info')]
    public function get_user_info(int $id = 1): ?Response
    {
        $result = $this->em->getRepository(Utilisateur::class)->getUserInfo($id);

        return new JsonResponse($result);
    }

    #[Route('/transaction/{id}', name: 'fetch_user_transaction')]
    public function get_user_transaction(int $id = 1): ?Response
    {
        $result = $this->em->getRepository(Utilisateur::class)->getUserTransaction($id);

        return new JsonResponse($result);
    }

    #[Route('/parrainage/{id}', name: 'fetch_user_parrainage')]
    public function get_user_parrainage(int $id = 1): ?Response
    {
        $result = $this->em->getRepository(Utilisateur::class)->getUserParrainage($id);

        return new JsonResponse($result);
    }

    #[Route('/export', name: 'export')]
    public function export(): ?Response
    {
            $spreadsheet = $this->file_service->exportUserData($this->em->getRepository(Utilisateur::class)->getExport());

            $response = new StreamedResponse(function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            });


            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'utilisateursBspay.xlsx');

            $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }


    
}


