<?php

namespace App\Auth\Repositories;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?array;

    /**
     * @param array{username:string,email:string,password:string,academic_year?:string,major?:string,university_name?:string} $data
     */
    public function create(array $data): array;

    public function createPasswordResetForEmail(string $email): void;

    public function updatePassword(string $email, string $password): void;
}

