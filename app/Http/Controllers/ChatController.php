<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show chat page with a specific user
     */
    public function show($recipientId)
    {
        $currentUser = Auth::user();

        // Only companies/recruiters can use chat
        if ($currentUser->user_type === 'individual') {
            return redirect()->route('home')->with('error', 'Kreator tidak dapat menggunakan fitur chat. Hanya recruiter/perusahaan yang dapat menghubungi kreator.');
        }

        // Find the recipient
        $recipient = User::findOrFail($recipientId);

        // Recipient must be a creator (individual)
        if ($recipient->user_type !== 'individual') {
            return redirect()->route('home')->with('error', 'Anda hanya dapat menghubungi kreator.');
        }

        return view('chat.show', compact('recipient'));
    }

    /**
     * Get all messages between current user and a specific user
     */
    public function getMessages($recipientId)
    {
        $currentUserId = Auth::id();

        // Get all messages between the two users
        $messages = Chat::where(function ($query) use ($currentUserId, $recipientId) {
            $query->where('sender_id', $currentUserId)
                  ->where('recipient_id', $recipientId);
        })->orWhere(function ($query) use ($currentUserId, $recipientId) {
            $query->where('sender_id', $recipientId)
                  ->where('recipient_id', $currentUserId);
        })->orderBy('created_at', 'asc')
          ->get();

        // Mark messages as read
        Chat::where('sender_id', $recipientId)
            ->where('recipient_id', $currentUserId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Format messages for response
        $formattedMessages = $messages->map(function ($message) use ($currentUserId) {
            return [
                'id' => $message->id,
                'message' => $message->message,
                'is_sent' => $message->sender_id === $currentUserId,
                'created_at' => $message->created_at,
            ];
        });

        return response()->json([
            'messages' => $formattedMessages
        ]);
    }

    /**
     * Send a new message
     */
    public function sendMessage(Request $request)
    {
        $currentUser = Auth::user();

        // Cek apakah user adalah kreator (individual)
        if ($currentUser->user_type === 'individual') {
            return response()->json([
                'success' => false,
                'message' => 'Kreator tidak diizinkan mengirim pesan chat'
            ], 403);
        }

        // Cek authorization menggunakan policy
        $this->authorize('create', Chat::class);

        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $currentUserId = Auth::id();
        $recipientId = $request->recipient_id;

        // Prevent sending message to yourself
        if ($currentUserId === $recipientId) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak bisa mengirim pesan ke diri sendiri'
            ], 400);
        }

        // Create the message
        $chat = Chat::create([
            'sender_id' => $currentUserId,
            'recipient_id' => $recipientId,
            'message' => $request->message
        ]);

        return response()->json([
            'success' => true,
            'message' => $chat
        ]);
    }

    /**
     * Get conversations list for current user
     */
    public function conversations()
    {
        $currentUser = Auth::user();

        // Kreator tidak bisa melihat conversations
        if ($currentUser->user_type === 'individual') {
            return response()->json([
                'success' => false,
                'message' => 'Kreator tidak diizinkan mengakses pesan chat'
            ], 403);
        }

        $this->authorize('viewAny', Chat::class);

        $currentUserId = Auth::id();

        // Get latest message with each user
        $conversations = Chat::where('sender_id', $currentUserId)
            ->orWhere('recipient_id', $currentUserId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($currentUserId) {
                return $message->sender_id === $currentUserId ? $message->recipient_id : $message->sender_id;
            })
            ->map(function ($messages, $userId) {
                $lastMessage = $messages->last();
                $user = User::find($userId);
                
                return [
                    'user_id' => $userId,
                    'user_name' => $user->name,
                    'user_avatar' => strtoupper(substr($user->name, 0, 1)),
                    'last_message' => $lastMessage->message,
                    'last_message_at' => $lastMessage->created_at,
                    'unread_count' => Chat::where('sender_id', $userId)
                                        ->where('recipient_id', $currentUserId)
                                        ->whereNull('read_at')
                                        ->count()
                ];
            })
            ->values();

        return response()->json([
            'conversations' => $conversations
        ]);
    }

    /**
     * Delete a message
     */
    public function deleteMessage($messageId)
    {
        $message = Chat::find($messageId);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Pesan tidak ditemukan'
            ], 404);
        }

        // Only allow sender to delete their message
        if ($message->sender_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak menghapus pesan ini'
            ], 403);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus'
        ]);
    }
}
