<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class GeoguessrController extends AbstractController
{
    #[Route('/geoguessr', name: 'geoguessr')]
    public function contact() : Response
    {
        return $this->render('llan/geoguessr.html.twig');
    }
}

