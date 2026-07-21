<?php

namespace App\Auth\DTOs;

final class AuthCredentialsDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $username,
        public readonly bool $remember = false 
    ) {
    }
}
