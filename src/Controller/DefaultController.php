<?php

namespace App\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;

use Symfony\Component\Security\Core\Security;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Entity\User;
use App\Entity\Jdr;
use App\Entity\JdrPlayer;

class DefaultController extends AbstractDashboardController
{
	private $security;

	public function __construct(Security $security)
	{
		$this->security = $security;
	}
	
    /**
    * @Route("/", name="homepage")
    */
    public function homeAction()
    {
		return $this->render('default/index.html.twig', [
			'urls' => [
				'Blood Bowl' => $this->generateUrl('app_bloodbowl_bb'),
				'Star Wars' => $this->generateUrl('roll_board'),
				'Yu-Gi-Oh! Life' => $this->generateUrl('yugi_lp_ref', ['ref' => "demo"]),
			]
        ]);
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
    
    /**
    * @Route("/create", name="create")
    */
    public function createAction(UserPasswordHasherInterface $passwordHasher)
    {
/*
        $em = $this->getDoctrine()->getManager();
            
        $user = new User();
        $user->setUsername("erwan");
            
	$plaintextPassword = "plop123";
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(["ROLE_ADMIN"]);

        $em->persist($user);
        $em->flush();
        
        return new Response($user->getId());
*/
    }
}
