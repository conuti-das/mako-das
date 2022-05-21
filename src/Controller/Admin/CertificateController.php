<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Dto\Certificate\UploadCertificateDto;
use App\Entity\MarketPartnerEmail;
use App\Form\CertificateFormType;
use App\Service\Certificate\CertificateService;
use App\Service\Certificate\UploadService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Interfaces\HttpStatusCodesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

class CertificateController extends AbstractController
{
    /**
     * @var EntityManager
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var UploadService
     */
    private UploadService $uploadService;

    /**
     * @var CertificateService
     */
    private CertificateService $certificateService;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UploadService $uploadService
     * @param CertificateService $certificateService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UploadService $uploadService,
        CertificateService $certificateService
    ) {
        $this->uploadService = $uploadService;
        $this->certificateService = $certificateService;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/certificates/decode', name: 'certificates_decode')]
    public function certificateDecode(Request $request): Response
    {
        $certificateFile = $request->files->get('file');
        $certificateJson = $this->uploadService->upload($certificateFile, $this->getParameter('certificate_directory'));
        $certificateService = $this->certificateService->decode($certificateJson);

        return new Response(
            $certificateService->toJson(),
            HttpStatusCodesInterface::HTTP_SUCCESS,
            array('Content-Type' => 'text/html')
        );
    }

    #[Route('/admin/certificate/all', name: 'certificate-all')]
    public function certificate(Request $request): Response
    {
        $modalCertificateForm = $this->createForm(CertificateFormType::class);
        $modalCertificateForm->handleRequest($request);

        if ($modalCertificateForm->isSubmitted() && $modalCertificateForm->isValid()) {
            $marketPartnerEmail = (new MarketPartnerEmail());
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
            $this->entityManager->getRepository($marketPartnerEmail::class)
                ->addCertificate($uploadCertificateDto);
        }

        return $this->render(
            'admin/certificate/index.html.twig',
            [
                'modalCertificateForm' => $modalCertificateForm->createView()
            ]
        );
    }
}
