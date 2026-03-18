<div>
    {{-- ===================== HEADER ===================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 shadow-sm rounded-lg border-bottom">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 mb-0">
                <i class="fa fa-star text-warning me-2"></i>{{ __('Feedback Reports') }}
            </h2>
            <p class="text-muted small mb-0">{{ __('Customer satisfaction ratings') }}</p>
        </div>

        {{-- Stats --}}
        <div class="d-flex gap-3 align-items-center">
            <div class="text-center">
                <div class="fw-bold fs-4 text-warning">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star {{ $i <= round($avgRating) ? 'text-warning' : 'text-muted' }}" style="font-size: 14px;"></i>
                    @endfor
                    <span class="text-dark ms-1">{{ $avgRating }}</span>
                </div>
                <small class="text-muted">{{ __('Average Rating') }}</small>
            </div>
            <div class="text-center border-start ps-3">
                <div class="fw-bold fs-4">{{ $totalCount }}</div>
                <small class="text-muted">{{ __('Total Feedbacks') }}</small>
            </div>
        </div>
    </div>

    {{-- ===================== FILTERS ===================== --}}
    <div class="d-flex gap-2 mb-3">
        <input
            wire:model.live.debounce.400ms="search"
            type="text"
            class="form-control form-control-sm shadow-sm"
            placeholder="{{ __('Search by ticket or user...') }}"
            style="max-width: 280px;">

        <select wire:model.change="sortBy" class="form-select form-select-sm shadow-sm" style="max-width: 160px;">
            <option value="">{{ __('All Ratings') }}</option>
            <option value="5">⭐⭐⭐⭐⭐ 5</option>
            <option value="4">⭐⭐⭐⭐ 4</option>
            <option value="3">⭐⭐⭐ 3</option>
            <option value="2">⭐⭐ 2</option>
            <option value="1">⭐ 1</option>
        </select>

        <select wire:model.change="perPage" class="form-select form-select-sm shadow-sm" style="max-width: 90px;">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>

    {{-- ===================== TABLE ===================== --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="ps-4">#</th>
                    <th>{{ __('Ticket') }}</th>
                    <th>{{ __('Submitted By') }}</th>
                    <th>{{ __('Assigned To') }}</th>
                    <th>{{ __('Rating') }}</th>
                    <th>{{ __('Comment') }}</th>
                    <th>{{ __('Date') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($feedbacks as $feedback)
                <tr>
                    {{-- # --}}
                    <td class="ps-4">
                        <span class="badge bg-light text-dark border">#{{ $feedback->ticket->id }}</span>
                    </td>

                    {{-- Ticket --}}
                    <td style="max-width: 200px;">
                        <a href="{{ route('it.tickets.show', $feedback->ticket->id) }}"
                            class="text-decoration-none fw-bold text-truncate d-block"
                            title="{{ $feedback->ticket->title }}">
                            {{ $feedback->ticket->title }}
                        </a>
                        <small class="text-muted">{{ $feedback->ticket->category->name ?? '-' }}</small>
                    </td>

                    {{-- Submitted By (صاحب التذكرة) --}}
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px; font-size: 12px; font-weight: 600; color: #0d6efd;">
                                {{ strtoupper(substr($feedback->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="fw-bold small">{{ $feedback->user->name }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ $feedback->user->email }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Assigned To (الموظف) --}}
                    <td>
                        @if ($feedback->ticket->assignedUser)
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px; font-size: 12px; font-weight: 600; color: #198754;">
                                    {{ strtoupper(substr($feedback->ticket->assignedUser->name, 0, 2)) }}
                                </div>
                                <div class="fw-bold small">{{ $feedback->ticket->assignedUser->name }}</div>
                            </div>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>

                    {{-- Rating --}}
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star"
                                    style="font-size: 14px; color: {{ $i <= $feedback->rating ? '#ffc107' : '#dee2e6' }};"></i>
                            @endfor
                            <span class="ms-1 small fw-bold text-muted">({{ $feedback->rating }})</span>
                        </div>
                    </td>

                    {{-- Comment --}}
                    <td style="max-width: 200px;">
                        @if ($feedback->comment)
                            <span class="text-muted small" title="{{ $feedback->comment }}">
                                {{ Str::limit($feedback->comment, 50) }}
                            </span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>

                    {{-- Date --}}
                    <td class="text-muted small">
                        {{ $feedback->created_at->format('d M Y') }}<br>
                        <small>{{ $feedback->created_at->diffForHumans() }}</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fa fa-star fa-3x d-block mb-2 opacity-25"></i>
                        {{ __('No feedbacks yet') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ===================== PAGINATION ===================== --}}
    <div class="mt-4 d-flex justify-content-end">
        {{ $feedbacks->links() }}
    </div>
</div>
