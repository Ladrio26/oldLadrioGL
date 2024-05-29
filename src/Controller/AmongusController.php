<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class AmongusController extends AbstractController
{
    #[Route('/amongus', name: 'amongus')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findFutureEventsByGame('Among Us');

        return $this->render('amongus.html.twig', [
            'events' => $events,
        ]);
    }
}
