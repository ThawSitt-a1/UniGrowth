<?php

namespace App\Auth\DTOs;

final class AuthCredentialsDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $username,
        public readonly bool $remember = false,
        public readonly ?string $academic_year = null,
        public readonly ?string $major = null,
        public readonly ?string $university_name = null,
    ) {
    }
}
