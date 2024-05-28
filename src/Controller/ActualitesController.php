<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ActualitesController extends AbstractController
{
    #[Route('/actualites', name: 'actualites')]
    public function about() : Response
    {
        return $this->render('actualites.html.twig');
    }
}
