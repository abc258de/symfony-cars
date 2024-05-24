<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MembersController extends AbstractController
{
    #[Route('/members', name: 'app_members')]
    public function index(Request $request): Response{
        return $this->render('members/index.html.twig');
    }
} 

