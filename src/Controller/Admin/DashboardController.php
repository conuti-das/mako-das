<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
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
        return $this->render('admin/content/dashboard/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('MPSync')->setFaviconPath("assets/app/img/conuti-logo-favicon.png");
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'side-menu__icon ti-home')->setCssClass("side-menu__item");
        yield MenuItem::linkToRoute('Certificate', 'side-menu__icon ti-package', 'certificates_all')->setCssClass("side-menu__item");
        yield MenuItem::linkToRoute('User', 'side-menu__icon ti-user', 'admin_user_list')->setCssClass("side-menu__item");
    }

    #[Route('/admin/user/list', name: 'admin_user_list')]
    public function user(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/content/user/index.html.twig', ['users' => $users]);
    }
}
