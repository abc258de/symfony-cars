<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SlideshowController extends AbstractController
{
    #[Route('/slideshow', name: 'app_slideshow')]
    public function index(): Response
    {
        return $this->render('slideshow/index.html.twig');
    }
}


