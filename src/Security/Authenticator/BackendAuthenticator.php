<?php

namespace App\Security\Authenticator;

use App\Security\User\BackendToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class BackendAuthenticator extends AbstractGuardAuthenticator
{
    private string $backendToken;

    public function __construct(string $backendToken)
    {
        $this->backendToken = $backendToken;
    }

    public function supports(Request $request): bool
    {
        return $request->headers->has('Authorization') && substr($request->headers->get('Authorization'), 0, 13) === 'Auth-Backend';
    }

    public function getUser($token, UserProviderInterface $userProvider): BackendToken
    {
        return new BackendToken($token);
    }

    public function getCredentials(Request $request): ?string
    {
        return explode(' ', $request->headers->get('Authorization'))[1] ?? null;
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $credentials === $this->backendToken;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new Response(null, Response::HTTP_FORBIDDEN);
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): void
    {
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): void
    {
    }
}
