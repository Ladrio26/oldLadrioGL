<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class DiscordSecurityController extends AbstractController
{
    #[Route(path: '/connect/discord', name: 'connect_discord')]
    public function connect(ClientRegistry $clientRegistry): RedirectResponse
    {
        return $clientRegistry->getClient('discord')->redirect();
    }

    #[Route(path: '/connect/discord/check', name: 'connect_discord_check')]
    public function connectCheck(): void
    {
        // Cette méthode peut être vide, Symfony interceptera la requête avant d'atteindre ce point
    }
}
