<div class="p-2"> {{-- ✅ شيلنا wire:poll خالص --}}

    {{-- ===================== STYLES ===================== --}}
    <style>
        /* Chat Wrapper */
        .chat-wrapper {
            max-height: 420px;
            overflow-y: auto;
            padding-right: 6px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }

        /* Scrollbar */
        .chat-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .chat-wrapper::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .3);
            border-radius: 10px;
        }

        .chat-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, .5);
        }

        .chat-wrapper {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .4) transparent;
        }

        /* Chat Rows */
        .chat-row {
            animation: fadeUp .25s ease-in-out;
        }

        /* Chat Bubble */
        .chat-bubble {
            max-width: 75%;
            padding: 14px 18px;
            border-radius: 18px;
            word-break: break-word;
            touch-action: pan-y;
        }

        .chat-bubble.me {
            background: rgba(13, 110, 253, .35);
            border-bottom-right-radius: 6px;

                {
                    {
                    -- ✅ صح - رسالتك على اليمين --
                }
            }
        }

        .chat-bubble.other {
            background: rgba(33, 37, 41, .9);
            border-bottom-left-radius: 6px;

                {
                    {
                    -- ✅ صح - رسالة التاني على الشمال --
                }
            }
        }

        .chat-meta {
            font-size: 12px;
            opacity: .75;
            margin-top: 4px;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: none;

                {
                    {
                    -- ✅ مخفي بالـ CSS - الـ JS هو اللي بيظهره --
                }
            }

            align-items: center;
            gap: 6px;
            font-size: 13px;
            opacity: .75;
            margin-top: 6px;
        }

        .typing-indicator .dots {
            display: flex;
            gap: 4px;
        }

        .typing-indicator .dots i {
            width: 5px;
            height: 5px;
            background: #adb5bd;
            border-radius: 50%;
            animation: blink 1.4s infinite both;
        }

        .typing-indicator .dots i:nth-child(2) {
            animation-delay: .2s
        }

        .typing-indicator .dots i:nth-child(3) {
            animation-delay: .4s
        }

        /* Scroll Down Button */
        .scroll-down-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: none;
            background: #0d6efd;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            display: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .4);
            z-index: 999;
        }

        @keyframes blink {
            0% {
                opacity: .2
            }

            20% {
                opacity: 1
            }

            100% {
                opacity: .2
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(8px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

    </style>

    <div class="card">
        <div class="card-header bg bg-dark rounded-4 text-white p-3 rounded">
            <h2 class="text-xl font-bold text-white text-start">{{ __('Subject') }} : {{ $ticket->title }}</h2>
            <hr>
            <p class="font-bold text-white p-2">{{ __('Message') }} : {!! $ticket->description !!}</p>
            @if ($image)
            <div class="col-lg-12 mt-3">
                <a href="{{ asset('storage/' . $image) }}" target="_blank">
                    <img src="{{ asset('storage/' . $image) }}" style="width: 10rem; height: 10rem;" />
                </a>
            </div>
            @endif
        </div>

        <div class="card-body">
            @php
            $statusClasses = [
            'new' => 'bg-dark bg-opacity-25',
            'open' => 'bg-success text-dark bg-opacity-25',
            'in_progress' => 'bg-warning bg-opacity-25',
            'closed' => 'bg-danger bg-opacity-25',
            ];
            $currentClass = $statusClasses[$ticket->status] ?? 'bg-light';
            @endphp

            <div class="row {{ $currentClass }} rounded p-3 mb-4">
                <div class="col-lg-6 text-dark">
                    <div><strong>{{ __('Status') }}:</strong> {{ ucfirst($ticket->status) }}</div>
                    <div><strong>{{ __('Department') }}:</strong> {{ $ticket->category->name }}</div>
                    <div><strong>{{ __('From') }}:</strong> {{ ucFirst($ticket->user->name) }}</div>
                    <div class="text-start mt-2">
                        <small>
                            <b class="text-danger">{{ __('Created At') }}:</b>
                            {{ $ticket->created_at->format('d M Y, h:i A') }}
                        </small>
                    </div>
                </div>

                @can('manage tickets')
                @if($status != 'closed')
                <div class="col-lg-6 text-dark">
                    <form wire:submit.prevent="update_Status" class="text-end">
                        <div class="mb-3">
                            <label for="status"><strong>{{ __('Change Status') }}:</strong></label>
                            <select wire:model="status" id="status" class="form-control-sm @error('status') is-invalid @enderror">
                                <option value="">{{ __('Choose One') }}</option>
                                <option value="new">{{ __('Back To New') }}</option>
                                <option value="open">{{ __('Open') }}</option>
                                <option value="in_progress">{{ __('In Progress') }}</option>
                                <option value="closed">{{ __('Closed') }}</option>
                            </select>
                            @error('status')
                            <br><span class="text-danger">{{ $message }}</span><br>
                            @enderror
                            <button class="btn btn-primary ms-2">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                @endcan
            </div>

            {{-- ===================== CHAT ===================== --}}
            <div class="row bg-dark text-white rounded-4 p-4 mb-4">
                <div class="col-12">
                    <h3 class="mt-2 text-white">{{ __('Replies') }}</h3>
                    <hr class="border-secondary">
                </div>

                <div class="col-12 chat-wrapper" id="chat-container">
                    @foreach ($ticket->replies as $reply)
                    @php $isMe = $reply->user->id == auth()->id(); @endphp
                    <div class="d-flex mb-2 chat-row {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="chat-bubble {{ $isMe ? 'me' : 'other' }}" dir="auto">
                            <div>{{ $reply->message }}</div> {{-- ✅ مش {!! !!} --}}
                            <div class="chat-meta">
                                {{ $reply->user->name }} • {{ $reply->created_at->format('h:i A') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Typing Indicator - ✅ مخفي دايمًا، الـ JS هو اللي بيظهره عبر Whisper --}}
            <div class="typing-indicator mb-2" id="typing-indicator">
                <span id="typing-name"></span>
                <span class="dots"><i></i><i></i><i></i></span>
            </div>

            {{-- Reply Form --}}
            @if ($status !='closed')

            <form wire:submit.prevent="addReply" class="mt-3">
                <textarea wire:model.live="message" id="reply-textarea" rows="3" class="form-control" placeholder="{{ __('Type your reply...') }}"></textarea>
                <button class="btn btn-success mt-2">
                    <i class="fa fa-paper-plane"></i> {{ __('Send') }}
                </button>
            </form>

            @else
            {{-- ===================== CLOSED - FEEDBACK ===================== --}}
            <div class="alert alert-danger text-center mb-3">
                <i class="fa fa-lock me-1"></i>
                {{ __('This ticket is closed. No more replies allowed.') }}
            </div>

            {{-- فقط صاحب التذكرة يقيّم --}}
            @if (auth()->id() === $ticket->user_id)
            @if ($feedbackSubmitted)
            {{-- ✅ تم التقييم --}}
            <div class="card border-0 bg-success bg-opacity-10 text-center p-4 rounded-4">
                <div class="mb-2">
                    @for ($i = 1; $i <= 5; $i++) <i class="fa fa-star fa-lg {{ $i <= $rating ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                </div>
                <p class="text-success fw-bold mb-1">
                    <i class="fa fa-check-circle me-1"></i> {{ __('Thanks for your rating') }}.
                </p>
                @if ($comment)
                <p class="text-muted small mb-0">"{{ $comment }}"</p>
                @endif
            </div>
            @else
            {{-- ⭐ فورم التقييم --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mt-2">
                <h5 class="text-center mb-3">
                    <i class="fa fa-star text-warning me-1"></i>
                    {{ __('How was your experience?') }}
                </h5>

                {{-- Stars --}}
                <div class="d-flex justify-content-center gap-2 mb-3">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star fa-2x"
                            wire:click="setRating({{ $i }})"
                            style="cursor: pointer; color: {{ $i <= $rating ? '#ffc107' : '#dee2e6' }};">
                        </i>
                    @endfor
                </div>
                <input type="hidden" wire:model="rating" id="rating-input">

                @error('rating')
                <div class="text-danger text-center small mb-2">{{ $message }}</div>
                @enderror

                {{-- Comment --}}
                <textarea wire:model.live="comment" rows="3" class="form-control mb-3" placeholder="{{ __('Add a comment (optional)...') }}" maxlength="500">
            </textarea>

                <button wire:click="submitFeedback" class="btn btn-warning w-100 rounded-pill">
                    <i class="fa fa-paper-plane me-1"></i> {{ __('Submit Feedback') }}
                </button>
            </div>
            @endif
            @endif
            @endif
        </div>

        {{-- Audio + Scroll Button --}}
        <audio id="new-reply-sound" preload="auto">
            <source src="{{ asset('sounds/message.mp3') }}" type="audio/mpeg">
        </audio>
        <button id="scrollDownBtn" class="scroll-down-btn">↓</button>
    </div>
</div>

{{-- ===================== SCRIPT - مرة واحدة بس ✅ ===================== --}}
<script>
    document.addEventListener('livewire:initialized', () => {
        console.log(window.Echo)
        // ── المتغيرات الأساسية ──────────────────────────────────────────
        const ticketId = {{$ticket->id}};
        const authId = {{auth()->id()}};
        const authName = @json(auth()->user()->name);
        const chatContainer = document.getElementById('chat-container');
        const msgAudio = document.getElementById('new-reply-sound');
        const scrollBtn = document.getElementById('scrollDownBtn');
        const typingEl = document.getElementById('typing-indicator');
        const typingName = document.getElementById('typing-name');
        const textarea = document.getElementById('reply-textarea');
        let canPlay = false;
        let typingTimeout = null;

        // ── فك حظر الصوت عند أول نقرة ──────────────────────────────────
        window.addEventListener('click', () => {
            canPlay = true;
            msgAudio.play()
                .then(() => {
                    msgAudio.pause();
                    msgAudio.currentTime = 0;
                })
                .catch(() => {});
        }, {
            once: true
        });

        // ── Scroll to bottom ────────────────────────────────────────────
        const scrollToBottom = (behavior = 'smooth') => {
            if (!chatContainer) return;
            setTimeout(() => {
                chatContainer.scrollTo({
                    top: chatContainer.scrollHeight
                    , behavior
                });
            }, 100);
        };

        scrollToBottom('auto');

        // ── زر السهم ────────────────────────────────────────────────────
        chatContainer ? .addEventListener('scroll', () => {
            const isBottom = chatContainer.scrollHeight - chatContainer.scrollTop <=
                chatContainer.clientHeight + 100;
            scrollBtn.style.display = isBottom ? 'none' : 'block';
        });
        scrollBtn ? .addEventListener('click', () => scrollToBottom());

        // ── حماية من XSS ────────────────────────────────────────────────
        const escapeHtml = (text) => text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');

        // ── إضافة فقاعة رسالة جديدة في الـ DOM مباشرة ───────────────────
        const appendBubble = (data) => {
            const isMe = data.user_id === authId;
            const bubble = `
            <div class="d-flex mb-2 chat-row ${isMe ? 'justify-content-end' : 'justify-content-start'}">
                <div class="chat-bubble ${isMe ? 'me' : 'other'}" dir="auto">
                    <div>${escapeHtml(data.message)}</div>
                    <div class="chat-meta">${escapeHtml(data.user_name)} • ${data.created_at}</div>
                </div>
            </div>`;
            chatContainer ? .insertAdjacentHTML('beforeend', bubble);
        };

        // ── Typing Indicator ────────────────────────────────────────────
        const showTyping = (name) => {
            typingName.textContent = name + ' يكتب الآن';
            typingEl.style.display = 'flex';
            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                typingEl.style.display = 'none';
            }, 3000);
        };

        // ── Pusher: Listen على رسائل جديدة ──────────────────────────────
        window.Echo.private(`ticket.${ticketId}`)
            .listen('NewTicketReply', (data) => {
                appendBubble(data);
                scrollToBottom();

                if (canPlay) {
                    msgAudio.currentTime = 0;
                    msgAudio.play().catch(() => {});
                }
                if (navigator.vibrate) navigator.vibrate(40);
            })
            // ── Pusher Whisper: Typing Indicator بدون Cache ──────────────
            .listenForWhisper('typing', (data) => {
                showTyping(data.name);
            });

        // ── إرسال Whisper عند الكتابة (بدل wire:keydown) ─────────────────
        let whisperTimeout = null;
        textarea ? .addEventListener('input', () => {
            clearTimeout(whisperTimeout);
            console.log(window.Echo)
            window.Echo.private(`ticket.${ticketId}`)
                .whisper('typing', {
                    name: authName
                });

            // وقف الـ whisper بعد 3 ثواني من آخر حرف
            whisperTimeout = setTimeout(() => {}, 3000);
        });

        // ── بعد ما Livewire يرسل الرسالة (رسالة صاحبها) ─────────────────
        // رسالة المُرسِل نفسه مش بتيجي من Pusher (toOthers)
        // فنضيفها بعد submit مباشرة عن طريق Livewire event
        Livewire.on('reply-added', (data) => {
            appendBubble(data[0]);
            scrollToBottom();
        });




    });

</script>
