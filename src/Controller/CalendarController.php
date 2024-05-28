<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'calendar')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findFutureEvents();

        return $this->render('calendar.html.twig', [
            'events' => $events,
        ]);
    }
}
