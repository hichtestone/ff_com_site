<?php

namespace App\Controller;

use App\Entity\Landing;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/index.html', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

	#[Route("/about.html", name:"about", methods:["GET"])]
	public function about(): Response
	{
        return $this->render('pages/about.html.twig', [
            'controller_name' => 'HomeController',
        ]);
	}
	
	#[Route("/{slug}.html", name:"landing_public_display", methods:["GET"])]
    public function displayLanding(Landing $landing): Response
    {
        // Check landing from invest site
        if (!$landing)
            throw $this->createNotFoundException('Cette page n\'est pas accessible');

        return $this->render('landing/public.html.twig', [
            'landing' => $landing
        ]);
    }

}
