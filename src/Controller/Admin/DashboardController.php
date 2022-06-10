<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('MPSync');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Certificate', 'fa fa-file-text', 'certificates_all');
        yield MenuItem::linkToRoute('User', 'fa fa-user', 'admin_user_list');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('assets/app/css/certificate.css')
            ->addCssFile('assets/bundles/volgh/BS5-HTML/HTML/volgh/assets/css/style.css')
            ->addCssFile('assets/bundles/volgh/BS5-HTML/HTML/volgh/assets/css/skin-modes.css')
            ->addCssFile(
                'assets/bundles/volgh/BS5-HTML/HTML/volgh/assets/plugins/datatable/css/dataTables.bootstrap5.min.css'
            )
            ->addCssFile('assets/bundles/volgh/BS5-HTML/HTML/volgh/assets/colors/color1.css')
            ->addCssFile(
                'assets/bundles/volgh/BS5-HTML/HTML/volgh/assets/plugins/datatable/css/jquery.dataTables.min.css'
            )
            ->addJsFile("assets/bundles/volgh/BS5-HTML/HTML/volgh/assets/js/jquery.min.js")
            ->addJsFile(
                'assets/bundles/volgh/BS5-HTML/HTML/volgh/assets/plugins/datatable/js/jquery.dataTables.min.js'
            );
    }

    #[Route('/admin/user/list', name: 'admin_user_list')]
    public function user(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/user/index.html.twig', ['users' => $users]);
    }
}
