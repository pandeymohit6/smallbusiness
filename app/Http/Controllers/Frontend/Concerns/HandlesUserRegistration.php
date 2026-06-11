<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Concerns;

use App\Services\RegistrationService;

/**
 * Trait for common registration functionality in buyer/seller controllers
 *
 * Provides methods for handling user registration, role assignment,
 * and welcome emails in a DRY manner.
 */
trait HandlesUserRegistration
{
    /**
     * Get the registration service instance
     */
    protected function registrationService(): RegistrationService
    {
        return app(RegistrationService::class);
    }

    /**
     * Generate a unique username from email
     */
    protected function generateUniqueUsername(string $email): string
    {
        return $this->registrationService()->generateUniqueUsername($email);
    }

    /**
     * Send welcome email (placeholder - can be overridden in controller)
     */
    protected function sendWelcomeEmail($user): void
    {
        $this->registrationService()->sendWelcomeEmail($user);
    }
}
