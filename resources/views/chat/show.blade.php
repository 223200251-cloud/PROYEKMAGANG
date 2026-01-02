@extends('layouts.app')

@section('title', 'Chat dengan ' . $recipient->name)

@section('content')
    <div class="container-main">
        <style>
            .chat-container {
                display: grid;
                grid-template-columns: 1fr;
                height: 600px;
                background: white;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .chat-messages {
                flex: 1;
                padding: 20px;
                overflow-y: auto;
                background: #f8f9fa;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .chat-message {
                display: flex;
                gap: 10px;
                margin-bottom: 10px;
            }

            .chat-message.sent {
                justify-content: flex-end;
            }

            .message-bubble {
                max-width: 70%;
                padding: 12px 16px;
                border-radius: 12px;
                word-wrap: break-word;
            }

            .message-bubble.received {
                background: white;
                color: #333;
                border: 1px solid #e0e0e0;
            }

            .message-bubble.sent {
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
            }

            .message-time {
                font-size: 0.75rem;
                color: #999;
                margin-top: 4px;
                text-align: right;
            }

            .chat-input-area {
                padding: 20px;
                background: white;
                border-top: 1px solid #e0e0e0;
                display: flex;
                gap: 10px;
            }

            .chat-input-area input {
                flex: 1;
                padding: 12px 16px;
                border: 1px solid #e0e0e0;
                border-radius: 25px;
                font-size: 1rem;
            }

            .chat-input-area button {
                padding: 12px 24px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
                border: none;
                border-radius: 25px;
                cursor: pointer;
                font-weight: 600;
            }

            .chat-header {
                padding: 20px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
                display: flex;
                align-items: center;
                gap: 15px;
                border-bottom: 1px solid #e0e0e0;
            }

            .recipient-avatar {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 1.5rem;
            }

            .recipient-info h3 {
                margin: 0;
                font-size: 1.1rem;
            }

            .recipient-info p {
                margin: 0;
                font-size: 0.9rem;
                opacity: 0.9;
            }
        </style>

        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('profile.my-profile') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Chat Container -->
        <div class="chat-container">
            <!-- Chat Header -->
            <div class="chat-header">
                @if($recipient->avatar_url)
                    <img src="{{ $recipient->avatar_url }}" alt="{{ $recipient->name }}"
                         style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                @else
                    <div class="recipient-avatar">
                        {{ strtoupper(substr($recipient->name, 0, 1)) }}
                    </div>
                @endif
                <div class="recipient-info">
                    <h3>{{ $recipient->name }}</h3>
                    <p>
                        @if($recipient->user_type === 'individual')
                            <i class="fas fa-circle" style="color: #4ade80; font-size: 0.5rem;"></i> Kreator Portfolio
                        @else
                            <i class="fas fa-circle" style="color: #4ade80; font-size: 0.5rem;"></i> Perusahaan / Rekruter
                        @endif
                    </p>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="chat-messages" id="messagesContainer">
                <div style="text-align: center; color: #999; margin: auto;">
                    <i class="fas fa-paper-plane fa-3x mb-3" style="opacity: 0.5;"></i>
                    <p>Belum ada pesan. Mulai percakapan sekarang!</p>
                </div>
            </div>

            <!-- Input Area -->
            <div class="chat-input-area">
                <input type="text" id="messageInput" placeholder="Ketik pesan..."
                       style="border-radius: 25px; padding: 12px 20px;">
                <button onclick="sendMessage()" style="border-radius: 25px; padding: 12px 24px;">
                    <i class="fas fa-paper-plane"></i> Kirim
                </button>
            </div>
        </div>
    </div>

    <script>
        const recipientId = {{ $recipient->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Load messages on page load
        function loadMessages() {
            fetch(`/chat/api/messages/${recipientId}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('messagesContainer');
                    
                    if (!data.messages || data.messages.length === 0) {
                        container.innerHTML = `
                            <div style="text-align: center; color: #999; margin: auto;">
                                <i class="fas fa-paper-plane fa-3x mb-3" style="opacity: 0.5;"></i>
                                <p>Belum ada pesan. Mulai percakapan sekarang!</p>
                            </div>
                        `;
                        return;
                    }

                    container.innerHTML = '';
                    data.messages.forEach(msg => {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `chat-message ${msg.is_sent ? 'sent' : ''}`;
                        messageDiv.innerHTML = `
                            <div class="message-bubble ${msg.is_sent ? 'sent' : 'received'}">
                                ${msg.message}
                                <div class="message-time">
                                    ${new Date(msg.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}
                                </div>
                            </div>
                        `;
                        container.appendChild(messageDiv);
                    });

                    // Scroll to bottom
                    container.scrollTop = container.scrollHeight;
                })
                .catch(error => console.error('Error:', error));
        }

        // Send message
        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();

            if (!message) return;

            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    recipient_id: recipientId,
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    input.value = '';
                    loadMessages();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengirim pesan');
            });
        }

        // Handle Enter key
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Load messages initially
        loadMessages();

        // Auto-refresh messages every 2 seconds
        setInterval(loadMessages, 2000);
    </script>
@endsection
