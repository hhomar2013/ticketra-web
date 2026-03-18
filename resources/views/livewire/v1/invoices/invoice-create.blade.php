<div>
    @push('styles')
    <style>
        .branch-page {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 20px;
            align-items: start;
        }

        .form-panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            overflow: hidden;
        }

        .form-panel-header {
            padding: 24px 28px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .form-panel-header .header-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .form-panel-body {
            padding: 28px;
        }

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
            padding: 11px 14px 11px 40px;
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

        textarea.f-input {
            padding-left: 40px;
            resize: none;
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

        .batch-section {
            background: #f9fafb;
            border: 1.5px dashed #e5e7eb;
            border-radius: 16px;
            padding: 20px;
            transition: border-color .2s;
        }

        .batch-section.active {
            border-color: #0d6efd;
            background: rgba(13, 110, 253, .02);
        }

        .btn-submit {
            background: linear-gradient(135deg, #0d6efd, #0047c4);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            padding: 13px 28px;
            cursor: pointer;
            transition: transform .15s, box-shadow .2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(13, 110, 253, .3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .side-panel {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .preview-card {
            background: linear-gradient(135deg, #0d6efd 0%, #0047c4 100%);
            border-radius: 16px;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .preview-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
        }

        .preview-card::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 30px;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
        }

        .p-row {
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .p-label {
            color: rgba(255, 255, 255, .5);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 2px;
        }

        .p-value {
            color: #fff;
            font-weight: 700;
            font-size: 13px;
        }

        .info-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 20px;
        }

        .info-card h6 {
            font-size: 13px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tip-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
        }

        .tip-item:last-child {
            margin-bottom: 0;
        }

        .tip-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 6px;
        }

        .toggle-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: #e5e7eb;
            border-radius: 24px;
            transition: .25s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            left: 3px;
            top: 3px;
            background: #fff;
            border-radius: 50%;
            transition: .25s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .15);
        }

        .toggle-switch input:checked+.toggle-slider {
            background: #0d6efd;
        }

        .toggle-switch input:checked+.toggle-slider::before {
            transform: translateX(20px);
        }

        @media (max-width: 900px) {
            .branch-page {
                grid-template-columns: 1fr;
            }

            .side-panel {
                order: -1;
            }
        }

    </style>
    @endpush


    <div class="branch-page">

        {{-- ══════ FORM PANEL ══════ --}}
        <div class="form-panel shadow-sm">
            <div class="form-panel-header">
                <div class="header-icon" style="{{ $IsEdit ? 'background:rgba(255,193,7,.12);' : 'background:rgba(13,110,253,.1);' }}">
                    {{ $IsEdit ? '✏️' : '🧾' }}
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size:16px;">
                        {{ $IsEdit ? __('Edit Invoice') : __('Create Purchase Invoice') }}
                    </h5>
                    <p class="text-muted mb-0" style="font-size:12px;">
                        {{ __('Fill in the invoice details below') }}
                    </p>
                </div>
            </div>

            <div class="form-panel-body">
                <div class="row g-4">

                    {{-- ── Invoice Info ── --}}
                    <div class="col-12">
                        <div class="section-divider">{{ __('Invoice Info') }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="f-lbl">{{ __('Invoice Number') }} <span class="text-danger">*</span></label>
                        <div class="f-wrap">
                            <i class="fa fa-hashtag f-ico"></i>
                            <input type="text" wire:model.live="invoice_number" class="f-input @error('invoice_number') is-invalid @enderror" placeholder="INV-2025-001">
                        </div>
                        @error('invoice_number') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="f-lbl">{{ __('Invoice Date') }} <span class="text-danger">*</span></label>
                        <div class="f-wrap">
                            <i class="fa fa-calendar f-ico"></i>
                            <input type="date" wire:model.live="invoice_date" class="f-input @error('invoice_date') is-invalid @enderror">
                        </div>
                        @error('invoice_date') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="f-lbl">{{ __('Supplier') }} <span class="text-danger">*</span></label>
                        <div class="f-wrap">
                            <i class="fa fa-truck f-ico"></i>
                            <select wire:model.live="suppliers_id" class="f-input @error('suppliers_id') is-invalid @enderror">
                                <option value="">{{ __('Select Supplier') }}</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('suppliers_id') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="f-lbl">{{ __('Total Amount') }} <span class="text-danger">*</span></label>
                        <div class="f-wrap">
                            <i class="fa fa-dollar-sign f-ico"></i>
                            <input type="number" wire:model.live="total_amount" class="f-input @error('total_amount') is-invalid @enderror" placeholder="0.00" step="0.01" min="0">
                        </div>
                        @error('total_amount') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="f-lbl">{{ __('Status') }}</label>
                        <div class="f-wrap">
                            <i class="fa fa-circle-dot f-ico"></i>
                            <select wire:model.live="status" class="f-input">
                                <option value="pending">{{ __('Pending') }}</option>
                                <option value="paid">{{ __('Paid') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="f-lbl">{{ __('Notes') }}</label>
                        <div class="f-wrap">
                            <i class="fa fa-align-left f-ico" style="top:14px;transform:none;"></i>
                            <textarea wire:model="notes" rows="2" class="f-input" placeholder="{{ __('Optional notes about this invoice...') }}"></textarea>
                        </div>
                    </div>

                    {{-- ── Batch Section ── --}}
                    @if(!$IsEdit)
                    <div class="col-12">
                        <div class="section-divider">{{ __('Batch') }}</div>
                        <div class="batch-section {{ $addBatch ? 'active' : '' }}">

                            <div class="toggle-wrap mb-3">
                                <div>
                                    <div class="fw-bold small">{{ __('Add Batch with this Invoice') }}</div>
                                    <div class="text-muted" style="font-size:12px;">{{ __('Create a batch linked to this invoice') }}</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" wire:model.live="addBatch">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            @if($addBatch)
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="f-lbl">{{ __('Batch Number') }} <span class="text-danger">*</span></label>
                                    <div class="f-wrap">
                                        <i class="fa fa-boxes-stacked f-ico"></i>
                                        <input type="text" wire:model="batch_number" class="f-input @error('batch_number') is-invalid @enderror" placeholder="BATCH-2025-001">
                                    </div>
                                    @error('batch_number') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="f-lbl">{{ __('Received Date') }} <span class="text-danger">*</span></label>
                                    <div class="f-wrap">
                                        <i class="fa fa-calendar f-ico"></i>
                                        <input type="date" wire:model="received_date" class="f-input @error('received_date') is-invalid @enderror">
                                    </div>
                                    @error('received_date') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="f-lbl">{{ __('Batch Status') }}</label>
                                    <div class="f-wrap">
                                        <i class="fa fa-circle-dot f-ico"></i>
                                        <select wire:model="batch_status" class="f-input">
                                            <option value="pending">{{ __('Pending') }}</option>
                                            <option value="stocked">{{ __('Stocked') }}</option>
                                            <option value="partial">{{ __('Partial') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-lbl">{{ __('Batch Notes') }}</label>
                                    <div class="f-wrap">
                                        <i class="fa fa-align-left f-ico"></i>
                                        <input type="text" wire:model="batch_notes" class="f-input" placeholder="{{ __('Optional...') }}">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Actions --}}
                <div class="d-flex align-items-center gap-2 mt-4 pt-4" style="border-top:1px solid #f3f4f6;">
                    <button wire:click="save" class="btn-submit">
                        <span wire:loading.remove wire:target="save">
                            <i class="fa {{ $IsEdit ? 'fa-floppy-disk' : 'fa-plus' }}"></i>
                            {{ $IsEdit ? __('Save Changes') : __('Create Invoice') }}
                        </span>
                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm"></span>
                            {{ __('Saving...') }}
                        </span>
                    </button>
                    <a href="{{ route('invoices.index') }}" wire:navigate class="btn btn-outline-secondary rounded-pill px-4 fw-bold" style="font-size:13px;">
                        <i class="fa fa-arrow-left me-1"></i> {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- ══════ SIDE PANEL ══════ --}}
        <div class="side-panel">

            {{-- Live Preview --}}
            <div class="preview-card shadow-sm">
                <div style="position:relative;z-index:1;">
                    <div style="width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:14px;">
                        🧾
                    </div>

                    <div class="p-row">
                        <div class="p-label">{{ __('Invoice #') }}</div>
                        <div class="p-value font-monospace">{{ ($invoice_number ?? '') ?: '—' }}</div>
                    </div>

                    @if($suppliers_id)
                    <div class="p-row">
                        <div class="p-label">{{ __('Supplier') }}</div>
                        <div class="p-value">
                            {{ $suppliers->firstWhere('id', $suppliers_id)?->name ?? '—' }}
                        </div>
                    </div>
                    @endif

                    @if($invoice_date)
                    <div class="p-row">
                        <div class="p-label">{{ __('Date') }}</div>
                        <div class="p-value">{{ \Carbon\Carbon::parse($invoice_date)->format('d M Y') }}</div>
                    </div>
                    @endif

                    @if($total_amount)
                    <div class="p-row">
                        <div class="p-label">{{ __('Amount') }}</div>
                        <div class="p-value" style="font-size:20px;">
                            {{ number_format($total_amount, 2) }}
                        </div>
                    </div>
                    @endif

                    <div class="p-row">
                        <span style="background:{{ $status === 'paid' ? 'rgba(25,135,84,.3)' : 'rgba(255,193,7,.3)' }};color:#fff;border-radius:20px;padding:4px 12px;font-size:11px;font-weight:700;">
                            {{ $status === 'paid' ? '✅ '.__('Paid') : '⏳ '.__('Pending') }}
                        </span>
                    </div>

                    @if($addBatch && !$IsEdit && $batch_number)
                    <div class="p-row" style="margin-top:10px;padding-top:10px;border-top:1px solid rgba(255,255,255,.15);">
                        <div class="p-label">{{ __('Batch') }}</div>
                        <div class="p-value font-monospace">{{ $batch_number }}</div>
                    </div>
                    @endif

                    @if(!$invoice_number && !$suppliers_id)
                    <div style="color:rgba(255,255,255,.4);font-size:12px;">
                        {{ __('Fill in the form to preview') }}
                    </div>
                    @endif
                </div>
            </div>

            {{-- Tips --}}
            <div class="info-card">
                <h6>
                    <span style="width:24px;height:24px;background:rgba(13,110,253,.1);border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:12px;">
                        <i class="fa fa-lightbulb text-primary"></i>
                    </span>
                    {{ __('Tips') }}
                </h6>
                <div class="tip-item">
                    <div class="tip-dot" style="background:#0d6efd;"></div>
                    <span>{{ __('Invoice number must be unique for each supplier') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background:#0d6efd;"></div>
                    <span>{{ __('You can add multiple batches to one invoice later') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background:#0d6efd;"></div>
                    <span>{{ __('Batch number is auto-generated but can be changed') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background:#10b981;"></div>
                    <span>{{ __('Mark invoice as paid after confirming payment') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>
