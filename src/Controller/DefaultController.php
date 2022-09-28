<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

class DefaultController extends AbstractController
{
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
    
    /**
    * @Route("/create", name="create")
    */
    public function createAction()
    {
/*
        $em = $this->getDoctrine()->getManager();
            
        $user = new User();
        $user->setUsername("erwan");
            
        $encoder = $this->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, "plop123");
        $user->setPassword($encoded);
        $user->setRoles(["ROLE_ADMIN"]);

        $em->persist($user);
        $em->flush();
        
        return new Response($user->getId());
*/
    }
}
