<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class LlanController extends AbstractController
{
    #[Route('/llan', name: 'llan')]
    public function index(): Response
    {
        return $this->render('llan.html.twig');
    }
}
