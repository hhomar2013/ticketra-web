<div class="p-4">

    @push('styles')
    <style>
        .stat-card {
            border-radius: 16px;
            border: none;
            transition: transform .2s, box-shadow .2s;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .1) !important;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .ticket-row:hover {
            background: #f8f9fa;
        }

        .agent-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
        }

        .bar-chart-bar {
            border-radius: 6px 6px 0 0;
            transition: opacity .2s;
            min-height: 4px;
        }

        .bar-chart-bar:hover {
            opacity: .8;
        }

        .rating-bar {
            height: 6px;
            border-radius: 10px;
            background: #e9ecef;
            overflow: hidden;
        }

        .rating-fill {
            height: 100%;
            border-radius: 10px;
            background: #ffc107;
        }

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

        .bg-success-subtle  { background-color: #d1e7dd !important; }
        .bg-warning-subtle  { background-color: #fff3cd !important; }
        .bg-danger-subtle   { background-color: #f8d7da !important; }
        .bg-secondary-subtle{ background-color: #e2e3e5 !important; }
    </style>
    @endpush

    {{-- ===================== WELCOME ===================== --}}
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
            </div>
            <div class="d-none d-md-block text-white" style="position: relative; z-index: 1;">
                <i class="fa fa-calendar me-1"></i> {{ now()->format('l, d M Y') }}
            </div>
        </div>
    </div>

    {{-- ===================== STAT CARDS ===================== --}}
    <div class="row g-3 mb-4">

        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="fa fa-ticket text-primary"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary small">All</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                    <p class="text-muted small mb-0 mt-1">Total Tickets</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-secondary bg-opacity-10">
                            <i class="fa fa-inbox text-secondary"></i>
                        </div>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary small">New</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['new'] }}</h3>
                    <p class="text-muted small mb-0 mt-1">New Tickets</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-warning bg-opacity-10">
                            <i class="fa fa-spinner text-warning"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning small">WIP</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['in_progress'] }}</h3>
                    <p class="text-muted small mb-0 mt-1">In Progress</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-success bg-opacity-10">
                            <i class="fa fa-check-circle text-success"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success small">Done</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['closed'] }}</h3>
                    <p class="text-muted small mb-0 mt-1">Closed Tickets</p>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mb-4">

        {{-- ===================== BAR CHART ===================== --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="fw-bold mb-0">Tickets This Week</h6>
                            <small class="text-muted">New tickets per day</small>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary">Last 7 days</span>
                    </div>

                    {{-- Bar Chart --}}
                    @php $maxVal = $weeklyData->max('count') ?: 1; @endphp
                    <div class="d-flex align-items-end justify-content-between gap-2" style="height: 120px;">
                        @foreach ($weeklyData as $day)
                            @php $height = max(4, ($day['count'] / $maxVal) * 100); @endphp
                            <div class="d-flex flex-column align-items-center flex-fill">
                                <small class="text-muted mb-1" style="font-size: 10px;">{{ $day['count'] }}</small>
                                <div class="bar-chart-bar w-100 bg-primary"
                                    style="height: {{ $height }}%; opacity: {{ $day['day'] === now()->format('D') ? '1' : '.5' }};">
                                </div>
                                <small class="text-muted mt-1" style="font-size: 10px;">{{ $day['day'] }}</small>
                            </div>
                        @endforeach
                    </div>

                    {{-- Status breakdown --}}
                    <hr class="my-3">
                    <div class="row g-2 text-center">
                        <div class="col-3">
                            <div class="fw-bold text-secondary">{{ $stats['new'] }}</div>
                            <small class="text-muted" style="font-size: 11px;">New</small>
                        </div>
                        <div class="col-3">
                            <div class="fw-bold text-success">{{ $stats['open'] }}</div>
                            <small class="text-muted" style="font-size: 11px;">Open</small>
                        </div>
                        <div class="col-3">
                            <div class="fw-bold text-warning">{{ $stats['in_progress'] }}</div>
                            <small class="text-muted" style="font-size: 11px;">In Progress</small>
                        </div>
                        <div class="col-3">
                            <div class="fw-bold text-danger">{{ $stats['closed'] }}</div>
                            <small class="text-muted" style="font-size: 11px;">Closed</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== SATISFACTION ===================== --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-1">Customer Satisfaction</h6>
                    <small class="text-muted">Based on {{ $totalFeedbacks }} feedbacks</small>

                    <div class="text-center my-4">
                        <div style="font-size: 48px; line-height: 1;">{{ $avgRating }}</div>
                        <div class="mt-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star" style="color: {{ $i <= round($avgRating) ? '#ffc107' : '#dee2e6' }};"></i>
                            @endfor
                        </div>
                        <small class="text-muted">out of 5.0</small>
                    </div>

                    {{-- Rating Bars --}}
                    @php
                        $ratingCounts = \App\Models\TicketFeedback::selectRaw('rating, count(*) as count')
                            ->groupBy('rating')->pluck('count', 'rating');
                    @endphp
                    <div class="vstack gap-2">
                        @for ($i = 5; $i >= 1; $i--)
                            @php
                                $cnt = $ratingCounts[$i] ?? 0;
                                $pct = $totalFeedbacks > 0 ? ($cnt / $totalFeedbacks) * 100 : 0;
                            @endphp
                            <div class="d-flex align-items-center gap-2">
                                <small class="text-muted" style="width: 12px;">{{ $i }}</small>
                                <i class="fa fa-star text-warning" style="font-size: 10px;"></i>
                                <div class="rating-bar flex-fill">
                                    <div class="rating-fill" style="width: {{ $pct }}%;"></div>
                                </div>
                                <small class="text-muted" style="width: 20px; font-size: 11px;">{{ $cnt }}</small>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3">

        {{-- ===================== RECENT TICKETS ===================== --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                <div class="card-body p-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Recent Tickets</h6>
                        <a href="{{ route('it.tickets.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            View All <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small text-muted fw-normal">#</th>
                                <th class="small text-muted fw-normal">Title</th>
                                <th class="small text-muted fw-normal">From</th>
                                <th class="small text-muted fw-normal">Assigned</th>
                                <th class="small text-muted fw-normal">Status</th>
                                <th class="small text-muted fw-normal pe-4">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentTickets as $ticket)
                                <tr class="ticket-row">
                                    <td class="ps-4">
                                        <span class="badge bg-light text-dark border">#{{ $ticket->id }}</span>
                                    </td>
                                    <td style="max-width: 180px;">
                                        <a href="{{ route('it.tickets.show', $ticket->id) }}"
                                            class="text-decoration-none text-dark fw-bold text-truncate d-block"
                                            title="{{ $ticket->title }}">
                                            {{ $ticket->title }}
                                        </a>
                                        <small class="text-muted">{{ $ticket->category->name ?? '-' }}</small>
                                    </td>
                                    <td class="small">{{ $ticket->user->name }}</td>
                                    <td>
                                        @if ($ticket->assignedUser)
                                            <div class="d-flex align-items-center gap-1">
                                                <div class="agent-avatar bg-success bg-opacity-10 text-success"
                                                    style="width:28px;height:28px;font-size:10px;">
                                                    {{ strtoupper(substr($ticket->assignedUser->name, 0, 2)) }}
                                                </div>
                                                <small>{{ $ticket->assignedUser->name }}</small>
                                            </div>
                                        @else
                                            <small class="text-muted">—</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- ✅ استخدام Enum --}}
                                        <span class="badge rounded-pill px-2 {{ $ticket->status->subColor() }}">
                                            {{ $ticket->status->label() }}
                                        </span>
                                    </td>
                                    <td class="text-muted small pe-4">
                                        {{ $ticket->created_at->format('d M') }}<br>
                                        <span style="font-size:10px;">{{ $ticket->created_at->diffForHumans() }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fa fa-inbox fa-2x d-block mb-2 opacity-25"></i>
                                        No tickets yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===================== TOP AGENTS ===================== --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-1">Top Agents</h6>
                    <small class="text-muted d-block mb-4">Most tickets closed</small>

                    @forelse ($topAgents as $index => $agent)
                        @php
                            $colors = ['bg-warning', 'bg-secondary', 'bg-danger'];
                            $bgColor = $colors[$index] ?? 'bg-primary';
                        @endphp
                        <div class="d-flex align-items-center gap-3 mb-3 p-2 rounded-3" style="background: #f8f9fa;">
                            <div class="position-relative">
                                <div class="agent-avatar {{ $bgColor }} bg-opacity-20 text-dark">
                                    {{ strtoupper(substr($agent->name, 0, 2)) }}
                                </div>
                                @if ($index === 0)
                                    <span class="position-absolute top-0 start-100 translate-middle"
                                        style="font-size: 10px;">🏆</span>
                                @endif
                            </div>
                            <div class="flex-fill">
                                <div class="fw-bold small">{{ $agent->name }}</div>
                                <small class="text-muted">{{ $agent->closed_count }} tickets closed</small>
                            </div>
                            <span class="badge {{ $bgColor }} bg-opacity-20 text-dark fw-bold">
                                #{{ $index + 1 }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fa fa-users fa-2x d-block mb-2 opacity-25"></i>
                            <small>No data yet</small>
                        </div>
                    @endforelse

                    @if ($topAgents->isNotEmpty())
                        <hr class="my-3">
                        <a href="{{ route('it.reports.feedback') }}"
                            class="btn btn-outline-warning w-100 btn-sm rounded-pill">
                            <i class="fa fa-star me-1"></i> View Feedback Report
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
