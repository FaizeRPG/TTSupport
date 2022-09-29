<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Entity\Jdr;
use App\Entity\JdrPlayer;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TTSupport');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
		yield MenuItem::linkToLogout('Logout', 'fas fa-power-off');
		
		yield MenuItem::section('Admin', '')->setPermission("ROLE_ADMIN");
		yield MenuItem::linkToCrud('Users', 'fas fa-pen', User::class)->setPermission("ROLE_ADMIN");
		
        yield MenuItem::section('Jdr', '');
		yield MenuItem::linkToCrud('Jdr Game', 'fas fa-pen', Jdr::class)->setPermission("ROLE_ADMIN");
		yield MenuItem::linkToCrud('Jdr Players', 'fas fa-pen', JdrPlayer::class)->setPermission("ROLE_ADMIN");
		yield MenuItem::linkToRoute('Roll Dashboard', 'fas fa-link', 'roll_dashboard')->setPermission("ROLE_USER");
		yield MenuItem::linkToRoute('Dice roller', 'fas fa-link', 'roll_board');
		yield MenuItem::linkToRoute('Roll Viewer', 'fas fa-link', 'roll_viewer')->setPermission("ROLE_USER");
		
        yield MenuItem::section('Bloodbowl', '');
        yield MenuItem::linkToRoute('Timer', 'fas fa-link', 'app_bloodbowl_bb');
		
        yield MenuItem::section('Yu-Gi-Oh!', '');
        yield MenuItem::linkToRoute('Life counter', 'fas fa-link', 'yugi_lp');
    }
}
