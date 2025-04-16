<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TrackmaniaController extends AbstractController
{
    #[Route('/trackmania', name: 'trackmania')]
    public function contact() : Response
    {
        return $this->render('llan/trackmania.html.twig');
    }
}
