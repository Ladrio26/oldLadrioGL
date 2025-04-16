<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use App\Security\DiscordUserProvider;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class DiscordAuthenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    private $router;
    private $clientRegistry;
    private $userProvider;
    private $entityManager;

    public function __construct(ClientRegistry $clientRegistry, RouterInterface $router, DiscordUserProvider $userProvider, EntityManagerInterface $entityManager)
    {
        $this->clientRegistry = $clientRegistry;
        $this->router = $router;
        $this->userProvider = $userProvider;
        $this->entityManager = $entityManager;
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'connect_discord_check';
    }

    public function authenticate(Request $request): Passport
    {
        $accessToken = $this->clientRegistry->getClient('discord')->getAccessToken();

        $discordUser = $this->clientRegistry->getClient('discord')->fetchUserFromToken($accessToken);

        $email = $discordUser->getEmail();

        // Rechercher un utilisateur existant par email
        $user = $this->userProvider->loadUserByIdentifier($email);

        // Si l'utilisateur n'existe pas, créez-le
        if (!$user) {
            $user = new User();
            $user->setEmail($email);
            $user->setDiscordId($discordUser->getId());
            $user->setDiscordUsername($discordUser->getUsername());
            $user->setDiscordEmail($discordUser->getEmail());
            // Définir un mot de passe par défaut (ou autre logique selon vos besoins)
            $user->setPassword(password_hash(random_bytes(10), PASSWORD_DEFAULT));

            // Enregistrer l'utilisateur dans la base de données
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return new SelfValidatingPassport(
            new UserBadge($discordUser->getId(), function ($userIdentifier) use ($user) {
                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('app_home'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new RedirectResponse($this->router->generate('app_login'));
    }
}
