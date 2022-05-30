<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Dto\Certificate\UploadCertificateDto;
use App\Entity\MarketPartnerEmail;
use App\Form\CertificateFormType;
use App\Repository\MarketPartnerEmailRepository;
use App\Service\Certificate\CertificateService;
use App\Service\Certificate\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

class CertificateController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private MarketPartnerEmailRepository $marketPartnerEmailRepository,
        private UploadService $uploadService,
        private CertificateService $certificateService
    ) {
    }

    #[Route('/admin/certificates/decode', name: 'certificates_decode')]
    public function certificateDecode(Request $request): Response
    {
        $certificateFile = $request->files->get('file');
        $certificateJson = $this->uploadService->upload($certificateFile, $this->getParameter('certificateDirectory'));
        $certificateService = $this->certificateService->decode($certificateJson);

        return new Response(
            $certificateService->toJson(),
            Response::HTTP_OK,
            array('Content-Type' => 'application/json')
        );
    }

    #[Route('/admin/certificate/all', name: 'certificate-all')]
    public function certificate(Request $request): Response
    {
        $marketPartnerEmail = $this->entityManager->getRepository(MarketPartnerEmail::class)->findAll();

        $modalCertificateForm = $this->createForm(CertificateFormType::class);
        $modalCertificateForm->handleRequest($request);

        if ($modalCertificateForm->isSubmitted() && $modalCertificateForm->isValid()) {
            $certificateForm = $request->request->get('certificate_form');
            $uploadCertificateDto = new UploadCertificateDto();
            $partnerId = (int)$certificateForm['partnerId'];
            $activeFrom = new DateTime($certificateForm['validFrom']);
            $activeUntil = new DateTime($certificateForm['validUntil']);
            $uploadCertificateDto->setPartnerId($partnerId);
            $uploadCertificateDto->setEmailAddress($certificateForm['email']);
            $uploadCertificateDto->setValidFrom($activeFrom);
            $uploadCertificateDto->setValidUntil($activeUntil);
            $uploadCertificateDto->setCertificateFile($certificateForm['certificateFile']);
            $this->marketPartnerEmailRepository->addCertificate($uploadCertificateDto, true);
        }

        return $this->render(
            'admin/certificate/index.html.twig',
            [
                'modalCertificateForm' => $modalCertificateForm->createView(),
                'marketPartnerEmails' => $marketPartnerEmail,
            ]
        );
    }
}
