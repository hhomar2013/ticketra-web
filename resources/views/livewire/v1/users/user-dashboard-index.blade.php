@use('App\Core\Enum\TicketStatus')

<div>
    @push('styles')
    <style>
        .stat-card {
            border-radius: 18px;
            border: none;
            transition: transform .2s, box-shadow .2s;
            overflow: hidden;
            position: relative;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, .1) !important;
        }

        .stat-card .icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .stat-card .card-stripe {
            height: 4px;
            width: 100%;
        }

        .ticket-item {
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, .06);
            transition: box-shadow .2s, transform .15s;
            background: #fff;
        }

        .ticket-item:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
            transform: translateY(-2px);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .welcome-card {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border-radius: 20px;
            border: none;
            overflow: hidden;
            position: relative;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            bottom: -30px;
            right: 60px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
        }

        .quick-action {
            border-radius: 14px;
            border: 1.5px dashed rgba(13, 110, 253, .3);
            background: rgba(13, 110, 253, .03);
            transition: all .2s;
            cursor: pointer;
            text-decoration: none;
        }

        .quick-action:hover {
            border-color: #0d6efd;
            background: rgba(13, 110, 253, .08);
            transform: translateY(-2px);
        }

        .progress-thin {
            height: 6px;
            border-radius: 10px;
        }

        .avatar-circle {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #6ea8fe);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .bg-primary-subtle {
            background-color: #cfe2ff !important;
        }

        .bg-success-subtle {
            background-color: #d1e7dd !important;
        }

        .bg-warning-subtle {
            background-color: #fff3cd !important;
        }

        .bg-secondary-subtle {
            background-color: #e2e3e5 !important;
        }

    </style>
    @endpush

    <div class="p-3">

        {{-- ══════════════ WELCOME CARD ══════════════ --}}
        <div class="welcome-card p-4 mb-4 shadow-sm">
            <div class="d-flex align-items-center justify-content-between">
                <div style="position: relative; z-index: 1;">
                    <p class="text-white text-opacity-75 mb-1 small">
                        {{ now()->format('l, d M Y') }}
                    </p>
                    <h4 class="text-white fw-bold mb-1">
                        👋 {{ __('Welcome back') }}, {{ Auth::user()->name }}!
                    </h4>
                    <p class="text-white text-opacity-75 mb-3 small">
                        {{ __('Track and manage your support tickets from here.') }}
                    </p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-light btn-sm fw-bold px-4 rounded-pill shadow-sm">
                        <i class="fa fa-plus me-1 text-primary"></i>
                        {{ __('New Ticket') }}
                    </a>
                </div>
                <div class="d-none d-md-block" style="position: relative; z-index: 1;">
                    <div style="width: 90px; height: 90px; border-radius: 50%;
                        background: rgba(255,255,255,.15); display: flex;
                        align-items: center; justify-content: center; font-size: 42px;">
                        🎫
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════ STAT CARDS ══════════════ --}}
        <div class="row g-3 mb-4">

            <div class="col-6 col-lg-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-stripe bg-primary"></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-box bg-primary bg-opacity-10">
                                <i class="fa fa-ticket text-primary"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $totalTickets }}</h3>
                        <p class="text-muted small mb-0 mt-1">{{ __('Total Tickets') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-stripe bg-warning"></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-box bg-warning bg-opacity-10">
                                <i class="fa fa-spinner text-warning"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $openTickets }}</h3>
                        <p class="text-muted small mb-0 mt-1">{{ __('In Progress') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-stripe bg-success"></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-box bg-success bg-opacity-10">
                                <i class="fa fa-check-circle text-success"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $closedTickets }}</h3>
                        <p class="text-muted small mb-0 mt-1">{{ __('Resolved') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-stripe bg-secondary"></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-box bg-secondary bg-opacity-10">
                                <i class="fa fa-inbox text-secondary"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $newTickets }}</h3>
                        <p class="text-muted small mb-0 mt-1">{{ __('Awaiting') }}</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-3">

            {{-- ══════════════ RECENT TICKETS ══════════════ --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h6 class="fw-bold mb-0">{{ __('Recent Tickets') }}</h6>
                                <small class="text-muted">{{ __('Your latest submissions') }}</small>
                            </div>
                            <a href="{{ route('tickets.create') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                {{ __('View All') }} <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        </div>

                        <div class="vstack gap-2">
                            @forelse ($recentTickets as $ticket)
                            <a href="{{ route('it.tickets.show', $ticket->id) }}" class="ticket-item p-3 d-flex align-items-center gap-3 text-decoration-none">

                                {{-- Icon ✅ --}}
                                <div style="width:40px;height:40px;min-width:40px;border-radius:12px;
                                        display:flex;align-items:center;justify-content:center;
                                        background: rgba({{ $ticket->status === TicketStatus::Closed ? '25,135,84' : ($ticket->status === TicketStatus::InProgress ? '255,193,7' : ($ticket->status === TicketStatus::Open ? '13,110,253' : '108,117,125')) }},.1);">
                                    <i class="fa {{ $ticket->status === TicketStatus::Closed ? 'fa-check-circle text-success' : ($ticket->status === TicketStatus::InProgress ? 'fa-spinner text-warning' : ($ticket->status === TicketStatus::Open ? 'fa-ticket text-primary' : 'fa-inbox text-secondary')) }}"></i>
                                </div>

                                {{-- Info --}}
                                <div class="flex-fill" style="min-width: 0;">
                                    <div class="fw-bold text-dark text-truncate small">
                                        {{ $ticket->title }}
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        <i class="fa fa-building me-1 opacity-50"></i>
                                        {{ $ticket->category->name }}
                                        <span class="mx-1">•</span>
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                {{-- Status Badge ✅ --}}
                                <span class="badge rounded-pill px-3 flex-shrink-0 {{ $ticket->status->subColor() }}">
                                    {{ $ticket->status->emoji() }} {{ $ticket->status->label() }}
                                </span>

                            </a>
                            @empty
                            <div class="text-center text-muted py-5">
                                <i class="fa fa-ticket fa-3x d-block mb-3 opacity-25"></i>
                                <p class="mb-2">{{ __('No tickets yet') }}</p>
                                <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                                    {{ __('Submit your first ticket') }}
                                </a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════ SIDEBAR ══════════════ --}}
            <div class="col-lg-4">
                <div class="vstack gap-3">

                    {{-- Resolution Rate --}}
                    <div class="card border-0 shadow-sm" style="border-radius: 18px;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-1">{{ __('Resolution Rate') }}</h6>
                            <small class="text-muted d-block mb-3">{{ __('Your tickets progress') }}</small>

                            @php
                            $rate = $totalTickets > 0
                            ? round(($closedTickets / $totalTickets) * 100)
                            : 0;
                            @endphp

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="font-size: 36px; font-weight: 700; line-height: 1;
                                    color: {{ $rate >= 70 ? '#198754' : ($rate >= 40 ? '#ffc107' : '#0d6efd') }};">
                                    {{ $rate }}%
                                </div>
                                <div class="flex-fill">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar
                                            {{ $rate >= 70 ? 'bg-success' : ($rate >= 40 ? 'bg-warning' : 'bg-primary') }}" style="width: {{ $rate }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        {{ $closedTickets }} / {{ $totalTickets }} {{ __('resolved') }}
                                    </small>
                                </div>
                            </div>

                            <div class="row g-2 text-center">
                                <div class="col-4">
                                    <div class="p-2 rounded-3" style="background: rgba(108,117,125,.08);">
                                        <div class="fw-bold small">{{ $newTickets }}</div>
                                        <div class="text-muted" style="font-size: 10px;">{{ __('New') }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 rounded-3" style="background: rgba(255,193,7,.08);">
                                        <div class="fw-bold small text-warning">{{ $openTickets }}</div>
                                        <div class="text-muted" style="font-size: 10px;">{{ __('Active') }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 rounded-3" style="background: rgba(25,135,84,.08);">
                                        <div class="fw-bold small text-success">{{ $closedTickets }}</div>
                                        <div class="text-muted" style="font-size: 10px;">{{ __('Done') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="card border-0 shadow-sm" style="border-radius: 18px;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">{{ __('Quick Actions') }}</h6>
                            <div class="vstack gap-2">
                                <a href="{{ route('tickets.create') }}" class="quick-action p-3 d-flex align-items-center gap-3">
                                    <div class="icon-box bg-primary bg-opacity-10" style="width:38px;height:38px;border-radius:10px;font-size:16px;">
                                        <i class="fa fa-plus text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small text-dark">{{ __('New Ticket') }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ __('Submit a new request') }}</div>
                                    </div>
                                    <i class="fa fa-chevron-right text-muted ms-auto" style="font-size: 11px;"></i>
                                </a>

                                <a href="{{ route('tickets.create') }}" class="quick-action p-3 d-flex align-items-center gap-3">
                                    <div class="icon-box bg-warning bg-opacity-10" style="width:38px;height:38px;border-radius:10px;font-size:16px;">
                                        <i class="fa fa-list text-warning"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small text-dark">{{ __('My Tickets') }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ __('View all your tickets') }}</div>
                                    </div>
                                    <i class="fa fa-chevron-right text-muted ms-auto" style="font-size: 11px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
