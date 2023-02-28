<?php

namespace App\Policies;

use App\Models\User;
use App\Models\post;
use Illuminate\Auth\Access\Response;

class PostPolicy
{

    public function before(User $user, string $ability)
    {
        if ($user->is_admin === 1) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->idUser;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, post $post): bool
    {
        return $user->id === $post->idUser;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, post $post): bool
    {
        //
    }
}
