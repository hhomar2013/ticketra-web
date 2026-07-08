@php
    use App\Core\Enum\AssetStatus as AssetStatusEnum;
@endphp
<div>
    <style>
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

        /* ✅ Fix dropdown clipping inside table */
        .table-wrap {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: visible;
            /* ✅ مش hidden */
        }

        .table-wrap table {
            border-radius: 12px;
            overflow: visible;
        }

        .table-wrap thead tr:first-child th:first-child {
            border-top-left-radius: 12px;
        }

        .table-wrap thead tr:first-child th:last-child {
            border-top-right-radius: 12px;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge .s-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-available {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-assigned {
            background: #fff3cd;
            color: #664d03;
        }

        .status-maintenance {
            background: #cfe2ff;
            color: #084298;
        }

        .status-retired {
            background: #e2e3e5;
            color: #41464b;
        }

        /* Dropdown Actions */
        .action-drop .dropdown-item {
            font-size: 13px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-radius: 8px;
            margin: 2px 4px;
        }

        .action-drop .dropdown-item:hover {
            background: #f3f4f6;
        }

        .action-drop .dropdown-menu {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
            padding: 6px;
            min-width: 180px;
            z-index: 9999;
            /* ✅ فوق كل حاجة */
        }

        /* Modal */
        .pro-modal .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
            overflow: hidden;
        }

        .pro-modal .modal-header {
            background: linear-gradient(135deg, #0d6efd, #0047c4);
            border: none;
            padding: 20px 24px;
        }

        .pro-modal .modal-header .modal-title {
            color: #fff;
            font-weight: 700;
        }

        .pro-modal .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .pro-modal .modal-body {
            padding: 24px;
        }

        .pro-modal .modal-footer {
            border-top: 1px solid #f3f4f6;
            padding: 16px 24px;
        }

        .m-lbl {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 6px;
            display: block;
        }

        .m-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            color: #111827;
            background: #fafafa;
            transition: all .2s;
            outline: none;
        }

        .m-input:focus {
            border-color: #0d6efd;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, .08);
        }

        .m-input.is-invalid {
            border-color: #ef4444;
            background: #fff8f8;
        }
    </style>
    {{-- ══════ Header ══════ --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h6 class="fw-bold mb-0">{{ __('Assets') }}</h6>
            <small class="text-muted">{{ __('Manage and track all your hardware assets') }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('hardware.assets.assets-assigned') }}"
                class="btn btn-success btn-sm rounded-pill px-4 fw-bold shadow-sm">
                <i class="fas fa-user me-1"></i> {{ __('Assigned Assets') }}
            </a>
            <button wire:click="createAsset" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                <i class="fas fa-plus me-1"></i> {{ __('New Asset') }}
            </button>
            {{-- زر تحميل Template --}}
            <button wire:click="downloadTemplate" class="btn btn-outline-primary btn-sm rounded-pill px-4 shadow-sm">
                <i class="fas fa-download me-1"></i> {{ __('Download Template') }}
            </button>
        </div>

    </div>

    {{-- ══════ Filters + Search ══════ --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div class="d-flex flex-wrap gap-2">
            <select wire:model.live="perPage" class="filter-btn" style="width: 70px; font-size: 12px;">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <button wire:click.prevent="sortBy('id')" class="filter-btn {{ $sortField === 'id' ? 'active' : '' }}">
                <i class="fa fa-hashtag" style="font-size: 11px;"></i> {{ __('ID') }}
            </button>
            <button wire:click.prevent="sortBy('purchase_date')"
                class="filter-btn {{ $sortField === 'purchase_date' ? 'active' : '' }}">
                <i class="fa fa-calendar" style="font-size: 11px;"></i> {{ __('Purchase Date') }}
            </button>
            <button wire:click.prevent="sortBy('warranty_expiry')"
                class="filter-btn {{ $sortField === 'warranty_expiry' ? 'active' : '' }}">
                <i class="fa fa-shield-halved" style="font-size: 11px;"></i> {{ __('Warranty') }}
            </button>
            <button wire:click="reverseSort" class="filter-btn">
                @if ($sortDirection === 'asc')
                    <i class="fa fa-arrow-up-wide-short text-primary"></i> {{ __('Ascending') }}
                @else
                    <i class="fa fa-arrow-down-wide-short text-primary"></i> {{ __('Descending') }}
                @endif
            </button>
        </div>
        <div class="search-wrap" style="min-width: 260px;">
            <i class="fa fa-search s-ico"></i>
            <input type="text" wire:model.live="search" class="search-input"
                placeholder="{{ __('Search by tag or serial number...') }}">
        </div>
    </div>

    {{-- ══════ Table ══════ --}}
    @if ($this->assets)
        <div class="table-wrap shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th class="ps-4 py-3 text-muted small" style="width: 55px;">#</th>
                        <th class="py-3 text-muted small">{{ __('Asset Tag') }}</th>
                        <th class="py-3 text-muted small">{{ __('Serial Number') }}</th>
                        <th class="py-3 text-muted small">{{ __('Status') }}</th>
                        <th class="py-3 text-muted small">{{ __('Branch') }}</th>
                        <th class="py-3 text-muted small">{{ __('Purchase Date') }}</th>
                        <th class="py-3 text-muted small">{{ __('Warranty') }}</th>
                        <th class="py-3 pe-4 text-muted small text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->assets as $key => $asset)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-muted border" style="font-size: 11px;">
                                    {{ $key + 1 }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold small font-monospace">{{ $asset->asset_tag }}</span>
                            </td>
                            <td>
                                <span class="text-muted small font-monospace">{{ $asset->serial_number }}</span>
                            </td>
                            <td>
                                {{-- @php
                                    $statusMap = [
                                        'available' => [
                                            'class' => 'status-available',
                                            'dot' => '#198754',
                                            'label' => __('Available'),
                                        ],
                                        'assigned' => [
                                            'class' => 'status-assigned',
                                            'dot' => '#ffc107',
                                            'label' => __('Assigned'),
                                        ],
                                        'maintenance' => [
                                            'class' => 'status-maintenance',
                                            'dot' => '#0d6efd',
                                            'label' => __('Maintenance'),
                                        ],
                                        'retired' => [
                                            'class' => 'status-retired',
                                            'dot' => '#6c757d',
                                            'label' => __('Retired'),
                                        ],
                                    ];
                                    $s = $statusMap[$asset->status] ?? [
                                        'class' => 'status-retired',
                                        'dot' => '#6c757d',
                                        'label' => ucfirst($asset->status),
                                    ];
                                @endphp --}}
                                <span class="status-badge {{ $asset->status->badge() }}">
                                    {{ $asset->status->label() }}
                                </span>
                            </td>
                            <td>
                                <span class="small">
                                    <i class="fa fa-building me-1 text-muted opacity-50"></i>
                                    {{ $asset->branch->name }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $asset->purchase_date ?? '—' }}</td>
                            <td>
                                @if ($asset->warranty_expiry)
                                    @php $expiry = \Carbon\Carbon::parse($asset->warranty_expiry); @endphp
                                    <span class="small {{ $expiry->isPast() ? 'text-danger' : 'text-success' }}">
                                        <i class="fa fa-shield-halved me-1"></i>
                                        {{ $asset->warranty_expiry }}
                                        @if ($expiry->isPast())
                                            <span class="badge ms-1"
                                                style="background:#f8d7da;color:#842029;font-size:10px;">
                                                {{ __('Expired') }}
                                            </span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            {{-- ✅ dropup للصفوف الأخيرة --}}
                            @if ($asset->status === AssetStatusEnum::Pending->value)
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger rounded-pill" style="width: 100px;">
                                        {{ __('Pending') }}
                                    </button>
                                </td>
                            @else
                                <td class="pe-4 text-end action-drop">
                                    <div class="dropdown {{ $loop->remaining < 2 ? 'dropup' : '' }}">
                                        <button class="btn btn-sm rounded-pill px-3"
                                            style="background: #f3f4f6; border: 1px solid #e5e7eb; color: #374151;"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if (!$asset->isAssigned())
                                                <li>
                                                    <button wire:click="assignToEmployee({{ $asset->id }})"
                                                        class="dropdown-item">
                                                        <i class="fa-solid fa-user-check text-warning"></i>
                                                        {{ __('Assign to Employee') }}
                                                    </button>
                                                </li>
                                            @else
                                                <li>
                                                    <a target="_blank" class="dropdown-item"
                                                        href="{{ route('assets-reports.index', $asset->id) }}">
                                                        <i class="fa-solid fa-file-invoice text-success"></i>
                                                        {{ __('Asset Receipt') }}
                                                    </a>

                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#returnAssetModal"
                                                        wire:click="openReturnModal({{ $asset->id }})">
                                                        <i class="fa-solid fa-undo text-danger"></i>
                                                        {{ __('Return Asset') }}
                                                    </button>
                                                </li>
                                            @endif
                                            <li>
                                                <hr class="dropdown-divider my-1">
                                            </li>
                                            <li>
                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#viewAssetModal"
                                                    wire:click="viewAsset({{ $asset->id }})">
                                                    <i class="fa-solid fa-laptop text-info"></i>
                                                    {{ __('View Specifications') }}
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item"
                                                    wire:click="historyAsset({{ $asset->id }})">
                                                    <i class="fa-solid fa-clock-rotate-left text-info"></i>
                                                    {{ __('History') }}
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item"
                                                    wire:click="editAsset({{ $asset->id }})">
                                                    <i class="fas fa-edit text-primary"></i>
                                                    {{ __('Edit') }}
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item"
                                                    onclick="confirmDelete({{ $asset->id }}, 'delete-asset')">
                                                    <i class="fas fa-trash text-danger"></i>
                                                    {{ __('Delete') }}
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $this->assets->links() }}
        </div>
        <br>
    @else
        <div class="text-center py-5 text-muted">
            <div style="font-size: 48px; margin-bottom: 12px;">💻</div>
            <h6 class="fw-bold text-dark mb-1">{{ __('No assets yet') }}</h6>
            <p class="small mb-3">{{ __('Add your first asset to start tracking') }}</p>
            <button wire:click="createAsset" class="btn btn-primary btn-sm rounded-pill px-4">
                <i class="fas fa-plus me-1"></i> {{ __('New Asset') }}
            </button>
        </div>
    @endif

    {{-- ══════ Return Modal ══════ --}}
    <div wire:ignore.self class="modal fade pro-modal" id="returnAssetModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-undo me-2"></i>
                        {{ __('Return Asset') }}
                        @if ($selectedAsset)
                            — <span style="font-family: monospace; font-size: 14px;">
                                {{ $selectedAsset->asset_tag }}
                            </span>
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form wire:submit="confirmReturn">
                    <div class="modal-body">
                        @if ($selectedAsset)
                            <div class="p-3 rounded-3 mb-4"
                                style="background: rgba(220,53,69,.06); border: 1px solid rgba(220,53,69,.15);">
                                <div class="small text-danger fw-bold mb-1">
                                    <i class="fa fa-circle-info me-1"></i>
                                    {{ __('Returning asset:') }}
                                </div>
                                <div class="fw-bold font-monospace">{{ $selectedAsset->serial_number }}</div>
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="m-lbl">
                                    {{ __('Condition on Return') }} <span class="text-danger">*</span>
                                </label>
                                {{-- <input type="text" wire:model.defer="condition_on_return"
                                    class="m-input @error('condition_on_return') is-invalid @enderror"
                                    placeholder="{{ __('e.g. Good, Damaged, Needs repair') }}"> --}}
                                <select wire:model.defer="condition_on_return"
                                    class="m-input @error('condition_on_return') is-invalid @enderror">
                                    <option value="">{{ __('Select condition') }} </option>
                                    @foreach ($returnStatuses as $status)
                                        <option value="{{ $status->value }}">
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('condition_on_return')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="m-lbl">
                                    {{ __('Return to Branch') }} <span class="text-danger">*</span>
                                </label>
                                <select wire:model.defer="branch_id"
                                    class="m-input @error('branch_id') is-invalid @enderror">
                                    <option value="">{{ __('Select Branch') }}</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="m-lbl">
                                    {{ __('Return Date') }} <span class="text-danger">*</span>
                                </label>
                                <input type="date" wire:model.defer="returned_at"
                                    class="m-input @error('returned_at') is-invalid @enderror">
                                @error('returned_at')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="m-lbl">{{ __('Notes') }}</label>
                                <input type="text" wire:model.defer="notes" class="m-input"
                                    placeholder="{{ __('Optional notes...') }}">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" class="btn rounded-pill px-4 fw-bold"
                            style="background: linear-gradient(135deg,#0d6efd,#0047c4); color:#fff; border:none;">
                            <span wire:loading.remove wire:target="confirmReturn">
                                <i class="fa fa-undo me-1"></i> {{ __('Confirm Return') }}
                            </span>
                            <span wire:loading wire:target="confirmReturn">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                                {{ __('Processing...') }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- New Asset --}}
    {{-- ══════ Asset Details View Modal ══════ --}}
    <div wire:ignore.self class="modal fade pro-modal" id="viewAssetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-laptop text-white me-2"></i>
                        {{ __('Asset Details') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4" style="background: #fdfdfd;">
                    @if ($selectedAsset)
                        {{-- ─── الـ Card الرئيسي ─── --}}
                        <div class="border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
                            {{-- الجزء العلوي: بيانات سريعة --}}
                            <div class="p-4 border-bottom d-flex align-items-center justify-content-between"
                                style="background: linear-gradient(to right, #fafafa, #fff);">
                                <div>
                                    <span
                                        class="badge bg-primary-subtle text-primary mb-2 px-3 py-1 rounded-pill fw-bold"
                                        style="font-size: 11px;">
                                        {{ $selectedAsset->asset_tag }}
                                    </span>
                                    <h4 class="fw-bold text-dark mb-1">
                                        {{ $selectedAsset->brand->name . ' ' . $selectedAsset->typeModel->name ?? 'Dell/ThinkPad' }}
                                    </h4>
                                    <p class="text-muted small mb-0 font-monospace"><i
                                            class="fa fa-barcode me-1"></i>S/N: {{ $selectedAsset->serial_number }}
                                    </p>
                                </div>

                                {{-- الحالة الديناميكية --}}
                                <div>

                                    <span class="status-badge {{ $selectedAsset->status->badge() }} px-3 py-2 fs-5">
                                        {{ ucfirst($selectedAsset->status->label()) }}
                                    </span>
                                </div>
                            </div>

                            {{-- شبكة المواصفات التقنية (Premium Grid View) --}}
                            <div class="p-4">
                                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-microchip text-primary"></i>
                                    {{ __('Hardware Specifications') }}
                                </h6>

                                <div class="row g-3">
                                    @forelse ($selectedAsset->specs as $spec)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                                <div class="text-muted small mb-1"><i
                                                        class="fa-solid fa-grip me-1"></i>
                                                    {{ $spec->attribute->name }}
                                                </div>
                                                <div class="fw-bold text-dark small">{{ $spec->value }}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-md-6 col-lg-4">
                                            <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                                <div class="text-muted small mb-1"><i
                                                        class="fa-solid fa-processor me-1"></i>
                                                    {{ __('No Specifications') }}</div>
                                            </div>
                                        </div>
                                    @endforelse


                                </div>

                                <hr class="my-4 opacity-50">

                                {{-- بيانات الشراء والضمان --}}
                                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-file-invoice-dollar text-primary"></i>
                                    {{ __('Purchase & Location Branch') }}
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="text-muted small"><i class="fa fa-building me-1"></i>
                                            {{ __('Branch') }}</div>
                                        <div class="fw-bold text-dark mt-1">{{ $selectedAsset->branch->name ?? '—' }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted small"><i class="fa fa-calendar me-1"></i>
                                            {{ __('Purchase Date') }}</div>
                                        <div class="fw-bold text-dark mt-1">{{ $selectedAsset->purchase_date ?? '—' }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted small"><i class="fa fa-shield-halved me-1"></i>
                                            {{ __('Warranty Expiry') }}</div>
                                        <div class="fw-bold text-dark mt-1">
                                            @if ($selectedAsset->warranty_expiry)
                                                {{ $selectedAsset->warranty_expiry }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if ($selectedAsset->notes)
                                    <div class="mt-4 p-3 border rounded-3 bg-light">
                                        <div class="text-muted small fw-bold mb-1">{{ __('Notes') }}</div>
                                        <p class="text-dark small mb-0">{{ $selectedAsset->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 text-muted small">{{ __('Loading asset configuration...') }}</p>
                        </div>
                    @endif
                </div>

                <div class="modal-footer bg-light-subtle border-top-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets/js/confirmDelete.js') }}"></script>
    <script>
        window.addEventListener('show-return-modal', () => {
            new bootstrap.Modal(document.getElementById('returnAssetModal')).show();
        });
        window.addEventListener('hide-return-modal', () => {
            bootstrap.Modal.getInstance(document.getElementById('returnAssetModal')) ? .hide();
        });
        window.addEventListener('show-view-modal', () => {
            var myModal = new bootstrap.Modal(document.getElementById('viewAssetModal'));
            myModal.show();
        });

        window.addEventListener('hide-view-modal', () => {
            bootstrap.Modal.getInstance(document.getElementById('viewAssetModal')) ? .hide();
        });
    </script>
@endpush
