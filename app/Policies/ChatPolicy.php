<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;

class ChatPolicy
{
    /**
     * Determine if the user can send a chat message.
     * Kreator (individual) tidak bisa mengirim chat
     */
    public function create(User $user): bool
    {
        // Hanya user dengan user_type != 'individual' (company/recruiter) yang bisa mengirim chat
        // Kreator (individual) tidak boleh mengirim chat
        return $user->user_type !== 'individual';
    }

    /**
     * Determine if the user can view chat messages.
     * Hanya user non-creator yang bisa melihat chat
     */
    public function viewAny(User $user): bool
    {
        return $user->user_type !== 'individual';
    }

    /**
     * Determine if the user can view a chat.
     */
    public function view(User $user, Chat $chat): bool
    {
        // Hanya user yang terlibat dalam chat yang bisa melihat
        if ($user->id !== $chat->sender_id && $user->id !== $chat->recipient_id) {
            return false;
        }

        // Kreator tidak bisa melihat chat
        return $user->user_type !== 'individual';
    }
}
