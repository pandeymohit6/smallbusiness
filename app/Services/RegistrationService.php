<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Hooks\AuthFilterHook;
use App\Models\User;
use App\Notifications\RegistrationWelcomeNotification;
use App\Support\Facades\Hook;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegistrationService
{
    /**
     * Generate a unique username from email
     */
    public function generateUniqueUsername(string $email): string
    {
        // Get the part before @ from email
        $baseUsername = strtolower(explode('@', $email)[0]);

        // Remove any special characters, keep only alphanumeric and underscores
        $baseUsername = preg_replace('/[^a-z0-9_]/', '', $baseUsername);

        // Ensure it's not empty
        if (empty($baseUsername)) {
            $baseUsername = 'user';
        }

        // Check if username exists, if so append a number
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    /**
     * Create or retrieve a user for registration
     *
     * @param array $userData Array containing: email, firstname, lastname, password
     * @return User
     */
    public function createOrGetUser(array $userData): User
    {
        $user = User::where('email', $userData['email'])->first();

        // User already exists, return it
        if ($user) {
            return $user;
        }

        // Generate unique username
        $username = $this->generateUniqueUsername($userData['email']);

        // Prepare user data with hooks
        $userCreateData = Hook::applyFilters(AuthFilterHook::REGISTER_USER_DATA, [
            'first_name' => $userData['firstname'],
            'last_name' => $userData['lastname'],
            'username' => $username,
            'email' => $userData['email'],
            'password' => Hash::make($userData['password'] ?? ''),
        ]);

        // Create the user
        $user = User::create($userCreateData);

        // Send welcome email
        $this->sendWelcomeEmail($user);

        return $user;
    }

    /**
     * Assign a role to user if not already assigned
     *
     * @param User $user
     * @param string $roleName
     * @return void
     */
    public function assignRoleIfNotExists(User $user, string $roleName): void
    {
        if (!$user->hasRole($roleName)) {
            $user->assignRole($roleName);
        }
    }

   /**
     * Send the welcome email to the newly registered user.
     */
    protected function sendWelcomeEmail(User $user): void
    {
        // Check if mail is properly configured
        $mailFrom = config('mail.from.address');
        if (empty($mailFrom)) {
            return;
        }

        try {
            $user->notify(new RegistrationWelcomeNotification());
        } catch (\Exception $e) {
            // Log the error but don't fail registration
            Log::warning('Could not send welcome email: '.$e->getMessage());
        }
    }

    /**
     * Register a user with a specific role
     *
     * @param array $userData Array containing: email, firstname, lastname, password
     * @param string $roleName The role to assign
     * @return User
     */
    public function registerUserWithRole(array $userData, string $roleName): User
    {
        $user = $this->createOrGetUser($userData);
        $this->assignRoleIfNotExists($user, $roleName);

        return $user;
    }
}
