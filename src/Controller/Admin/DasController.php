<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\DashboardControllerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DasController extends AbstractDashboardController
{
    #[Route('/admin/das', name: 'app_das')]
    public function index(): Response
    {
        return $this->render('admin/content/das/index.html.twig');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'home');
        yield MenuItem::linkToRoute('Certificates', 'file-text', 'certificates_all');
        yield MenuItem::linkToRoute('User', 'users', 'admin_user_list');
        yield MenuItem::linkToRoute('Messages', 'check-square', 'app_das');

    }
}
