<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TftController extends AbstractController
{
    #[Route('/tft', name: 'tft')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findFutureEventsByGame('TFT');

        return $this->render('tft.html.twig', [
            'events' => $events,
        ]);
    }
}
