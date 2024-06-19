<?php

namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

class TwitchService
{
    private $client;
    private $clientId;
    private $clientSecret;
    private $cache;
    private $logger;

    public function __construct(HttpClientInterface $client, string $clientId, string $clientSecret, CacheInterface $cache, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->cache = $cache;
        $this->logger = $logger;
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
        return $this->cache->get('twitch_streamers_data', function () use ($streamers) {
            $streamersData = [];
            $token = $this->getAccessToken();

            foreach ($streamers as $streamer) {
                // Log the start of the API request
                $this->logger->info("Fetching data for streamer: $streamer");

                $response = $this->client->request('GET', 'https://api.twitch.tv/helix/users', [
                    'query' => ['login' => $streamer],
                    'headers' => [
                        'Client-ID' => $this->clientId,
                        'Authorization' => 'Bearer ' . $token,
                    ],
                ]);

                $user = $response->toArray()['data'][0];
                
                // Log user data
                $this->logger->info("User data: ", $user);

                $response = $this->client->request('GET', 'https://api.twitch.tv/helix/streams', [
                    'query' => ['user_id' => $user['id']],
                    'headers' => [
                        'Client-ID' => $this->clientId,
                        'Authorization' => 'Bearer ' . $token,
                    ],
                ]);

                $stream = $response->toArray()['data'];
                
                // Log stream data
                $this->logger->info("Stream data: ", $stream);

                $streamersData[] = [
                    'display_name' => $user['display_name'],
                    'profile_image_url' => $user['profile_image_url'],
                    'login' => $user['login'],
                    'is_live' => !empty($stream),
                ];
            }

            return $streamersData;
        }, 300); // TTL de 300 secondes (5 minutes)
    }
}
