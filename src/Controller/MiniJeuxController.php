<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MiniJeuxController extends AbstractController
{
    #[Route(path: '/memory', name: 'memory')]  // Page du jeu de Memory
    public function memory(): Response
    {
        return $this->render('minijeux/memory.html.twig');
    }

    #[Route(path: '/morpion', name: 'morpion')]  // Page du jeu de Morpion
    public function morpion(): Response
    {
        return $this->render('minijeux/morpion.html.twig');
    }
}
