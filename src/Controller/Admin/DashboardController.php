<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\User;
use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/panel', name: 'panel')]
    public function index(): Response
    {
        return $this->render('admin/panel.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LadrioAdmin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Events', 'fas fa-list', Event::class);
            yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
            yield MenuItem::linkToCrud('Teams', 'fas fa-users-cog', Team::class);
        } elseif ($this->isGranted('ROLE_EVENTS')) {
            yield MenuItem::linkToCrud('Events', 'fas fa-list', Event::class);
        }

        // Bouton pour revenir sur le site principal
        yield MenuItem::linkToUrl('Retour au site', 'fas fa-arrow-left', '/');
    }
}
