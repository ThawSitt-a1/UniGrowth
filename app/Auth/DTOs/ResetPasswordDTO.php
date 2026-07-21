<?php

namespace App\Auth\DTOs;

final class ResetPasswordDTO
{
    public function __construct(
        public readonly string $token,
        public readonly string $email,
        public readonly string $password,
        public readonly bool $remember = false,
    ) {
    }
}

