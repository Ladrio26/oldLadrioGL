<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MinecraftController extends AbstractController
{
    #[Route('/minecraft', name: 'minecraft')]
    public function contact() : Response
    {
        return $this->render('llan/minecraft.html.twig');
    }
}
