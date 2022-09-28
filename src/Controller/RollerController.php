<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/roll", name="roll_")
*/
class RollerController extends AbstractController
{
   /**
    * @Route("/dashboard", name="dashboard")
    */
    public function dashboardAction()
    {
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();

		return $this->render('eote/dashboard.html.twig', ["user" => $user]);
    }
    
    /**
    * @Route("/board", name="board")
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
    * @Route("/viewer", name="viewer")
    */
    public function rollViewerdAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

	return $this->render('eote/viewer.html.twig', ["users" => $users]);
    }
}
