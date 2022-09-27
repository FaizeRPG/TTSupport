<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BloodBowlController extends AbstractController
{
    /**
     * @Route("/{_locale}/bb", name="bb", defaults={"_locale" = "fr"}, requirements={"_locale" = "en|fr"})
     * @Route("/bb")
     * @Route("/bloodbowl")
     */
    public function bbAction(Request $request)
    {
		return $this->render('bb/clock.html.twig');
    }
}
