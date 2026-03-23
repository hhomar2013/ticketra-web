<div class="p-3">

    @push('styles')
    <style>
        /* ── Form Card ── */
        .form-card {
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }
        .form-card .card-header-band {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            padding: 28px 32px;
            position: relative;
            overflow: hidden;
        }
        .form-card .card-header-band::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 140px; height: 140px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
        }
        .form-card .card-header-band::after {
            content: '';
            position: absolute;
            bottom: -20px; right: 80px;
            width: 90px; height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }

        /* ── Inputs ── */
        .form-field {
            background: #f8f9fa !important;
            border: 1.5px solid transparent !important;
            border-radius: 12px !important;
            transition: border-color .2s, box-shadow .2s;
            font-size: 14px;
        }
        .form-field:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 4px rgba(13,110,253,.08) !important;
            background: #fff !important;
        }
        .form-label-custom {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 6px;
        }

        /* ── Upload Box ── */
        .upload-box {
            width: 100%;
            border: 2px dashed #dee2e6;
            border-radius: 14px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s, background .2s;
            background: #f8f9fa;
        }
        .upload-box:hover {
            border-color: #0d6efd;
            background: rgba(13,110,253,.03);
        }
        .upload-box .preview-img {
            width: 80px; height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* ── Ticket Cards ── */
        .ticket-card {
            border-radius: 18px;
            border: none;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }
        .ticket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 28px rgba(0,0,0,.1) !important;
        }
        .ticket-card .color-bar { height: 5px; }

        /* ── Badges ── */
        .bg-success-subtle  { background-color: #d1e7dd !important; color: #0f5132 !important; }
        .bg-warning-subtle  { background-color: #fff3cd !important; color: #664d03 !important; }
        .bg-danger-subtle   { background-color: #f8d7da !important; color: #842029 !important; }
        .bg-secondary-subtle{ background-color: #e2e3e5 !important; color: #41464b !important; }
        .bg-primary-subtle  { background-color: #cfe2ff !important; color: #084298 !important; }
    </style>
    @endpush

    {{-- ══════════════ CREATE FORM ══════════════ --}}
    <div class="row justify-content-center mb-5">
        <div class="col-xl-7 col-lg-9">
            <div class="card form-card shadow-sm">

                {{-- Header Band --}}
                <div class="card-header-band">
                    <div class="d-flex align-items-center gap-3" style="position: relative; z-index: 1;">
                        <div style="width: 48px; height: 48px; border-radius: 14px;
                            background: rgba(255,255,255,.2);
                            display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            🎫
                        </div>
                        <div>
                            <h5 class="text-white fw-bold mb-0">{{ __('Submit a New Ticket') }}</h5>
                            <p class="text-white text-opacity-75 small mb-0">
                                {{ __('Describe your issue and we\'ll get back to you ASAP') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">

                    @if (session()->has('message'))
                        <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="submit">
                        <div class="vstack gap-4">

                            {{-- Title --}}
                            <div>
                                <label class="form-label-custom">{{ __('Title') }}</label>
                                <input wire:model="title"
                                    type="text"
                                    class="form-control form-field @error('title') is-invalid @enderror"
                                    placeholder="{{ __('Brief summary of your issue') }}">
                                @error('title')
                                    <span class="text-danger small mt-1 d-block">
                                        <i class="fa fa-circle-exclamation me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label class="form-label-custom">{{ __('Description') }}</label>
                                <textarea wire:model="description"
                                    class="form-control form-field @error('description') is-invalid @enderror"
                                    rows="4"
                                    placeholder="{{ __('Describe your issue in detail...') }}">
                                </textarea>
                                @error('description')
                                    <span class="text-danger small mt-1 d-block">
                                        <i class="fa fa-circle-exclamation me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Image Upload --}}
                            <div>
                                <label class="form-label-custom">
                                    {{ __('Attach a photo') }}
                                    <span class="text-muted fw-normal" style="text-transform: none; letter-spacing: 0;">
                                        ({{ __('optional') }})
                                    </span>
                                </label>
                                <label for="image" class="d-block">
                                    <div class="upload-box">
                                        @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}"
                                                class="preview-img mb-2">
                                            <div class="text-success small fw-bold">
                                                <i class="fa fa-check-circle me-1"></i>
                                                {{ __('Image ready') }}
                                            </div>
                                            <div class="text-muted" style="font-size: 11px;">
                                                {{ __('Click to change') }}
                                            </div>
                                        @else
                                            <div style="font-size: 28px; margin-bottom: 8px;">📎</div>
                                            <div class="fw-bold small text-dark mb-1">
                                                {{ __('Click to upload a photo') }}
                                            </div>
                                            <div class="text-muted" style="font-size: 11px;">
                                                PNG, JPG up to 2MB
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" wire:model="image" id="image" hidden />
                                </label>
                                @error('image')
                                    <span class="text-danger small mt-1 d-block">
                                        <i class="fa fa-circle-exclamation me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                class="btn btn-primary btn-lg rounded-pill w-100 fw-bold shadow-sm"
                                style="letter-spacing: .3px;">
                                <i class="fas fa-paper-plane me-2"></i>
                                {{ __('Send Ticket') }}
                                <span wire:loading wire:target="submit">
                                    <span class="spinner-border spinner-border-sm ms-1"></span>
                                </span>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════ TICKET LIST ══════════════ --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h5 class="fw-bold mb-0">
                <i class="fas fa-list-ul text-primary me-2"></i>
                {{ __('My Tickets') }}
            </h5>
            <small class="text-muted">{{ __('Track the status of your submissions') }}</small>
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
            {{ count($tickets) }} {{ __('tickets') }}
        </span>
    </div>

    @if(count($tickets))
        <div class="row g-3">
            @foreach ($tickets as $ticket)
                <div class="col-md-6 col-lg-4">
                    <div class="card ticket-card shadow-sm h-100">

                        {{-- Color Bar ✅ --}}
                        <div class="color-bar bg-{{ $ticket->status->color() }}"></div>

                        <div class="card-body p-4">

                            {{-- Top Row --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-light text-muted border fw-normal"
                                    style="font-size: 11px;">#{{ $ticket->id }}</span>

                                {{-- Badge ✅ --}}
                                <span class="badge rounded-pill px-3 {{ $ticket->status->subColor() }}">
                                    {{ $ticket->status->emoji() }}
                                    {{ $ticket->status->label() }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h6 class="fw-bold text-dark mb-3 text-truncate" title="{{ $ticket->title }}">
                                {{ $ticket->title }}
                            </h6>

                            {{-- Meta --}}
                            <div class="vstack gap-1 mb-4">
                                <div class="d-flex align-items-center gap-2 text-muted small">
                                    <i class="fas fa-layer-group opacity-50" style="width: 14px;"></i>
                                    <span>{{ $ticket->category->name }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 text-muted small">
                                    <i class="fas fa-clock opacity-50" style="width: 14px;"></i>
                                    <span>{{ $ticket->created_at->diffForHumans() }}</span>
                                </div>
                                @if($ticket->replies_count ?? $ticket->replies->count())
                                    <div class="d-flex align-items-center gap-2 text-muted small">
                                        <i class="fas fa-comments opacity-50" style="width: 14px;"></i>
                                        <span>{{ $ticket->replies->count() }} {{ __('replies') }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('user.tickets.show', $ticket->id) }}"
                                    class="btn btn-primary btn-sm rounded-pill flex-grow-1 fw-bold">
                                    <i class="fas fa-eye me-1"></i> {{ __('View') }}
                                </a>
                                {{-- ✅ بدل == 'new' --}}
                                @if ($ticket->status === \App\Core\Enum\TicketStatus::New)
                                    <button
                                        wire:click.prevent="deleteTicket({{ $ticket->id }})"
                                        wire:confirm="{{ __('Are you sure you want to cancel this ticket?') }}"
                                        class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                        title="{{ __('Cancel ticket') }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div style="font-size: 56px; margin-bottom: 16px;">📭</div>
            <h6 class="fw-bold text-dark mb-1">{{ __('No tickets yet') }}</h6>
            <p class="text-muted small mb-4">{{ __('Submit your first ticket using the form above') }}</p>
        </div>
    @endif

</div>
