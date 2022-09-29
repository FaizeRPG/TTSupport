<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;

use Symfony\Component\Security\Core\Security;

use App\Entity\User;
use App\Entity\JdrPlayer;

/**
* @Route("/roll", name="roll_")
*/
class RollerController extends AbstractDashboardController// AbstractController
{
	private $security;

	public function __construct(Security $security)
	{
		$this->security = $security;
	}

    /**
    * @Route("/", name="board")
    */
    public function boardAction()
    {
        $blue = $dark = $green = $purple = $yellow = $red = $forcedie = 0;
		$token = NULL;
		
		if (!is_null($this->getUser())) {
			$token = $this->getUser()->getApiToken();
		}
		
        return $this->render('eote/board.html.twig',
		[
			'dicelist' => [['green', 'yellow', 'blue'], ['purple', 'red', 'dark'], ['force']],
			'blue' => $blue,
			'dark' => $dark,
			'green' => $green,
			'purple' => $purple,
			'red' => $red,
			'yellow' => $yellow,
			'forcedie' => $forcedie,
			'token' => $token,
		]);
    }
	
   /**
    * @Route("/admin/dashboard", name="dashboard")
    */
    public function dashboardAction()
    {
		try {
			//$em = $this->getDoctrine()->getManager();
			$user = $this->getUser();
			$players = $user->getJdrPlayers();
			
			if (count($players) > 0) {
				$player = $players[0];
			} else {
				return new Response("Vous n'avez aucun personnage !");
			}
			
		} catch (Exception $e) {
			return new Response($e->getMessage());
		}

		return $this->render('eote/dashboard.html.twig', ["player" => $player]);
    }
    
    /**
    * @Route("/admin/viewer", name="viewer")
    */
    public function rollViewerdAction()
    {
        $players = $this->getDoctrine()->getRepository(JdrPlayer::class)->findBy(["isActive" => TRUE]);

		return $this->render('eote/viewer.html.twig', ["players" => $players]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
		
        if ($this->security->isGranted('ROLE_USER')) {
			yield MenuItem::linkToLogout('Logout', 'fas fa-power-off');
		} else {
			yield MenuItem::linkToRoute('Login', 'fas fa-power-off', 'app_login');
		}
		
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
