<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LolController extends AbstractController
{
    #[Route('/lol', name: 'lol')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findFutureEventsByGame('LOL');

        return $this->render('lol.html.twig', [
            'events' => $events,
        ]);
    }
}
