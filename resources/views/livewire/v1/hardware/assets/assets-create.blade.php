<div>
    @push('styles')
    <style>
        .branch-page {
            display: grid;
            grid-template-columns: 1fr 340px;
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

        {{-- ══════════════ FORM PANEL ══════════════ --}}
        <div class="form-panel shadow-sm">
            <div class="form-panel-header">
                <div class="header-icon" style="background: rgba(13,110,253,.1);">💻</div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size: 16px;">{{ __('Assets') }}</h5>
                    <p class="text-muted mb-0" style="font-size: 12px;">{{ __('Fill in the asset details below') }}</p>
                </div>
            </div>

            <div class="form-panel-body">
                {{-- ✅ نفس الـ form بالظبط --}}
                <form wire:submit="submit">

                    {{-- ── Identity ── --}}
                    <div class="section-divider">{{ __('Identity') }}</div>
                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label class="f-lbl">{{ __('Asset Tag') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-tag f-ico"></i>
                                {{-- ✅ نفس wire:model --}}
                                <input type="text" class="f-input @error('asset_tag') is-invalid @enderror" id="asset_tag" wire:model="asset_tag" placeholder="AST-0001">
                            </div>
                            @error('asset_tag')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="f-lbl">{{ __('Serial Number') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-barcode f-ico"></i>
                                {{-- ✅ نفس wire:model --}}
                                <input type="text" class="f-input @error('serial_number') is-invalid @enderror" id="serial_number" wire:model="serial_number" placeholder="SN-XXXXXXXXXX">
                            </div>
                            @error('serial_number')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- ── Classification ── --}}
                    <div class="section-divider">{{ __('Classification') }}</div>
                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label class="f-lbl">{{ __('Category') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-layer-group f-ico"></i>
                                {{-- ✅ نفس wire:model --}}
                                <select class="f-input @error('category_id') is-invalid @enderror" id="category_id" wire:model="category_id">
                                    <option>{{ __('Select Category') }}</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="f-lbl">{{ __('Branch') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-building f-ico"></i>
                                {{-- ✅ نفس wire:model --}}
                                <select class="f-input @error('branch_id') is-invalid @enderror" id="branch_id" wire:model="branch_id">
                                    <option>{{ __('Select Branch') }}</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('branch_id')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="f-lbl">{{ __('Brand') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-bookmark f-ico"></i>
                                {{-- ✅ نفس wire:model.live + wire:change --}}
                                <select class="f-input @error('brand_id') is-invalid @enderror" id="brand_id" wire:model.live="brand_id" wire:change="getTypeModels()">
                                    <option>{{ __('Select Brand') }}</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('brand_id')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ✅ نفس wire:ignore.self --}}
                        <div class="col-md-6" wire:ignore.self>
                            <label class="f-lbl">{{ __('Type Model') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-cube f-ico"></i>
                                {{-- ✅ نفس wire:model --}}
                                <select class="f-input @error('type_model_id') is-invalid @enderror" id="type_model_id" wire:model="type_model_id">
                                    <option>{{ __('Select Type Model') }}</option>
                                    @if ($brand_id)
                                    @foreach ($type_models as $type_model)
                                    <option value="{{ $type_model->id }}">{{ $type_model->name }}</option>
                                    @endforeach
                                    @else
                                    <option>{{ __('No Type Models Found') }}</option>
                                    @endif
                                </select>
                            </div>
                            @error('type_model_id')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- ── Dates ── --}}
                    <div class="section-divider">{{ __('Dates') }}</div>
                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label class="f-lbl">{{ __('Purchase Date') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-calendar f-ico"></i>
                                {{-- ✅ نفس wire:model --}}
                                <input type="date" class="f-input @error('purchase_date') is-invalid @enderror" id="purchase_date" wire:model="purchase_date">
                            </div>
                            @error('purchase_date')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="f-lbl">{{ __('Warranty Expiry') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-shield-halved f-ico"></i>
                                {{-- ✅ نفس wire:model --}}
                                <input type="date" class="f-input @error('warranty_expiry') is-invalid @enderror" id="warranty_expiry" wire:model="warranty_expiry">
                            </div>
                            @error('warranty_expiry')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- ── Actions ── --}}
                    <div class="d-flex align-items-center gap-2 pt-4" style="border-top: 1px solid #f3f4f6;">

                        {{-- ✅ نفس wire:click + wire:loading.attr --}}
                        <button type="button" wire:click="submit" wire:loading.attr="disabled" class="btn-submit">
                            <span wire:loading.remove wire:target="submit">
                                <i class="fa fa-plus"></i> {{ __('Submit') }}
                            </span>
                            <span wire:loading wire:target="submit">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ __('Saving...') }}
                            </span>
                        </button>

                        {{-- ✅ نفس wire:click --}}
                        <button type="button" wire:click="backToAssets" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" style="font-size: 13px;">
                            <i class="fa fa-arrow-left me-1"></i> {{ __('Back to Assets') }}
                        </button>

                    </div>

                </form>
            </div>
        </div>

        {{-- ══════════════ SIDE PANEL ══════════════ --}}
        <div class="side-panel">

            {{-- Preview Card --}}
            <div class="preview-card shadow-sm">
                <div style="position: relative; z-index: 1;">
                    <div style="width: 52px; height: 52px; border-radius: 14px;
                        background: rgba(255,255,255,.2); display: flex; align-items: center;
                        justify-content: center; font-size: 26px; margin-bottom: 14px;">
                        💻
                    </div>
                    <div style="color: rgba(255,255,255,.5); font-size: 11px; margin-bottom: 4px;">
                        {{ __('Asset Tag') }}
                    </div>
                    <div style="color: #fff; font-family: monospace; font-weight: 700;
                        font-size: 16px; margin-bottom: 10px;">
                        {{ ($asset_tag ?? '') ?: '—' }}
                    </div>
                    <div style="color: rgba(255,255,255,.5); font-size: 11px; margin-bottom: 4px;">
                        {{ __('Serial Number') }}
                    </div>
                    <div style="color: rgba(255,255,255,.85); font-family: monospace; font-size: 13px;">
                        {{ ($serial_number ?? '') ?: '—' }}
                    </div>
                    @if($purchase_date ?? false)
                    <div style="color: rgba(255,255,255,.6); font-size: 12px; margin-top: 10px;">
                        <i class="fa fa-calendar me-1"></i> {{ $purchase_date }}
                    </div>
                    @endif
                    @if($warranty_expiry ?? false)
                    <div style="color: rgba(255,255,255,.6); font-size: 12px; margin-top: 6px;">
                        <i class="fa fa-shield-halved me-1"></i> {{ $warranty_expiry }}
                    </div>
                    @endif
                </div>
            </div>

            {{-- Tips --}}
            <div class="info-card">
                <h6>
                    <span style="width: 24px; height: 24px; background: rgba(13,110,253,.1);
                        border-radius: 7px; display: inline-flex; align-items: center;
                        justify-content: center; font-size: 12px;">
                        <i class="fa fa-lightbulb text-primary"></i>
                    </span>
                    {{ __('Tips') }}
                </h6>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #0d6efd;"></div>
                    <span>{{ __('Asset Tag must be unique across all assets') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #0d6efd;"></div>
                    <span>{{ __('Select a brand first to load its available models') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #0d6efd;"></div>
                    <span>{{ __('Purchase date helps track the asset lifecycle') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #10b981;"></div>
                    <span>{{ __('Warranty expiry alerts help schedule maintenance on time') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>
