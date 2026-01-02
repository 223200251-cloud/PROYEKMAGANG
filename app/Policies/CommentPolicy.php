<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine if the user can view comments.
     * Semua user bisa melihat komentar
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view a comment.
     */
    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    /**
     * Determine if the user can create a comment.
     * Kreator (individual) tidak bisa membuat komentar
     */
    public function create(User $user): bool
    {
        // Kreator tidak bisa membuat komentar, hanya bisa melihat
        return $user->user_type !== 'individual';
    }

    /**
     * Determine if the user can update the comment.
     * Hanya pembuat komentar (non-kreator) yang bisa edit
     */
    public function update(User $user, Comment $comment): bool
    {
        // Kreator tidak bisa edit komentar
        if ($user->user_type === 'individual') {
            return false;
        }

        // Hanya pembuat komentar yang bisa edit
        return $user->id === $comment->user_id;
    }

    /**
     * Determine if the user can delete the comment.
     * Admin atau pembuat komentar (non-kreator) yang bisa delete
     */
    public function delete(User $user, Comment $comment): bool
    {
        // Kreator tidak bisa delete komentar
        if ($user->user_type === 'individual') {
            return false;
        }

        // Admin atau pembuat komentar yang bisa delete
        return $user->isAdmin() || $user->id === $comment->user_id;
    }
}
