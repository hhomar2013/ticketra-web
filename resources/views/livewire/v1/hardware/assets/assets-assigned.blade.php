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
            <h6 class="fw-bold mb-0">{{ __('Assigned Assets') }}</h6>
            <small class="text-muted">{{ __('Manage and track all assigned hardware assets') }}</small>
        </div>
        <div class="d-flex gap-2">
            <button wire:click="createAsset" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                <i class="fas fa-plus me-1"></i> {{ __('New Asset') }}
            </button>
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
    @if ($this->assets && $this->assets->count() > 0)
        <div class="table-wrap shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th class="ps-4 py-3 text-muted small" style="width: 55px;">#</th>
                        <th class="py-3 text-muted small">{{ __('Employee Name') }}</th>
                        <th class="py-3 text-muted small">{{ __('Asset Count') }}</th>
                        <th class="py-3 text-muted small text-center"><i class="fas fa-cog"></i> {{ __('Actions') }}
                        </th>
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
                                <div class="d-flex align-items-center">
                                    <div style=" width: 32px;
                                    height: 32px;
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 13px;
                                    font-weight: 600;"
                                        class=" bg-success bg-opacity-50  text-dark me-2">
                                        {{ strtoupper(substr($asset->name, 0, 2)) }}
                                    </div>
                                    <span class="fw-bold small font-monospace">{{ $asset->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small font-monospace">{{ $asset->assets->count() }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-info btn-sm rounded-pill px-4 shadow-sm"
                                        data-bs-toggle="modal" data-bs-target="#viewAssetModal"
                                        wire:click="viewAsset({{ $asset->id }})">
                                        <i class="fa-solid fa-laptop text-white me-2"></i>
                                        {{ __('View Assets') }}
                                    </button>
                                </div>
                            </td>

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
            <h6 class="fw-bold text-dark mb-1">{{ __('No assigned assets yet') }}</h6>
            <p class="small mb-3">{{ __('Assign an asset to an employee to start tracking') }}</p>
        </div>
    @endif

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
                    @if ($selectedAsset && $selectedAsset->count() > 0)
                        {{-- ─── الـ Card الرئيسي ─── --}}
                        @forelse ($selectedAsset as $key => $asset)
                            <div class="border rounded-4 bg-white shadow-sm overflow-hidden mb-4">

                                <div class="p-4 border-bottom d-flex align-items-center justify-content-between"
                                    style="background: linear-gradient(to right, #fafafa, #fff);">
                                    <div>
                                        <span
                                            class="badge bg-primary-subtle text-primary mb-2 px-3 py-1 rounded-pill fw-bold"
                                            style="font-size: 11px;">
                                            {{ $asset->asset->asset_tag }}
                                        </span>
                                        <h4 class="fw-bold text-dark mb-1 {{ $asset->asset->status->badge() }}">
                                            {{ $asset->asset->status->label() }}
                                        </h4>
                                        <p class="text-muted small mb-0 font-monospace"><i
                                                class="fa fa-barcode me-1"></i>S/N:
                                        </p>
                                    </div>
                                </div>

                                {{-- شبكة المواصفات التقنية (Premium Grid View) --}}
                                <div class="p-4">
                                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-microchip text-primary"></i>
                                        {{ __('Hardware Specifications') }}
                                    </h6>

                                    <div class="row g-3">
                                        {{-- @forelse ($selectedAsset->specs as $spec)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                                <div class="text-muted small mb-1"><i class="fa-solid fa-grip me-1"></i>
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
                                    @endforelse --}}


                                    </div>

                                    <hr class="my-4 opacity-50">


                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2 text-muted small">{{ __('Loading asset configuration...') }}</p>
                            </div>
                        @endforelse
                    @else
                        <div class="text-center py-4">
                            <i class="fa-solid fa-laptop text-muted" style="font-size: 48px;"></i>
                            <p class="mt-2 text-muted small">{{ __('No Asset Found') }}</p>
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
        window.addEventListener('show-view-modal', () => {
            var myModal = new bootstrap.Modal(document.getElementById('viewAssetModal'));
            myModal.show();
        })

        window.addEventListener('hide-view-modal', () => {
            bootstrap.Modal.getInstance(document.getElementById('viewAssetModal')) ? .hide();
        })
    </script>
@endpush
