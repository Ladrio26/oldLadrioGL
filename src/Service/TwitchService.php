<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TwitchService
{
    private $client;
    private $clientId;
    private $clientSecret;
    private $token;

    public function __construct(HttpClientInterface $client, string $clientId, string $clientSecret)
    {
        $this->client = $client;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->token = $this->getAccessToken();
    }

    private function getAccessToken(): string
    {
        $response = $this->client->request('POST', 'https://id.twitch.tv/oauth2/token', [
            'body' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
            ],
        ]);

        $data = $response->toArray();

        return $data['access_token'];
    }

    public function getStreamersData(array $streamers): array
    {
        $streamersData = [];

        foreach ($streamers as $streamer) {
            $response = $this->client->request('GET', 'https://api.twitch.tv/helix/users', [
                'query' => ['login' => $streamer],
                'headers' => [
                    'Client-ID' => $this->clientId,
                    'Authorization' => 'Bearer ' . $this->token,
                ],
            ]);

            $user = $response->toArray()['data'][0];

            $response = $this->client->request('GET', 'https://api.twitch.tv/helix/streams', [
                'query' => ['user_id' => $user['id']],
                'headers' => [
                    'Client-ID' => $this->clientId,
                    'Authorization' => 'Bearer ' . $this->token,
                ],
            ]);

            $stream = $response->toArray()['data'];

            $streamersData[] = [
                'display_name' => $user['display_name'],
                'profile_image_url' => $user['profile_image_url'],
                'login' => $user['login'],
                'is_live' => !empty($stream),
            ];
        }

        return $streamersData;
    }
}
