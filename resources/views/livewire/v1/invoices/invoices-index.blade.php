<div>
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

            .stat-card .icon-box {
                width: 48px;
                height: 48px;
                border-radius: 13px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
            }

            .stat-card .stripe {
                height: 4px;
                width: 100%;
            }

            .filter-btn {
                border: 1.5px solid #e5e7eb;
                border-radius: 10px;
                padding: 7px 14px;
                font-size: 12px;
                font-weight: 600;
                color: #6b7280;
                background: #fff;
                cursor: pointer;
                transition: all .2s;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .filter-btn:hover {
                border-color: #0d6efd;
                color: #0d6efd;
                background: rgba(13, 110, 253, .04);
            }

            .filter-btn.active {
                background: linear-gradient(135deg, #0d6efd, #0047c4);
                border-color: transparent;
                color: #fff;
                box-shadow: 0 4px 12px rgba(13, 110, 253, .25);
            }

            .search-wrap {
                position: relative;
            }

            .search-wrap .s-ico {
                position: absolute;
                left: 13px;
                top: 50%;
                transform: translateY(-50%);
                color: #9ca3af;
                font-size: 13px;
                pointer-events: none;
            }

            .search-input {
                width: 100%;
                border: 1.5px solid #e5e7eb;
                border-radius: 12px;
                padding: 10px 14px 10px 38px;
                font-size: 14px;
                color: #111827;
                background: #fafafa;
                transition: all .2s;
                outline: none;
            }

            .search-input:focus {
                border-color: #0d6efd;
                background: #fff;
                box-shadow: 0 0 0 4px rgba(13, 110, 253, .08);
            }

            .table-wrap {
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                overflow: visible;
            }

            .action-drop .dropdown-menu {
                border: 1px solid #e5e7eb;
                border-radius: 14px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
                padding: 6px;
                min-width: 170px;
                z-index: 9999;
            }

            .action-drop .dropdown-item {
                font-size: 13px;
                padding: 8px 14px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .action-drop .dropdown-item:hover {
                background: #f3f4f6;
            }
        </style>
    @endpush

    {{-- ══════ Header ══════ --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h6 class="fw-bold mb-0">{{ __('Purchase Invoices') }}</h6>
            <small class="text-muted">{{ __('Manage supplier invoices and batches') }}</small>
        </div>
        <a href="{{ route('invoices.create') }}" wire:navigate
            class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
            <i class="fas fa-plus me-1"></i> {{ __('New Invoice') }}
        </a>
    </div>

    {{-- ══════ Stats ══════ --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="stripe bg-primary"></div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-primary bg-opacity-10">
                            <i class="fa fa-file-invoice text-primary"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                    <p class="text-muted small mb-0 mt-1">{{ __('Total Invoices') }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="stripe bg-warning"></div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-warning bg-opacity-10">
                            <i class="fa fa-clock text-warning"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['pending'] }}</h3>
                    <p class="text-muted small mb-0 mt-1">{{ __('Pending') }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="stripe bg-success"></div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-success bg-opacity-10">
                            <i class="fa fa-check-circle text-success"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['paid'] }}</h3>
                    <p class="text-muted small mb-0 mt-1">{{ __('Paid') }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="stripe bg-info"></div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-info bg-opacity-10">
                            <i class="fa fa-dollar-sign text-info"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-0">{{ number_format($stats['total_amount'], 2) }}</h3>
                    <p class="text-muted small mb-0 mt-1">{{ __('Total Amount') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════ Filters ══════ --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div class="d-flex gap-2">
            <button wire:click="$set('statusFilter','')" class="filter-btn {{ $statusFilter === '' ? 'active' : '' }}">
                <i class="fa fa-list" style="font-size:11px;"></i> {{ __('All') }}
            </button>
            <button wire:click="$set('statusFilter','pending')"
                class="filter-btn {{ $statusFilter === 'pending' ? 'active' : '' }}">
                <i class="fa fa-clock" style="font-size:11px;"></i> {{ __('Pending') }}
            </button>
            <button wire:click="$set('statusFilter','paid')"
                class="filter-btn {{ $statusFilter === 'paid' ? 'active' : '' }}">
                <i class="fa fa-check-circle" style="font-size:11px;"></i> {{ __('Paid') }}
            </button>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <select wire:model.change="perPage" class="filter-btn" style="border-radius:10px;">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <div class="search-wrap" style="min-width:240px;">
                <i class="fa fa-search s-ico"></i>
                <input type="text" wire:model.live.debounce.400ms="search" class="search-input"
                    placeholder="{{ __('Search by invoice # or supplier...') }}">
            </div>
        </div>
    </div>

    {{-- ══════ Table ══════ --}}
    @if ($invoices->count())
        <div class="table-wrap shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f9fafb;">
                    <tr>
                        <th class="ps-4 py-3 text-muted small" style="width:55px;">#</th>
                        <th class="py-3 text-muted small">{{ __('Invoice #') }}</th>
                        <th class="py-3 text-muted small">{{ __('Supplier') }}</th>
                        <th class="py-3 text-muted small">{{ __('Date') }}</th>
                        <th class="py-3 text-muted small">{{ __('Amount') }}</th>
                        <th class="py-3 text-muted small">{{ __('Batches') }}</th>
                        <th class="py-3 text-muted small">{{ __('Status') }}</th>
                        <th class="py-3 pe-4 text-muted small text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $key => $invoice)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-muted border" style="font-size:11px;">
                                    {{ $invoices->firstItem() + $key }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold small font-monospace">{{ $invoice->invoice_number }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div
                                        style="width:32px;height:32px;border-radius:9px;background:rgba(13,110,253,.1);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#0d6efd;">
                                        {{ strtoupper(substr($invoice->supplier->name, 0, 2)) }}
                                    </div>
                                    <span class="fw-bold small">{{ $invoice->supplier->name }}</span>
                                </div>
                            </td>
                            <td class="text-muted small">
                                <i class="fa fa-calendar me-1 opacity-50"></i>
                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}
                            </td>
                            <td>
                                <span class="fw-bold small">
                                    {{ number_format($invoice->total_amount, 2) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('invoices.batches', $invoice->id) }}"
                                    style="background:rgba(13,110,253,.08);color:#0d6efd;border:1px solid rgba(13,110,253,.15);border-radius:20px;padding:4px 12px;font-size:12px;font-weight:600;text-decoration:none;">
                                    <i class="fa fa-boxes-stacked me-1" style="font-size:11px;"></i>
                                    {{ $invoice->batches->count() }} {{ __('batches') }}
                                </a>
                            </td>
                            <td>
                                @if ($invoice->status === 'paid')
                                    <span
                                        style="background:#d1e7dd;color:#0f5132;border-radius:20px;padding:4px 12px;font-size:11px;font-weight:700;">
                                        <span
                                            style="width:6px;height:6px;border-radius:50%;background:#198754;display:inline-block;margin-right:4px;"></span>
                                        {{ __('Paid') }}
                                    </span>
                                @else
                                    <span
                                        style="background:#fff3cd;color:#664d03;border-radius:20px;padding:4px 12px;font-size:11px;font-weight:700;">
                                        <span
                                            style="width:6px;height:6px;border-radius:50%;background:#ffc107;display:inline-block;margin-right:4px;"></span>
                                        {{ __('Pending') }}
                                    </span>
                                @endif
                            </td>
                            <td class="pe-4 text-end action-drop">
                                <div class="dropdown {{ $loop->remaining < 2 ? 'dropup' : '' }}">
                                    <button class="btn btn-sm rounded-pill px-3"
                                        style="background:#f3f4f6;border:1px solid #e5e7eb;color:#374151;"
                                        data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('invoices.edit', $invoice->id) }}">
                                                <i class="fas fa-edit text-primary"></i> {{ __('Edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('invoices.batches', $invoice->id) }}">
                                                <i class="fa fa-boxes-stacked text-info"></i> {{ __('Batches') }}
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider my-1">
                                        </li>
                                        @if ($invoice->status === 'pending')
                                            <li>
                                                <button class="dropdown-item"
                                                    wire:click="updateStatus({{ $invoice->id }}, 'paid')"
                                                    wire:confirm="{{ __('Mark as paid?') }}">
                                                    <i class="fa fa-check-circle text-success"></i>
                                                    {{ __('Mark as Paid') }}
                                                </button>
                                            </li>
                                        @else
                                            <li>
                                                <button class="dropdown-item"
                                                    wire:click="updateStatus({{ $invoice->id }}, 'pending')">
                                                    <i class="fa fa-clock text-warning"></i>
                                                    {{ __('Mark as Pending') }}
                                                </button>
                                            </li>
                                        @endif
                                        <li>
                                            <hr class="dropdown-divider my-1">
                                        </li>
                                        <li>
                                            <button class="dropdown-item"
                                                onclick="confirmDelete({{ $invoice->id }}, 'delete-invoice')">
                                                <i class="fas fa-trash text-danger"></i> {{ __('Delete') }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 d-flex justify-content-end">
            {{ $invoices->links() }}
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <div style="font-size:48px;margin-bottom:12px;">🧾</div>
            <h6 class="fw-bold text-dark mb-1">{{ __('No invoices yet') }}</h6>
            <p class="small mb-3">{{ __('Create your first purchase invoice') }}</p>
            <a href="{{ route('invoices.create') }}" wire:navigate class="btn btn-primary btn-sm rounded-pill px-4">
                <i class="fas fa-plus me-1"></i> {{ __('New Invoice') }}
            </a>
        </div>
    @endif

</div>

@push('js')
    <script src="{{ asset('assets/js/confirmDelete.js') }}"></script>
@endpush
