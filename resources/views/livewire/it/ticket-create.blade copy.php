<div class="container-fluid py-4">
    <div class="row justify-content-center mb-5">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-plus-circle text-primary fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0">{{ __('New Ticket') }}</h4>
                            <p class="text-muted small mb-0">
                                {{ __('Enter your order details and we will get back to you ASAP') }}
                            </p>
                        </div>
                    </div>

                    @if (session()->has('message'))
                    <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
                    </div>
                    @endif

                    <form wire:submit.prevent="submit">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <label class="form-label fw-semibold text-secondary small text-uppercase">{{ __('Title') }}</label>
                                <input wire:model="title" type="text" class="form-control form-control-lg bg-light border-0 @error('title') is-invalid @enderror" style="border-radius: 12px;">
                                @error('title')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label fw-semibold text-secondary small text-uppercase">{{ __('Description') }}</label>
                                <textarea wire:model="description" class="form-control bg-light border-0 @error('description') is-invalid @enderror" rows="4" style="border-radius: 12px;"></textarea>
                                @error('description')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label fw-semibold text-secondary small text-uppercase mb-2">
                                    {{ __('Attach a photo (optional)') }} </label>
                                <div class="d-flex align-items-center">
                                    <label for="image" class="position-relative cursor-pointer">
                                        <div class="upload-preview border-dashed border-2 text-center" style="width: 100px; height: 100px; border-radius: 15px; line-height: 100px; border: 2px dashed #dee2e6;">
                                            @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}" class="rounded-3 w-100 h-100 object-fit-cover">
                                            @else
                                            <i class="fas fa-camera text-muted fs-3"></i>
                                            @endif
                                        </div>
                                        <input type="file" wire:model="image" id="image" hidden />
                                    </label>
                                    <div class="ms-3 text-muted small">
                                        {{ __('Click on the box to upload a clarifying photo') }}
                                    </div>
                                </div>
                                @error('image')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-12 pt-2">
                                <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm rounded-pill w-100 w-md-auto">
                                    <i class="fas fa-paper-plane me-2"></i> {{ __('Send') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5 opacity-25">

    <div class="row g-4" wire:poll>
        <div class="col-12">
            <h4 class="fw-bold mb-4"><i class="fas fa-list-ul me-2"></i> {{ __('Latest tickets') }}</h4>
        </div>

        @foreach ($tickets as $ticket)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-up transition-all" style="border-radius: 18px; overflow: hidden;">
                <div style="height: 6px;" class="
                        @if ($ticket->status == 'new') bg-secondary
                        @elseif($ticket->status == 'open') bg-success
                        @elseif($ticket->status == 'in_progress') bg-warning
                        @elseif($ticket->status == 'closed') bg-danger @endif">
                </div>

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-light text-muted border">#{{ $loop->iteration }}</span>
                        <span class="badge rounded-pill px-3 py-2
                                @if ($ticket->status == 'new') bg-secondary-subtle text-secondary
                                @elseif($ticket->status == 'open') bg-success-subtle text-success
                                @elseif($ticket->status == 'in_progress') bg-warning-subtle text-warning
                                @elseif($ticket->status == 'closed') bg-danger-subtle text-danger @endif">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </div>

                    <h5 class="fw-bold text-dark text-truncate mb-3" title="{{ $ticket->title }}">
                        {{ $ticket->title }}
                    </h5>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2 small">
                            <i class="fas fa-layer-group text-muted me-2" style="width: 20px;"></i>
                            <span class="text-muted me-1">{{ __('Department') }}:</span>
                            <span class="fw-semibold text-dark">{{ $ticket->category->name }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2 small">
                            <i class="fas fa-clock text-muted me-2" style="width: 20px;"></i>
                            <span class="text-muted me-1">{{ __('At') }}:</span>
                            <span class="text-dark">{{ $ticket->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('user.tickets.show', $ticket->id) }}" class="btn btn-light border flex-grow-1 rounded-pill btn-sm py-2 fw-bold">
                            <i class="fas fa-eye me-1 text-primary"></i> {{ __('Show') }}</a>

                        @if ($ticket->status == 'new')
                        <button wire:click.prevent="deleteTicket({{ $ticket->id }})" class="btn btn-outline-danger rounded-circle btn-sm shadow-sm" title="إلغاء التذكرة" style="width: 36px; height: 36px;">
                            <i class="fas fa-times"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@section('css')
<style>
    .hover-up {
        transition: all 0.3s ease;
    }

    .hover-up:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    /* Subtle Badges colors */
    .bg-success-subtle {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .bg-warning-subtle {
        background-color: #fff3cd;
        color: #664d03;
    }

    .bg-danger-subtle {
        background-color: #f8d7da;
        color: #842029;
    }

    .bg-secondary-subtle {
        background-color: #e2e3e5;
        color: #41464b;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .border-dashed {
        border-style: dashed !important;
    }

</style>
@endsection
