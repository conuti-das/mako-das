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
            ->addCssFile('https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css')
            ->addJsFile("https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js")
            ->addJsFile('https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js');
    }

    #[Route('/admin/user/list', name: 'admin_user_list')]
    public function user(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/user/index.html.twig', ['users' => $users]);
    }
}
