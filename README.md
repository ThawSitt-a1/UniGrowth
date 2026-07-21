
# UniGrowth

A personal development platform designed for university students to track their growth, build essential skills, set goals, manage learning activities, and access resources that support academic, career, and personal success.

---

## Project Information

**Institution:** University of Technology (UTYCC)  
**Department:** Information Science and Technology  
**Academic Year:** 2025 - 2026  
**Project Type:** Academic Project

---

# Project Setup

## Prerequisites

- PHP 8.2+
- Composer 2.x
- MySQL / MariaDB
- Node.js 18+ & npm (for frontend assets)

## 1. Clone Repository

```bash
git clone <repository-url>
cd UniGrowth/src
```

## 2. Install Backend Dependencies

```bash
composer install
```

## 3. Environment Configuration

```bash
cp .env.example .env
```

Edit `.env` and configure your database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unigrowth
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@unigrowth.dev"
MAIL_FROM_NAME="${APP_NAME}"

RECAPTCHA_SECRET_KEY=your_recaptcha_secret
```

## 4. Generate Application Key

```bash
php artisan key:generate
```

## 5. Run Migrations

```bash
php artisan migrate
```

## 6. Start Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

---

# User Workflows & Route Guide

## Authentication Workflow

### Registration

| Method | URI         | Description            | Validation                                                                                      |
| ------ | ----------- | ---------------------- | ----------------------------------------------------------------------------------------------- |
| `GET`  | `/register` | Show registration form | —                                                                                               |
| `POST` | `/register` | Submit registration    | username (unique, max:50), email (unique, max:254), password (min:12, uncompromised), reCAPTCHA |

**Rate limit:** 5 requests per minute (`throttle:5,1`)

---

### Login

| Step | Method | URI      | Named Route | Description                                              |
| ---- | ------ | -------- | ----------- | -------------------------------------------------------- |
| 1    | `GET`  | `/login` | `login`     | Show login form (username, email, password, remember me) |
| 2    | `POST` | `/login` | —           | Submit credentials                                       |

**Request body (form/JSON):**

```json
{
    "username": "john",
    "email": "john@example.com",
    "password": "Secret123456!",
    "remember": true
}
```

**Success response (web):** Redirect to `/dashboard` with flash: `"Welcome back, john!"`  
**Success response (API):** `{ "user": { "username", "email", "role", "session_id" } }`  
**Failure response:** `{ "message": "Invalid credentials." }` (generic error — prevents email enumeration)

**Security checks (in order):**

1. Email exists in `users` table
2. Password verified via `Hash::check()`
3. Account status must be `active`
4. `Auth::login()` creates session with remember-me support
5. `session()->regenerate()` prevents fixation attacks

**Rate limit:** 5 requests per minute (`throttle:5,1`)

---

### Password Reset (Two-Step Flow)

#### Step 1 — Request Reset Token

| Step | Method | URI               | Named Route        | Rate Limit |
| ---- | ------ | ----------------- | ------------------ | ---------- |
| 1a   | `GET`  | `/reset-password` | `password.request` | —          |
| 1b   | `POST` | `/request-reset`  | `password.email`   | 5/min      |

**Request body:**

```json
{ "email": "john@example.com" }
```

**Processing:**

1. Generates UUID v4 token
2. Stores in `password_resets` table with 60-minute expiry
3. **Web flow:** Redirects to `GET /reset-password/{token}?email=...`
4. **API flow:** Returns `{ "token": "uuid-string", "message": "..." }`

#### Step 2 — Execute Password Reset

| Step | Method | URI                       | Named Route       | Middleware |
| ---- | ------ | ------------------------- | ----------------- | ---------- |
| 2a   | `GET`  | `/reset-password/{token}` | `password.reset`  | `guest`    |
| 2b   | `POST` | `/reset-password`         | `password.update` | `guest`    |

**Request body:**

```json
{
    "token": "uuid-from-step-1",
    "email": "john@example.com",
    "password": "NewSecurePass123!",
    "password_confirmation": "NewSecurePass123!"
}
```

**Security chain executed server-side:**

1. Find user by email
2. Find non-expired reset record by user_id
3. Timing-safe token comparison (`hash_equals()`)
4. Check token hasn't expired (`isExpired()`)
5. Update password (auto-hashed via `hashed` cast)
6. Delete used token (prevents replay attacks)
7. **No auto-login** — user must sign in with new password

---

### Email Verification

| Method | URI                                | Named Route           | Auth Required |
| ------ | ---------------------------------- | --------------------- | ------------- |
| `GET`  | `/email/verify/{id}/{hash}`        | `verification.verify` | No            |
| `POST` | `/email/verification-notification` | `verification.send`   | `auth`        |

- Verification link redirects to `/reset-password` on success
- Resend endpoint is throttled: 6 requests per minute

---

## Complete Route Table

| Method | URI                                | Named Route           | Middleware | Throttle | Purpose                   |
| ------ | ---------------------------------- | --------------------- | ---------- | -------- | ------------------------- |
| `GET`  | `/login`                           | `login`               | —          | —        | Show login form           |
| `POST` | `/login`                           | —                     | —          | 5/min    | Authenticate user         |
| `GET`  | `/register`                        | —                     | —          | —        | Show registration form    |
| `POST` | `/register`                        | —                     | —          | 5/min    | Create account            |
| `GET`  | `/reset-password`                  | `password.request`    | —          | —        | Show forgot-password form |
| `POST` | `/request-reset`                   | `password.email`      | —          | 5/min    | Generate reset token      |
| `GET`  | `/reset-password/{token}`          | `password.reset`      | `guest`    | —        | Show set-password form    |
| `POST` | `/reset-password`                  | `password.update`     | `guest`    | —        | Update password           |
| `GET`  | `/email/verify/{id}/{hash}`        | `verification.verify` | —          | —        | Verify email address      |
| `POST` | `/email/verification-notification` | `verification.send`   | `auth`     | 6/min    | Resend verification email |
| `GET`  | `/dashboard`                       | —                     | —          | —        | Dashboard (JSON)          |

---

## API Usage Notes

All POST endpoints accept both:

- `application/x-www-form-urlencoded` (browser form submissions)
- `application/json` (API clients like Postman or mobile apps)

**JSON detection:** The controller uses `$request->expectsJson()` to determine response format:

- **Browser:** Redirects with flash messages
- **API client:** Returns structured JSON responses

**Error format (all endpoints):**

```json
{
    "message": "Human-readable error description"
}
```

**Validation errors (422):**

```json
{
    "message": "The email field is required. (and 2 more errors)",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password field is required."]
    }
}
```

---

# Security Features

| Feature                     | Implementation                                  |
| --------------------------- | ----------------------------------------------- |
| Password hashing            | bcrypt/argon2id via `hashed` Eloquent cast      |
| Rate limiting               | `throttle:5,1` on all auth endpoints            |
| Anti-enumeration            | Generic "Invalid credentials." on login failure |
| CSRF protection             | Laravel's built-in CSRF middleware              |
| SQL injection prevention    | All queries via Eloquent ORM                    |
| XSS prevention              | `strip_tags()` + Blade auto-escaping            |
| Timing-safe comparison      | `hash_equals()` for token verification          |
| Session fixation prevention | `session()->regenerate()` after login           |
| reCAPTCHA v2                | Server-side verification on registration        |
| Token expiration            | 60-minute expiry on password reset tokens       |
| One-time use tokens         | Reset tokens deleted after successful use       |

---

# Testing

```bash
# Run all tests
php artisan test

# Run auth-specific tests
php artisan test --filter="AuthController"
php artisan test --filter="Login"
php artisan test --filter="Register"
php artisan test --filter="ResetPassword"

# Run unit tests
php artisan test --testsuite=Unit

# Run feature tests
php artisan test --testsuite=Feature
```

## Test Suites

| Test File                          | Tests                                                                                                           | Status   |
| ---------------------------------- | --------------------------------------------------------------------------------------------------------------- | -------- |
| `AuthControllerLoginTest`          | 3 (invalid credentials, valid login, nonexistent email)                                                         | All pass |
| `AuthControllerRegisterTest`       | 2 (invalid payload, happy path)                                                                                 | All pass |
| `AuthControllerForgotPasswordTest` | 2 (nonexistent email, valid request)                                                                            | All pass |
| `AuthControllerResetPasswordTest`  | 7 (token generation, reset, invalid token, missing fields, password mismatch, nonexistent email, no auto-login) | All pass |
| `ResetPasswordUseCaseTest`         | 6 (unit tests for use case)                                                                                     | All pass |

---

# Project Structure (Auth Module)

```
src/
├── app/
│   ├── Auth/
│   │   ├── Controllers/
│   │   │   └── AuthController.php
│   │   ├── DTOs/
│   │   │   ├── AuthCredentialsDTO.php
│   │   │   └── ResetPasswordDTO.php
│   │   ├── Http/
│   │   │   └── Requests/
│   │   │       ├── LoginRequest.php
│   │   │       ├── RegisterRequest.php
│   │   │       ├── RequestResetRequest.php
│   │   │       └── ResetPasswordRequest.php
│   │   ├── Repositories/
│   │   │   ├── UserRepositoryInterface.php
│   │   │   └── EloquentUserRepository.php
│   │   ├── Rules/
│   │   │   └── Recaptcha.php
│   │   └── UseCases/
│   │       ├── AuthenticateUserUseCase.php
│   │       ├── RegisterUserUseCase.php
│   │       └── ResetPasswordUseCase.php
│   ├── Models/
│   │   ├── User.php
│   │   └── PasswordReset.php
│   └── Http/
│       └── Middleware/
│           └── EnsureAuthenticated.php
├── resources/views/
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── forgot-password-request.blade.php
│   ├── reset-password.blade.php
│   └── dashboard.blade.php
├── routes/
│   ├── web.php
│   └── api.php
└── tests/
    ├── Feature/
    │   ├── AuthControllerLoginTest.php
    │   ├── AuthControllerRegisterTest.php
    │   ├── AuthControllerForgotPasswordTest.php
    │   └── AuthControllerResetPasswordTest.php
    └── Unit/
        └── ResetPasswordUseCaseTest.php
```

---

# Running the Project

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

---

# Contributors

This project is developed by a team of five students.

| Student ID | Name            | Role                                |
| ---------- | --------------- | ----------------------------------- |
| 2IST 2     | Nyan Linn Htut  | Frontend Developer                  |
| 2IST 6     | Thaw Sitt Han   | Backend Developer & Project Manager |
| 2IST 15    | Kyaw Thu Htun   | Full Stack Support                  |
| 2IST 18    | Aung Khant Hmue | Frontend Support                    |
| 2IST 19    | Pyae Sone Thu   | Frontend Support                    |

---

# License

This project was developed as an academic project.

All rights are reserved by the project authors.
