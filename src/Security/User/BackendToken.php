<?php

declare(strict_types=1);

namespace App\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

class BackendToken implements UserInterface
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return ['ROLE_BACKEND'];
    }

    public function getPassword(): ?string
    {
        return null;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return 'backend';
    }

    public function eraseCredentials(): void
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
