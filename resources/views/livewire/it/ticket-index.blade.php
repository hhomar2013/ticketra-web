@use('App\Core\Enum\TicketStatus')

<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">

        {{-- ===================== HEADER ===================== --}}
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 shadow-sm rounded-lg border-bottom">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 mb-0">
                    <i class="fas fa-ticket me-2"></i>{{ __('Tickets') }}
                </h2>
                <p class="text-muted small mb-0">
                    {{ __('Management and follow-up of technical support tickets') }}
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">
                {{-- Per Page --}}
                <label class="me-1 text-muted small">{{ __('Show') }}:</label>
                <select wire:model.change="perPage" class="form-select form-select-sm border-0 shadow-sm bg-light" style="width: 80px;">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>

                {{-- Sort --}}
                <label class="me-1 text-muted small">{{ __('Sort') }}:</label>
                <select wire:model.change="sortBy" class="form-select form-select-sm border-0 shadow-sm bg-light" style="width: 150px;">
                    <option value="">{{ __('Sort status') }}</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </select>

                {{-- Count --}}
                @if ($sortCount)
                    <label class="text-muted small">{{ __('Count') }}: {{ $sortCount }}</label>
                @endif

                {{-- View Toggle --}}
                <div class="btn-group ms-2 shadow-sm" role="group">
                    <button type="button" wire:click="$set('viewMode', 'card')"
                        class="btn btn-sm btn-outline-secondary {{ $viewMode === 'card' ? 'active' : '' }}"
                        title="{{ __('Card View') }}">
                        <i class="fas fa-th"></i>
                    </button>
                    <button type="button" wire:click="$set('viewMode', 'list')"
                        class="btn btn-sm btn-outline-secondary {{ $viewMode === 'list' ? 'active' : '' }}"
                        title="{{ __('List View') }}">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== CARD VIEW ===================== --}}
        <div id="card-view"
            class="row g-4 {{ $viewMode === 'card' ? 'overflow-auto' : 'd-none' }}"
            style="scrollbar-width: thin; scrollbar-color: rgba(0,0,0,.2) transparent;">

            @forelse ($tickets as $ticket)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all" style="border-radius: 15px; overflow: hidden;">

                        {{-- شريط اللون العلوي --}}
                        <div style="height: 5px;" class="bg-{{ $ticket->status->color() }}"></div>

                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-light text-dark border shadow-sm">#{{ $ticket->id }}</span>
                                <span class="badge rounded-pill px-3 {{ $ticket->status->subColor() }}">
                                    {{ $ticket->status->label() }}
                                </span>
                            </div>

                            <h5 class="card-title fw-bold text-truncate mb-3" title="{{ $ticket->title }}">
                                {{ $ticket->title }}
                            </h5>

                            <div class="ticket-info mb-4">
                                <div class="d-flex align-items-center mb-2 text-muted small">
                                    <i class="fas fa-building me-2 opacity-50"></i>
                                    <strong>{{ __('Dept') }}:</strong>
                                    <span class="ms-1">{{ $ticket->category->name }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2 text-muted small">
                                    <i class="fas fa-user me-2 opacity-50"></i>
                                    <strong>{{ __('From') }}:</strong>
                                    <span class="ms-1">{{ ucFirst($ticket->user->name) }}</span>
                                </div>
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fas fa-calendar-alt me-2 opacity-50"></i>
                                    <strong>{{ __('Date') }}:</strong>
                                    <span class="ms-1">{{ $ticket->created_at->format('d M, Y') }}</span>
                                </div>
                            </div>

                            <div class="d-grid">
                                <a href="{{ route('it.tickets.show', $ticket->id) }}"
                                    class="btn btn-outline-primary btn-sm rounded-pill py-2 transition-all">
                                    <i class="fas fa-external-link-alt me-1"></i> {{ __('Show ticket') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                    <p>{{ __('No tickets found') }}</p>
                </div>
            @endforelse
        </div>

        {{-- ===================== LIST VIEW ===================== --}}
        <div id="list-view"
            class="{{ $viewMode === 'list' ? 'overflow-auto' : 'd-none' }}"
            style="height: calc(100vh - 200px);">

            <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Department') }}</th>
                            <th>{{ __('From') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark border">#{{ $ticket->id }}</span>
                                </td>
                                <td class="fw-bold" style="max-width: 220px;">
                                    <span class="text-truncate d-block" title="{{ $ticket->title }}">
                                        {{ $ticket->title }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    <i class="fas fa-building me-1 opacity-50"></i>
                                    {{ $ticket->category->name }}
                                </td>
                                <td class="text-muted small">
                                    <i class="fas fa-user me-1 opacity-50"></i>
                                    {{ ucFirst($ticket->user->name) }}
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 {{ $ticket->status->subColor() }}">
                                        {{ $ticket->status->label() }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    <i class="fas fa-calendar-alt me-1 opacity-50"></i>
                                    {{ $ticket->created_at->format('d M, Y') }}
                                </td>
                                <td>
                                    <a href="{{ route('it.tickets.show', $ticket->id) }}"
                                        class="btn btn-outline-primary btn-sm rounded-pill transition-all">
                                        <i class="fas fa-external-link-alt me-1"></i> {{ __('Show') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-25 d-block"></i>
                                    {{ __('No tickets found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===================== PAGINATION ===================== --}}
        <div class="mt-4 d-flex justify-content-end">
            {{ $tickets->links() }}
        </div>
    </div>
</div>

{{-- ===================== STYLES ===================== --}}
@section('css')
<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .bg-success-subtle {
        background-color: #d1e7dd !important;
    }

    .bg-warning-subtle {
        background-color: #fff3cd !important;
    }

    .bg-danger-subtle {
        background-color: #f8d7da !important;
    }

    .bg-secondary-subtle {
        background-color: #e2e3e5 !important;
    }

    /* Scrollbar */
    #card-view::-webkit-scrollbar,
    #list-view::-webkit-scrollbar {
        width: 6px;
        background: transparent;
    }

    #card-view::-webkit-scrollbar-thumb,
    #list-view::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, .2);
        border-radius: 10px;
    }

    /* Active toggle button */
    #btn-card.active,
    #btn-list.active {
        background-color: #0d6efd !important;
        color: #fff !important;
        border-color: #0d6efd !important;
    }
</style>
@endsection

{{-- ===================== SCRIPT ===================== --}}
<script>
    function showView(type) {
        const cardView = document.getElementById('card-view');
        const listView = document.getElementById('list-view');
        const btnCard  = document.getElementById('btn-card');
        const btnList  = document.getElementById('btn-list');

        if (!cardView || !listView) return;

        cardView.style.display = type === 'card' ? '' : 'none';
        listView.style.display = type === 'list' ? '' : 'none';
        btnCard.classList.toggle('active', type === 'card');
        btnList.classList.toggle('active', type === 'list');

        localStorage.setItem('tickets_view', type);
    }

    function restoreView() {
        const saved = localStorage.getItem('tickets_view') || 'card';
        showView(saved);
    }

    document.addEventListener('DOMContentLoaded', restoreView);
    document.addEventListener('livewire:updated', restoreView);
</script>
