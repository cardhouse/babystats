<?php

namespace App\Policies;

use App\Models\Baby;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BabyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any babies.
     */
    public function viewAny(User $user): bool
    {
        return true; // Users can view their own babies
    }

    /**
     * Determine whether the user can view the baby.
     */
    public function view(User $user, Baby $baby): bool
    {
        return $user->id === $baby->user_id;
    }

    /**
     * Determine whether the user can create babies.
     */
    public function create(User $user): bool
    {
        return true; // Authenticated users can create babies
    }

    /**
     * Determine whether the user can update the baby.
     */
    public function update(User $user, Baby $baby): bool
    {
        return $user->id === $baby->user_id;
    }

    /**
     * Determine whether the user can delete the baby.
     */
    public function delete(User $user, Baby $baby): bool
    {
        return $user->id === $baby->user_id;
    }
} 