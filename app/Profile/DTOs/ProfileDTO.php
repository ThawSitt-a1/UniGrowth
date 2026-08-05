<?php

namespace App\Profile\DTOs;

final class ProfileDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $email,
        public readonly string $role,
        public readonly ?string $avatar_path,
        public readonly ?int $platform_score,
        public readonly ?string $academic_year,
        public readonly ?string $major,
        public readonly ?string $university_name,
        public readonly ?string $description,
        public readonly ?array $preferences,
        public readonly ?array $social_links,
        public readonly string $email_verified_at,
        public readonly string $created_at,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            username: $data['username'],
            email: $data['email'],
            role: $data['role'],
            avatar_path: $data['avatar_path'] ?? null,
            platform_score: $data['platform_score'] ?? null,
            academic_year: $data['academic_year'] ?? null,
            major: $data['major'] ?? null,
            university_name: $data['university_name'] ?? null,
            description: $data['description'] ?? null,
            preferences: $data['preferences'] ?? null,
            social_links: $data['social_links'] ?? null,
            email_verified_at: $data['email_verified_at'],
            created_at: $data['created_at'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'avatar_path' => $this->avatar_path,
            'platform_score' => $this->platform_score,
            'academic_year' => $this->academic_year,
            'major' => $this->major,
            'university_name' => $this->university_name,
            'description' => $this->description,
            'preferences' => $this->preferences,
            'social_links' => $this->social_links,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
        ];
    }
}

