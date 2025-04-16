<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CellController extends AbstractController
{
    #[Route('/cell', name: 'cell')]
    public function index(): Response
    {
        return $this->render('cell.html.twig');
    }
}
