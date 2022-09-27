<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
    * @Route("/", name="homepage")
    */
    public function homeAction()
    {
        //$exception = $this->get('security.authentication_utils')
        //    ->getLastAuthenticationError();
			
		return $this->render('default/index.html.twig', [
            //'error' => $exception ? $exception->getMessage() : NULL,
			'urls' => [
				'Blood Bowl' => $this->generateUrl('app_bloodbowl_bb'),
				'Star Wars' => $this->generateUrl('roll_board'),
				'Yu-Gi-Oh! Life' => $this->generateUrl('yugi_lp_ref', ['ref' => "demo"]),
			]
        ]);
    }
}
