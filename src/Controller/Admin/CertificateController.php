<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Dto\Certificate\UploadCertificateDto;
use App\Exception\MarketPartner\MarketPartnerNotExistsException;
use App\Form\CertificateFormType;
use App\Repository\MarketPartnerEmailRepository;
use App\Repository\MarketPartnerRepository;
use App\Service\Certificate\CertificateService;
use App\Service\Upload\UploadService;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
use Symfony\Contracts\Translation\TranslatorInterface;

class CertificateController extends AbstractController
{
    public function __construct(
        private MarketPartnerEmailRepository $marketPartnerEmailRepository,
        private UploadService $uploadService,
        private CertificateService $certificateService,
        private MarketPartnerRepository $marketPartnerRepository,
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/admin/certificates/decode', name: 'certificates_decode')]
    public function certificateDecode(Request $request): Response
    {
        try {
            $partnerId = (int)$request->get('partnerId');
            $marketPartnerData = $this->marketPartnerRepository->getActiveMarketPartner($partnerId);

            if (!$marketPartnerData) {
                throw new MarketPartnerNotExistsException($this->translator->trans("Given Market Partner Id didn't exist"));
            }

            $certificateFile = $request->files->get('file');
            $certificateData = $this->uploadService->upload(
                $certificateFile,
                $this->getParameter('certificateDirectory')
            );
            $certificateDto = $this->certificateService->decode($certificateData);

            return new JsonResponse(
                $certificateDto->toArray()
            );
        } catch (Exception $exception) {
            return new JsonResponse(
                ['errorMessage' => $exception->getMessage()]
            );
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws Exception
     */
    #[Route('/admin/certificates/all', name: 'certificates_all')]
    public function certificateAll(Request $request): Response
    {
        $modalCertificateForm = $this->createForm(CertificateFormType::class);
        $modalCertificateForm->handleRequest($request);

        if ($modalCertificateForm->isSubmitted() && $modalCertificateForm->isValid()) {
            $certificateForm = $request->request->get('certificate_form');
            $partnerId = (int)$certificateForm['partnerId'];
            $activeFrom = new DateTime($certificateForm['validFrom']);
            $activeUntil = new DateTime($certificateForm['validUntil']);

            $marketPartnerData = $this->marketPartnerRepository->getActiveMarketPartner($partnerId);
            if (!$marketPartnerData) {
                throw new MarketPartnerNotExistsException($this->translator->trans("Given Market Partner Id didn't exist"));
            }

            $uploadCertificateDto = new UploadCertificateDto();
            $uploadCertificateDto->setEmailAddress($certificateForm['email']);
            $uploadCertificateDto->setValidFrom($activeFrom);
            $uploadCertificateDto->setValidUntil($activeUntil);
            $uploadCertificateDto->setCertificateFile($certificateForm['certificateFile']);
            $uploadCertificateDto->setMarketPartner($marketPartnerData);

            $this->marketPartnerEmailRepository->addCertificate($uploadCertificateDto, true);
        }

        $marketPartnerEmail = $this->marketPartnerEmailRepository->findAll();

        return $this->render(
            'admin/content/certificate/index.html.twig',
            [
                'modalCertificateForm' => $modalCertificateForm->createView(),
                'marketPartnerEmails' => $marketPartnerEmail,
                'nowDate' => date('Y-m-d')
            ]
        );
    }
}
