<?php

namespace App\Controller;

use App\Service\TwitchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TwitchController extends AbstractController
{
    #[Route('/twitch', name: 'twitch')]
    public function index(): Response
    {
        return $this->render('twitch.html.twig');
    }

    #[Route('/api/twitch/streamers', name: 'twitch_streamers')]
    public function getStreamersData(TwitchService $twitchService): JsonResponse
    {
        try {
            $streamers = ['Ladrio_', '16corp', 'ts_jean_bon', 'Bangatft', 'Emo_emotive', 'StevenLNK_', 'FranckyHS', 'Lenoraclyne', 'Dangodfroid'];
            $streamersData = $twitchService->getStreamersData($streamers);

            // Trier les streamers : ceux qui sont en live en premier
            usort($streamersData, function ($a, $b) {
                return $b['is_live'] <=> $a['is_live'];
            });

            return new JsonResponse($streamersData);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
