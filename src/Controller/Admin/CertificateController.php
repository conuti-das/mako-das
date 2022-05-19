<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\MarketPartnerEmail;
use App\Service\Certificate\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

class CertificateController extends AbstractController
{
    #[Route('/admin/certificates/decode', name: 'certificates_decode')]
    public function certificateDecode(Request $request): Response
    {
       $brochureFile = $request->files->get('file');
       $uploadService = new UploadService();
       $certificate_json = $uploadService->upload($brochureFile, $this->getParameter('certificate_directory'));
       return new Response($certificate_json, 200, array('Content-Type' => 'text/html'));
    }

    #[Route('/admin/certificates/add', name: 'certificates_add')]
    public function addCertificate(Request $request, ManagerRegistry $doctrine): Response
    {
        $partnerId = (int)$request->request->get('certificate_form_partnerId');
        $activeFrom = new DateTime($request->request->get('certificate_form_validFrom'));
        $activeUntil = new DateTime($request->request->get('certificate_form_validUntil'));
        $entityManager = $doctrine->getManager();
        $marketPartnerEmail = new MarketPartnerEmail();
        $marketPartnerEmail->setMarketPartnerId($partnerId);
        $marketPartnerEmail->setCreatedAt(new DateTime('now'));
        $marketPartnerEmail->setEmail($request->request->get('certificate_form_email'));
        $marketPartnerEmail->setType('edifact');
        $marketPartnerEmail->setSslCertificate($request->request->get('certificate_form_certificateFile'));
        $marketPartnerEmail->setSslCertificateExpiration(new DateTime('now'));
        $marketPartnerEmail->setActiveFrom($activeFrom);
        $marketPartnerEmail->setActiveUntil($activeUntil);
        $entityManager->persist($marketPartnerEmail);
        $entityManager->flush();
        return $this->redirect('/admin/certificate/all');
    }
}
