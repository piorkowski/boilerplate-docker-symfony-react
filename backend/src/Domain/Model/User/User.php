<?php

namespace App\Domain\Model\User;


class User
{
    /**
     * @param list<string> $roles
     */
    public function __construct(
        public readonly string $id,
        public ?string $password,
        public array $roles,
        public string $email,
        public bool $enabled = false,
    ) {
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    public function isActive(): bool
    {
        return $this->enabled;
    }

    public function activate(): void
    {
        $this->enabled = true;
    }

    public function deactivate(): void
    {
        $this->enabled = false;
    }
}
