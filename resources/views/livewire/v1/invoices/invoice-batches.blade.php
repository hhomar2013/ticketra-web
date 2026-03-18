<div>
    <style>
        /* ── Page Header ── */
        .inv-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0047c4 100%);
            border-radius: 20px;
            padding: 24px 28px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .inv-header::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .07);
        }

        .inv-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            right: 80px;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
        }

        /* ── Batch Card ── */
        .batch-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .batch-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
        }

        .batch-card-body {
            padding: 20px;
        }

        /* ── Asset Item ── */
        .asset-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f9fafb;
        }

        .asset-item:last-child {
            border-bottom: none;
        }

        .asset-tag {
            font-family: monospace;
            font-size: 13px;
            font-weight: 700;
            color: #111827;
        }

        .asset-serial {
            font-family: monospace;
            font-size: 11px;
            color: #9ca3af;
        }

        /* ── Modal / Slide Panel ── */
        .slide-panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .slide-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f3f4f6;
        }

        /* ── Form Fields ── */
        .f-lbl {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .7px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 7px;
            display: block;
        }

        .f-wrap {
            position: relative;
        }

        .f-wrap .f-ico {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #d1d5db;
            font-size: 13px;
            pointer-events: none;
            transition: color .2s;
        }

        .f-wrap:focus-within .f-ico {
            color: #0d6efd;
        }

        .f-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px 14px 10px 40px;
            font-size: 14px;
            color: #111827;
            background: #fafafa;
            transition: all .2s;
            outline: none;
        }

        .f-input::placeholder {
            color: #d1d5db;
        }

        .f-input:focus {
            border-color: #0d6efd;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, .09);
        }

        .f-input.is-invalid {
            border-color: #ef4444;
            background: #fff8f8;
        }

        select.f-input {
            cursor: pointer;
        }

        .f-err {
            font-size: 11px;
            color: #ef4444;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .section-divider {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 4px 0 16px;
        }

        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f3f4f6;
        }

        .btn-primary-sm {
            background: linear-gradient(135deg, #0d6efd, #0047c4);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 20px;
            cursor: pointer;
            transition: transform .15s, box-shadow .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary-sm:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, .3);
        }

        .btn-edit-sm {
            background: rgba(13, 110, 253, .08);
            color: #0d6efd;
            border: 1px solid rgba(13, 110, 253, .15);
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-del-sm {
            background: rgba(220, 53, 69, .08);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, .15);
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-add-asset {
            background: rgba(25, 135, 84, .08);
            color: #198754;
            border: 1px solid rgba(25, 135, 84, .15);
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-add-asset:hover {
            background: rgba(25, 135, 84, .15);
        }

    </style>


    {{-- ══════ Invoice Header ══════ --}}
    <div class="inv-header shadow-sm">
        <div class="d-flex align-items-center justify-content-between" style="position:relative;z-index:1;">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:22px;">🧾</div>
                <div>
                    <p class="text-white text-opacity-75 mb-0 small">{{ __('Invoice') }} — {{ $invoice->supplier->name }}</p>
                    <h5 class="text-white fw-bold mb-0 font-monospace">{{ $invoice->invoice_number }}</h5>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2" style="position:relative;z-index:1;">
                <div class="text-end me-3">
                    <div class="text-white text-opacity-75 small">{{ __('Total Amount') }}</div>
                    <div class="text-white fw-bold" style="font-size:18px;">{{ number_format($invoice->total_amount, 2) }}</div>
                </div>
                <span style="background:{{ $invoice->status === 'paid' ? 'rgba(25,135,84,.3)' : 'rgba(255,193,7,.3)' }};color:#fff;border-radius:20px;padding:5px 14px;font-size:12px;font-weight:700;">
                    {{ $invoice->status === 'paid' ? '✅ '.__('Paid') : '⏳ '.__('Pending') }}
                </span>
                <a href="{{ route('invoices.index') }}" wire:navigate class="btn btn-sm rounded-pill px-3 fw-bold" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.25);font-size:13px;">
                    <i class="fa fa-arrow-left me-1"></i> {{ __('Back') }}
                </a>
            </div>
        </div>

        {{-- Invoice Meta --}}
        <div class="d-flex gap-4 mt-3" style="position:relative;z-index:1;">
            <div>
                <div style="color:rgba(255,255,255,.5);font-size:10px;text-transform:uppercase;letter-spacing:.5px;">{{ __('Date') }}</div>
                <div style="color:#fff;font-size:13px;">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</div>
            </div>
            <div>
                <div style="color:rgba(255,255,255,.5);font-size:10px;text-transform:uppercase;letter-spacing:.5px;">{{ __('Batches') }}</div>
                <div style="color:#fff;font-size:13px;">{{ $invoice->batches->count() }}</div>
            </div>
            <div>
                <div style="color:rgba(255,255,255,.5);font-size:10px;text-transform:uppercase;letter-spacing:.5px;">{{ __('Total Assets') }}</div>
                <div style="color:#fff;font-size:13px;">{{ $invoice->batches->sum(fn($b) => $b->assets->count()) }}</div>
            </div>
        </div>
    </div>

    {{-- ══════ Add Batch Button ══════ --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h6 class="fw-bold mb-0">{{ __('Batches') }}</h6>
            <small class="text-muted">{{ __('Manage batches linked to this invoice') }}</small>
        </div>
        <button wire:click="$toggle('showBatchForm')" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
            <i class="fas fa-plus me-1"></i> {{ __('Add Batch') }}
        </button>
    </div>

    {{-- ══════ Add Batch Form ══════ --}}
    @if($showBatchForm)
    <div class="slide-panel shadow-sm mb-4">
        <div class="slide-panel-header">
            <div>
                <h6 class="fw-bold mb-0">📦 {{ __('New Batch') }}</h6>
                <small class="text-muted">{{ __('Add a new batch to this invoice') }}</small>
            </div>
            <button wire:click="$set('showBatchForm', false)" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                {{ __('Cancel') }}
            </button>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="f-lbl">{{ __('Batch Number') }} <span class="text-danger">*</span></label>
                <div class="f-wrap">
                    <i class="fa fa-boxes-stacked f-ico"></i>
                    <input type="text" wire:model="batch_number" class="f-input @error('batch_number') is-invalid @enderror" placeholder="BATCH-2025-001">
                </div>
                @error('batch_number') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="f-lbl">{{ __('Received Date') }} <span class="text-danger">*</span></label>
                <div class="f-wrap">
                    <i class="fa fa-calendar f-ico"></i>
                    <input type="date" wire:model="received_date" class="f-input @error('received_date') is-invalid @enderror">
                </div>
                @error('received_date') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="f-lbl">{{ __('Status') }}</label>
                <div class="f-wrap">
                    <i class="fa fa-circle-dot f-ico"></i>
                    <select wire:model="batch_status" class="f-input">
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="stocked">{{ __('Stocked') }}</option>
                        <option value="partial">{{ __('Partial') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button wire:click="saveBatch" class="btn-primary-sm w-100 justify-content-center">
                    <span wire:loading.remove wire:target="saveBatch">
                        <i class="fa fa-plus"></i> {{ __('Add') }}
                    </span>
                    <span wire:loading wire:target="saveBatch">
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>
            <div class="col-12">
                <label class="f-lbl">{{ __('Notes') }}</label>
                <div class="f-wrap">
                    <i class="fa fa-align-left f-ico"></i>
                    <input type="text" wire:model="batch_notes" class="f-input" placeholder="{{ __('Optional...') }}">
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ══════ Add Asset Form ══════ --}}
    @if($showAssetForm)
    <div class="slide-panel shadow-sm mb-4" style="border: 1.5px solid rgba(25,135,84,.2); background: rgba(25,135,84,.02);">
        <div class="slide-panel-header">
            <div>
                <h6 class="fw-bold mb-0">💻 {{ __('Add Asset to Batch') }}</h6>
                <small class="text-muted">
                    {{ __('Batch') }}: <strong>{{ $invoice->batches->firstWhere('id', $selectedBatchId)?->batch_number }}</strong>
                </small>
            </div>
            <button wire:click="$set('showAssetForm', false)" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                {{ __('Cancel') }}
            </button>
        </div>
        <div class="row g-3">

            <div class="col-12">
                <div class="section-divider">{{ __('Identity') }}</div>
            </div>

            {{-- <div class="col-md-4">
                <label class="f-lbl">{{ __('Asset Tag') }} <span class="text-danger">*</span></label>
            <div class="f-wrap">
                <i class="fa fa-tag f-ico"></i>
                <input type="text" wire:model="asset_tag" class="f-input @error('asset_tag') is-invalid @enderror" placeholder="AST-0001">
            </div>
            @error('asset_tag') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
        </div> --}}
        <div class="col-md-4">
            <label class="f-lbl">{{ __('Serial Number') }} <span class="text-danger">*</span></label>
            <div class="f-wrap">
                <i class="fa fa-barcode f-ico"></i>
                <input type="text" wire:model="serial_number" class="f-input @error('serial_number') is-invalid @enderror" placeholder="SN-XXXXXXXXXX">
            </div>
            @error('serial_number') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label class="f-lbl">{{ __('Purchase Date') }}</label>
            <div class="f-wrap">
                <i class="fa fa-calendar f-ico"></i>
                <input type="date" wire:model="purchase_date" class="f-input">
            </div>
        </div>

        <div class="col-12">
            <div class="section-divider">{{ __('Classification') }}</div>
        </div>

        <div class="col-md-3">
            <label class="f-lbl">{{ __('Category') }} <span class="text-danger">*</span></label>
            <div class="f-wrap">
                <i class="fa fa-layer-group f-ico"></i>
                <select wire:model="category_id" class="f-input @error('category_id') is-invalid @enderror">
                    <option value="">{{ __('Select Category') }}</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('category_id') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
        </div>
        <div class="col-md-3">
            <label class="f-lbl">{{ __('Branch') }} <span class="text-danger">*</span></label>
            <div class="f-wrap">
                <i class="fa fa-building f-ico"></i>
                <select wire:model="branch_id" class="f-input @error('branch_id') is-invalid @enderror">
                    <option value="">{{ __('Select Branch') }}</option>
                    @foreach($branches as $br)
                    <option value="{{ $br->id }}">{{ $br->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('branch_id') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
        </div>
        <div class="col-md-3">
            <label class="f-lbl">{{ __('Brand') }}</label>
            <div class="f-wrap">
                <i class="fa fa-bookmark f-ico"></i>
                <select wire:model.live="brand_id" class="f-input">
                    <option value="">{{ __('Select Brand') }}</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <label class="f-lbl">{{ __('Type Model') }}</label>
            <div class="f-wrap">
                <i class="fa fa-bookmark f-ico"></i>
                <select wire:model="type_model_id" class="f-input">
                    <option value="">{{ __('Select type model') }}</option>
                    @foreach($type_model as $types)
                    <option value="{{ $types->id }}">{{ $types->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <label class="f-lbl">{{ __('Warranty Expiry') }}</label>
            <div class="f-wrap">
                <i class="fa fa-shield-halved f-ico"></i>
                <input type="date" wire:model="warranty_expiry" class="f-input">
            </div>
        </div>

        <div class="col-12 mt-2">
            <button wire:click="saveAsset" class="btn-primary-sm">
                <span wire:loading.remove wire:target="saveAsset">
                    <i class="fa fa-plus"></i> {{ __('Add Asset to Batch') }}
                </span>
                <span wire:loading wire:target="saveAsset">
                    <span class="spinner-border spinner-border-sm"></span>
                    {{ __('Saving...') }}
                </span>
            </button>
        </div>
    </div>
</div>
@endif

{{-- ══════ Batches List ══════ --}}
@forelse($invoice->batches as $batch)
<div class="batch-card shadow-sm">

    {{-- Batch Header --}}
    <div class="batch-card-header">
        <div class="d-flex align-items-center gap-3">
            <div style="width:38px;height:38px;border-radius:11px;background:rgba(13,110,253,.1);display:flex;align-items:center;justify-content:center;font-size:16px;">📦</div>
            <div>
                <div class="fw-bold" style="font-family:monospace;font-size:14px;">{{ $batch->batch_number }}</div>
                <div class="text-muted" style="font-size:11px;">
                    <i class="fa fa-calendar me-1"></i>
                    {{ \Carbon\Carbon::parse($batch->received_date)->format('d M Y') }}
                    @if($batch->notes)
                    <span class="ms-2">• {{ $batch->notes }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            {{-- Assets Count --}}
            <span style="background:rgba(13,110,253,.08);color:#0d6efd;border-radius:20px;padding:4px 12px;font-size:12px;font-weight:600;">
                <i class="fa fa-laptop me-1" style="font-size:11px;"></i>
                {{ $batch->assets->count() }} {{ __('assets') }}
            </span>

            {{-- Status Badge --}}
            @php
            $batchStatusMap = [
            'pending' => ['bg' => '#fff3cd', 'color' => '#664d03', 'dot' => '#ffc107', 'label' => __('Pending')],
            'stocked' => ['bg' => '#d1e7dd', 'color' => '#0f5132', 'dot' => '#198754', 'label' => __('Stocked')],
            'partial' => ['bg' => '#cfe2ff', 'color' => '#084298', 'dot' => '#0d6efd', 'label' => __('Partial')],
            ];
            $bs = $batchStatusMap[$batch->status] ?? $batchStatusMap['pending'];
            @endphp
            <span style="background:{{ $bs['bg'] }};color:{{ $bs['color'] }};border-radius:20px;padding:4px 12px;font-size:11px;font-weight:700;">
                <span style="width:6px;height:6px;border-radius:50%;background:{{ $bs['dot'] }};display:inline-block;margin-right:4px;"></span>
                {{ $bs['label'] }}
            </span>

            {{-- Change Status --}}
            <div class="dropdown">
                <button class="btn btn-sm rounded-pill px-3" style="background:#f3f4f6;border:1px solid #e5e7eb;color:#374151;font-size:12px;" data-bs-toggle="dropdown">
                    <i class="fa fa-chevron-down" style="font-size:10px;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="border-radius:12px;border:1px solid #e5e7eb;box-shadow:0 8px 24px rgba(0,0,0,.1);padding:6px;min-width:150px;">
                    <li>
                        <button class="dropdown-item" style="font-size:13px;border-radius:8px;padding:8px 12px;" wire:click="updateBatchStatus({{ $batch->id }}, 'pending')">
                            <span style="width:8px;height:8px;border-radius:50%;background:#ffc107;display:inline-block;margin-right:6px;"></span>
                            {{ __('Pending') }}
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" style="font-size:13px;border-radius:8px;padding:8px 12px;" wire:click="updateBatchStatus({{ $batch->id }}, 'stocked')">
                            <span style="width:8px;height:8px;border-radius:50%;background:#198754;display:inline-block;margin-right:6px;"></span>
                            {{ __('Stocked') }}
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" style="font-size:13px;border-radius:8px;padding:8px 12px;" wire:click="updateBatchStatus({{ $batch->id }}, 'partial')">
                            <span style="width:8px;height:8px;border-radius:50%;background:#0d6efd;display:inline-block;margin-right:6px;"></span>
                            {{ __('Partial') }}
                        </button>
                    </li>
                    <li>
                        <hr style="margin:4px 0;border-color:#f3f4f6;">
                    </li>
                    <li>
                        <button class="dropdown-item" style="font-size:13px;border-radius:8px;padding:8px 12px;color:#dc3545;" wire:click="deleteBatch({{ $batch->id }})" wire:confirm="{{ __('Delete this batch?') }}">
                            <i class="fa fa-trash me-1"></i> {{ __('Delete') }}
                        </button>
                    </li>
                </ul>
            </div>

            {{-- Add Asset --}}
            <button wire:click="openAssetForm({{ $batch->id }})" class="btn-add-asset">
                <i class="fa fa-plus me-1"></i> {{ __('Add Asset') }}
            </button>
        </div>
    </div>

    {{-- Assets in Batch --}}
    <div class="batch-card-body">
        @if($batch->assets->count())
        <div class="border rounded-3 overflow-hidden">
            <table class="table table-hover align-middle mb-0" style="font-size:13px;">
                <thead style="background:#f9fafb;">
                    <tr>
                        <th class="ps-3 py-2 text-muted small">{{ __('Asset Tag') }}</th>
                        <th class="py-2 text-muted small">{{ __('Serial Number') }}</th>
                        <th class="py-2 text-muted small">{{ __('Category') }}</th>
                        <th class="py-2 text-muted small">{{ __('Branch') }}</th>
                        <th class="py-2 text-muted small">{{ __('Status') }}</th>
                        <th class="py-2 pe-3 text-end text-muted small"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($batch->assets as $asset)
                    <tr>
                        <td class="ps-3">
                            <span class="fw-bold font-monospace">{{ $asset->asset_tag }}</span>
                        </td>
                        <td class="text-muted font-monospace" style="font-size:12px;">{{ $asset->serial_number }}</td>
                        <td class="text-muted small">{{ $asset->category->name ?? '—' }}</td>
                        <td class="text-muted small">{{ $asset->branch->name ?? '—' }}</td>
                        <td>
                            <span style="background:rgba(25,135,84,.1);color:#198754;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:700;">
                                {{ ucfirst($asset->status) }}
                            </span>
                        </td>
                        <td class="pe-3 text-end">
                            <button onclick="confirmDelete({{ $asset->id }}, 'removeAsset')" {{-- wire:click="removeAsset({{ $asset->id }})" wire:confirm="{{ __('Remove from batch?') }}" --}} class="btn-del-sm">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4 text-muted">
            <div style="font-size:32px;margin-bottom:8px;">💻</div>
            <p class="small mb-2">{{ __('No assets in this batch yet') }}</p>
            <button wire:click="openAssetForm({{ $batch->id }})" class="btn-add-asset">
                <i class="fa fa-plus me-1"></i> {{ __('Add First Asset') }}
            </button>
        </div>
        @endif
    </div>

</div>
@empty
<div class="text-center py-5 text-muted">
    <div style="font-size:48px;margin-bottom:12px;">📦</div>
    <h6 class="fw-bold text-dark mb-1">{{ __('No batches yet') }}</h6>
    <p class="small mb-3">{{ __('Add your first batch to this invoice') }}</p>
    <button wire:click="$set('showBatchForm', true)" class="btn btn-primary btn-sm rounded-pill px-4">
        <i class="fas fa-plus me-1"></i> {{ __('Add Batch') }}
    </button>
</div>
@endforelse

</div>


<script src="{{ asset('assets/js/confirmDelete.js') }}"></script>
