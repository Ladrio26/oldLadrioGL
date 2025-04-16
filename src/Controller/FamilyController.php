<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class FamilyController extends AbstractController
{
    #[Route('/family', name: 'family')]
    public function family(): Response
    {
        return $this->render('family/family.html.twig');
    }
}
