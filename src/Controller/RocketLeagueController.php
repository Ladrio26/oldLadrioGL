<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RocketLeagueController extends AbstractController
{
    #[Route('/rocketleague', name: 'rocketleague')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(['jeu' => 'Rocket League']);

        return $this->render('rocketleague.html.twig', [
            'events' => $events,
        ]);
    }
}
