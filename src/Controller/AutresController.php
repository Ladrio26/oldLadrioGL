<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class AutresController extends AbstractController
{
    #[Route('/autres', name: 'autres')]
    public function index(): Response
    {
        return $this->render('autres.html.twig');
    }
}
