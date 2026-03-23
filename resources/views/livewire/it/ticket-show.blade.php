<div class="p-2" >

    <style>
        /* ── Chat Wrapper ── */
        .chat-wrapper {
            max-height: 460px;
            overflow-y: auto;
            padding: 8px 4px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }
        .chat-wrapper::-webkit-scrollbar { width: 4px; }
        .chat-wrapper::-webkit-scrollbar-thumb { background: rgba(255,255,255,.2); border-radius: 10px; }
        .chat-wrapper { scrollbar-width: thin; scrollbar-color: rgba(255,255,255,.2) transparent; }

        /* ── Chat Row ── */
        .chat-row { animation: fadeUp .22s ease-in-out; margin-bottom: 14px; }

        /* ── Avatar ── */
        .chat-avatar {
            width: 34px; height: 34px; min-width: 34px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
            letter-spacing: .5px;
            flex-shrink: 0;
        }
        .chat-avatar.me    { background: rgba(13,110,253,.25); color: #6ea8fe; }
        .chat-avatar.other { background: rgba(255,255,255,.12); color: #dee2e6; }

        /* ── Bubble ── */
        .chat-bubble {
            max-width: 100%;
            padding: 10px 14px;
            border-radius: 16px;
            word-break: break-word;
            font-size: 14px;
            line-height: 1.55;
        }
        .chat-bubble.me {
            background: linear-gradient(135deg, rgba(13,110,253,.45), rgba(13,110,253,.25));
            border-bottom-right-radius: 4px;
            border: 1px solid rgba(13,110,253,.3);
        }
        .chat-bubble.other {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-bottom-left-radius: 4px;
        }
        .chat-meta {
            font-size: 11px;
            opacity: .55;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Typing ── */
        .typing-indicator {
            display: none;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #adb5bd;
            margin: 4px 0 8px 44px;
        }
        .typing-indicator .dots { display: flex; gap: 3px; }
        .typing-indicator .dots i {
            width: 5px; height: 5px;
            background: #6c757d; border-radius: 50%;
            animation: blink 1.4s infinite both;
        }
        .typing-indicator .dots i:nth-child(2) { animation-delay: .2s }
        .typing-indicator .dots i:nth-child(3) { animation-delay: .4s }

        /* ── Reply Box ── */
        .reply-box {
            background: #1a1d21;
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 16px;
            padding: 12px 14px;
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }
        .reply-textarea {
            background: transparent !important;
            border: none !important;
            color: #f8f9fa !important;
            resize: none;
            flex: 1;
            font-size: 14px;
            padding: 4px 0 !important;
            outline: none !important;
            box-shadow: none !important;
            max-height: 120px;
            overflow-y: auto;
        }
        .reply-textarea::placeholder { color: #6c757d !important; }
        .reply-textarea::-webkit-scrollbar { width: 3px; }
        .reply-textarea::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 10px; }

        .send-btn {
            width: 38px; height: 38px; min-width: 38px;
            border-radius: 50%;
            background: #0d6efd;
            border: none;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            transition: background .2s, transform .15s;
            flex-shrink: 0;
        }
        .send-btn:hover  { background: #0b5ed7; transform: scale(1.05); }
        .send-btn:active { transform: scale(.95); }

        /* ── Scroll btn ── */
        .scroll-down-btn {
            position: fixed; bottom: 25px; right: 25px;
            width: 40px; height: 40px;
            border-radius: 50%; border: none;
            background: #0d6efd; color: #fff;
            font-size: 16px; cursor: pointer;
            display: none;
            box-shadow: 0 4px 14px rgba(13,110,253,.5);
            z-index: 999;
            transition: transform .15s;
        }
        .scroll-down-btn:hover { transform: scale(1.1); }

        /* ── Feedback Stars ── */
        .star-rating .fa-star {
            font-size: 32px;
            cursor: pointer;
            transition: color .15s, transform .15s;
        }
        .star-rating .fa-star:hover { transform: scale(1.2); }

        @keyframes blink {
            0%   { opacity: .2 } 20% { opacity: 1 } 100% { opacity: .2 }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(6px) }
            to   { opacity: 1; transform: translateY(0) }
        }
    </style>

    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">

        {{-- ══════════════ HEADER ══════════════ --}}
        <div class="card-header bg-dark text-white p-4" style="border-radius: 20px 20px 0 0;">
            <div class="d-flex align-items-start gap-3">
                <div style="width: 44px; height: 44px; min-width: 44px; border-radius: 12px;
                    background: rgba(13,110,253,.25); display: flex; align-items: center;
                    justify-content: center; font-size: 20px;">
                    <i class="fa fa-ticket text-primary"></i>
                </div>
                <div class="flex-fill">
                    <h5 class="text-white fw-bold mb-1">{{ $ticket->title }}</h5>
                    <p class="text-secondary mb-0 small">{!! $ticket->description !!}</p>
                </div>
            </div>
            @if ($image)
                <div class="mt-3">
                    <a href="{{ asset('storage/' . $image) }}" target="_blank">
                        <img src="{{ asset('storage/' . $image) }}"
                            class="rounded-3 border border-secondary"
                            style="width: 90px; height: 90px; object-fit: cover;" />
                    </a>
                </div>
            @endif
        </div>

        <div class="card-body p-4">

            {{-- ══════════════ STATUS BAR ══════════════ --}}
    <div class="row {{ $ticket->status->bgColor() }} rounded-3 p-3 mb-4 align-items-center">
        <div class="col-lg-6">
            <div class="d-flex flex-wrap gap-3">
                <span class="badge bg-white text-dark border shadow-sm px-3 py-2" wire:poll.5s>
                    <i class="fa fa-circle me-1 text-{{ $ticket->status->color() }}"></i>
                    {{ $ticket->status->label() }}
                </span>
                <span class="text-dark small d-flex align-items-center gap-1">
                    <i class="fa fa-building opacity-50"></i>
                    {{ $ticket->category->name }}
                </span>
                <span class="text-dark small d-flex align-items-center gap-1">
                    <i class="fa fa-user opacity-50"></i>
                    {{ ucFirst($ticket->user->name) }}
                </span>
                <span class="text-dark small d-flex align-items-center gap-1">
                    <i class="fa fa-clock opacity-50 text-danger"></i>
                    {{ $ticket->created_at->format('d M Y, h:i A') }}
                </span>
            </div>
        </div>

        @can('manage tickets')
            @if ($ticket->status !== \App\Core\Enum\TicketStatus::Closed)
                <div class="col-lg-6 mt-3 mt-lg-0">
                    <form wire:submit.prevent="update_Status"
                        class="d-flex align-items-center justify-content-lg-end gap-2">
                        <label class="text-dark small fw-bold mb-0">{{ __('Change Status') }}:</label>
                        <select wire:ignore wire:model="status"
                            class="form-select form-select-sm shadow-sm" style="width: 160px;">
                            <option value="">{{ __('Choose One') }}</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                        <button class="btn btn-primary btn-sm px-3">
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            @endif
        @endcan
    </div>

            {{-- ══════════════ CHAT ══════════════ --}}
            <div class="rounded-4 p-3 mb-3"
                style="background: #111318; border: 1px solid rgba(255,255,255,.07);">

                <div class="d-flex align-items-center gap-2 mb-3 pb-2"
                    style="border-bottom: 1px solid rgba(255,255,255,.07);">
                    <i class="fa fa-comments text-primary"></i>
                    <span class="text-white fw-bold small">{{ __('Replies') }}</span>
                    <span class="badge bg-primary bg-opacity-20 text-primary ms-1" style="font-size: 11px;">
                        {{ $ticket->replies->count() }}
                    </span>
                </div>

                <div class="chat-wrapper" id="chat-container">
                    @forelse ($ticket->replies as $reply)
                        @php
                            $isMe     = $reply->user->id == auth()->id();
                            $nameParts = explode(' ', trim($reply->user->name));
                            $initials  = strtoupper(
                                substr($nameParts[0], 0, 1) .
                                (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : substr($nameParts[0], 1, 1))
                            );
                        @endphp

                        {{-- ✅ الترتيب صح: avatar يمين للـ me، شمال للـ other --}}
                        <div class="d-flex chat-row gap-2 align-items-end
                            {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">

                            {{-- Avatar التاني - على الشمال --}}
                            @if (!$isMe)
                                <div class="chat-avatar other" title="{{ $reply->user->name }}">
                                    {{ $initials }}
                                </div>
                            @endif

                            {{-- الـ Bubble --}}
                            <div style="max-width: 68%;">
                                <div class="chat-bubble {{ $isMe ? 'me' : 'other' }}" dir="auto">
                                    <div class="text-white">{{ $reply->message }}</div>
                                    <div class="chat-meta {{ $isMe ? 'justify-content-end' : '' }}">
                                        <i class="fa fa-clock" style="font-size:9px;"></i>
                                        {{ $reply->created_at->format('h:i A') }}
                                        • {{ $reply->user->name }}
                                    </div>
                                </div>
                            </div>

                            {{-- Avatar أنا - على اليمين --}}
                            @if ($isMe)
                                <div class="chat-avatar me" title="{{ $reply->user->name }}">
                                    {{ $initials }}
                                </div>
                            @endif

                        </div>
                    @empty
                        <div class="text-center text-secondary py-4">
                            <i class="fa fa-comments fa-2x d-block mb-2 opacity-25"></i>
                            <small>{{ __('No replies yet. Start the conversation!') }}</small>
                        </div>
                    @endforelse
                </div>

                {{-- Typing Indicator --}}
                <div class="typing-indicator" id="typing-indicator">
                    <div class="chat-avatar other" style="width:28px;height:28px;font-size:10px;"
                        id="typing-avatar">?</div>
                    <span id="typing-name"></span>
                    <div class="dots"><i></i><i></i><i></i></div>
                </div>

                {{-- ══════ Reply Box ══════ --}}
                @if ($status != 'closed')
                    @php
                        $myName     = auth()->user()->name;
                        $myParts    = explode(' ', trim($myName));
                        $myInitials = strtoupper(
                            substr($myParts[0], 0, 1) .
                            (isset($myParts[1]) ? substr($myParts[1], 0, 1) : substr($myParts[0], 1, 1))
                        );
                    @endphp
                    <div class="reply-box mt-3">
                        <div class="chat-avatar me">{{ $myInitials }}</div>
                        <form wire:submit.prevent="addReply" class="d-flex align-items-end gap-2 flex-fill">
                            <textarea
                                wire:model.live="message"
                                id="reply-textarea"
                                class="reply-textarea form-control"
                                rows="1"
                                placeholder="{{ __('Type your reply...') }}"
                                onInput="this.style.height='auto';this.style.height=this.scrollHeight+'px'">
                            </textarea>
                            <button type="submit" class="send-btn">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>

                @else
                    <div class="mt-3 p-3 rounded-3 text-center"
                        style="background: rgba(220,53,69,.1); border: 1px solid rgba(220,53,69,.2);">
                        <i class="fa fa-lock text-danger me-1"></i>
                        <span class="text-danger small">
                            {{ __('This ticket is closed. No more replies allowed.') }}
                        </span>
                    </div>
                @endif

            </div>
            {{-- end chat box --}}

            {{-- ══════════════ FEEDBACK ══════════════ --}}
            @if ($status == 'closed' && auth()->id() === $ticket->user_id)

                @if ($feedbackSubmitted)
                    <div class="rounded-4 p-4 text-center"
                        style="background: rgba(25,135,84,.08); border: 1px solid rgba(25,135,84,.2);">
                        <div class="mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star"
                                    style="color: {{ $i <= $rating ? '#ffc107' : '#3a3d42' }}; font-size: 22px;"></i>
                            @endfor
                        </div>
                        <p class="text-success fw-bold mb-1">
                            <i class="fa fa-check-circle me-1"></i> {{ __('Thanks for your rating') }}!
                        </p>
                        @if ($comment)
                            <p class="text-secondary small mb-0">"{{ $comment }}"</p>
                        @endif
                    </div>

                @else
                    <div class="rounded-4 p-4"
                        style="background: #111318; border: 1px solid rgba(255,255,255,.07);">
                        <h6 class="text-white fw-bold text-center mb-1">
                            <i class="fa fa-star text-warning me-1"></i>
                            {{ __('How was your experience?') }}
                        </h6>
                        <p class="text-secondary text-center small mb-4">
                            {{ __('Your feedback helps us improve') }}
                        </p>

                        <div class="star-rating d-flex justify-content-center gap-3 mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star"
                                    wire:click="setRating({{ $i }})"
                                    style="color: {{ $i <= $rating ? '#ffc107' : '#3a3d42' }};">
                                </i>
                            @endfor
                        </div>

                        @error('rating')
                            <div class="text-danger text-center small mb-2">{{ $message }}</div>
                        @enderror

                        <textarea
                            wire:model.live="comment"
                            rows="3"
                            class="form-control mb-3"
                            style="background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.1);
                                   color: #f8f9fa; border-radius: 12px;"
                            placeholder="{{ __('Add a comment (optional)...') }}"
                            maxlength="500">
                        </textarea>

                        <button wire:click="submitFeedback" class="btn btn-warning w-100 fw-bold"
                            style="border-radius: 12px;">
                            <i class="fa fa-paper-plane me-1"></i> {{ __('Submit Feedback') }}
                        </button>
                    </div>
                @endif

            @endif

        </div>
        {{-- end card-body --}}

        <audio id="new-reply-sound" preload="auto">
            <source src="{{ asset('sounds/message.mp3') }}" type="audio/mpeg">
        </audio>
        <button id="scrollDownBtn" class="scroll-down-btn">↓</button>

    </div>
</div>

<script>
document.addEventListener('livewire:initialized', () => {

    const ticketId      = {{ $ticket->id }};
    const authId        = {{ auth()->id() }};
    const authName      = @json(auth()->user()->name);
    const chatContainer = document.getElementById('chat-container');
    const msgAudio      = document.getElementById('new-reply-sound');
    const scrollBtn     = document.getElementById('scrollDownBtn');
    const typingEl      = document.getElementById('typing-indicator');
    const typingNameEl  = document.getElementById('typing-name');
    const typingAvatar  = document.getElementById('typing-avatar');
    const textarea      = document.getElementById('reply-textarea');
    let canPlay = false, typingTimeout = null;

    // ── فك حظر الصوت ──
    window.addEventListener('click', () => {
        canPlay = true;
        msgAudio.play().then(() => { msgAudio.pause(); msgAudio.currentTime = 0; }).catch(() => {});
    }, { once: true });

    // ── Scroll ──
    const scrollToBottom = (behavior = 'smooth') => {
        if (!chatContainer) return;
        setTimeout(() => chatContainer.scrollTo({ top: chatContainer.scrollHeight, behavior }), 100);
    };
    scrollToBottom('auto');

    chatContainer?.addEventListener('scroll', () => {
        const isBottom = chatContainer.scrollHeight - chatContainer.scrollTop <= chatContainer.clientHeight + 100;
        scrollBtn.style.display = isBottom ? 'none' : 'block';
    });
    scrollBtn?.addEventListener('click', () => scrollToBottom());

    // ── XSS ──
    const escapeHtml = t => t
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');

    // ── Initials ──
    const getInitials = (name) => {
        const parts = name.trim().split(' ');
        return (parts[0][0] + (parts[1] ? parts[1][0] : (parts[0][1] || ''))).toUpperCase();
    };

    // ── Append Bubble ✅ Avatar صح اليمين واليسار ──
    const appendBubble = (data) => {
        if (!chatContainer) return;
        const isMe     = data.user_id === authId;
        const initials = getInitials(data.user_name);
        const avatarHtml = `<div class="chat-avatar ${isMe ? 'me' : 'other'}"
            title="${escapeHtml(data.user_name)}">${initials}</div>`;

        chatContainer.insertAdjacentHTML('beforeend', `
            <div class="d-flex chat-row gap-2 align-items-end
                ${isMe ? 'justify-content-end' : 'justify-content-start'}">

                ${!isMe ? avatarHtml : ''}

                <div style="max-width:68%;">
                    <div class="chat-bubble ${isMe ? 'me' : 'other'}" dir="auto">
                        <div class="text-white">${escapeHtml(data.message)}</div>
                        <div class="chat-meta ${isMe ? 'justify-content-end' : ''}">
                            <i class="fa fa-clock" style="font-size:9px;"></i>
                            ${data.created_at} • ${escapeHtml(data.user_name)}
                        </div>
                    </div>
                </div>

                ${isMe ? avatarHtml : ''}
            </div>`);
    };

    // ── Typing ──
    const showTyping = (name) => {
        if (!typingEl) return;
        typingNameEl.textContent = name + ' يكتب الآن...';
        typingAvatar.textContent = getInitials(name);
        typingEl.style.display = 'flex';
        clearTimeout(typingTimeout);
        typingTimeout = setTimeout(() => { typingEl.style.display = 'none'; }, 3000);
    };

    // ── Pusher ──
    window.Echo.private(`ticket.${ticketId}`)
        .listen('NewTicketReply', (data) => {
            appendBubble(data);
            scrollToBottom();
            if (canPlay) { msgAudio.currentTime = 0; msgAudio.play().catch(() => {}); }
            if (navigator.vibrate) navigator.vibrate(40);

        // ✅ لو الـ status اتغير لـ closed - refresh الـ component
        if (data.ticket_status && data.ticket_status === 'closed') {
            setTimeout(() => {
                window.location.reload();
                // أو: Livewire.dispatch('refreshTicket');
            }, 500);
        }
        })
        .listenForWhisper('typing', (data) => showTyping(data.name));

    // ── Whisper ──
    let whisperTimeout = null;
    textarea?.addEventListener('input', () => {
        clearTimeout(whisperTimeout);
        window.Echo.private(`ticket.${ticketId}`).whisper('typing', { name: authName });
        whisperTimeout = setTimeout(() => {}, 3000);
    });

    // ── رسالة المُرسِل ──
    Livewire.on('reply-added', (data) => {
        appendBubble(data[0]);
        scrollToBottom();
    });

});
</script>
