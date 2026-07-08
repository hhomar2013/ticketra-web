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

            .f-wrap .f-ico.ta {
                top: 14px;
                transform: none;
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

            .asset-info-card {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                overflow: hidden;
            }

            .asset-info-card .info-header {
                background: #111827;
                padding: 16px 20px;
            }

            .asset-info-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 12px 20px;
                border-bottom: 1px solid #f3f4f6;
                font-size: 13px;
            }

            .asset-info-row:last-child {
                border-bottom: none;
            }

            .asset-info-row .a-label {
                color: #9ca3af;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: .5px;
                text-transform: uppercase;
            }

            .asset-info-row .a-value {
                font-weight: 700;
                color: #111827;
                font-family: monospace;
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
                <div class="header-icon" style="background: rgba(13,110,253,.1);">👤</div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size: 16px;">{{ __('Assign to Employee') }}</h5>
                    <p class="text-muted mb-0" style="font-size: 12px;">
                        {{ __('Asset') }}: <strong style="font-family: monospace;">{{ $asset->asset_tag }}</strong>
                    </p>
                </div>
            </div>

            <div class="form-panel-body">

                {{-- ✅ نفس wire:submit --}}
                <form wire:submit="assignToEmployee">
                    <div class="row g-4">

                        {{-- Employee ✅ نفس wire:model.live --}}
                        <div class="col-12">
                            <label class="f-lbl">{{ __('Employee') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-user f-ico"></i>
                                <select class="f-input @error('employee_id') is-invalid @enderror"
                                    wire:model.live="employee_id">
                                    <option value="">{{ __('Select Employee') }}</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('employee_id')
                                <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Branch ✅ نفس wire:model.live + $branch as $branch --}}
                        <div class="col-12">
                            <label class="f-lbl">{{ __('Branch') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-building f-ico"></i>
                                <select class="f-input @error('branch_id') is-invalid @enderror"
                                    wire:model.live="branch_id">
                                    <option value="">{{ __('Select Branch') }}</option>
                                    @foreach ($branch as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('branch_id')
                                <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Notes ✅ نفس wire:model.live --}}
                        <div class="col-12">
                            <label class="f-lbl">{{ __('Notes') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-align-left f-ico ta"></i>
                                <textarea class="f-input @error('notes') is-invalid @enderror" wire:model.live="notes" rows="3"
                                    placeholder="{{ __('Optional notes...') }}">
                                </textarea>
                            </div>
                            @error('notes')
                                <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="d-flex align-items-center gap-2 mt-4 pt-4" style="border-top: 1px solid #f3f4f6;">
                        <button type="submit" class="btn-submit">
                            <span wire:loading.remove wire:target="assignToEmployee">
                                <i class="fa fa-user-check"></i> {{ __('Assign') }}
                            </span>
                            <span wire:loading wire:target="assignToEmployee">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ __('Assigning...') }}
                            </span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- ══════════════ SIDE PANEL ══════════════ --}}
        <div class="side-panel">

            {{-- Asset Info --}}
            <div class="asset-info-card shadow-sm">
                <div class="info-header">
                    <div class="d-flex align-items-center gap-3">
                        <div
                            style="width: 40px; height: 40px; border-radius: 11px;
                            background: rgba(255,255,255,.15); display: flex; align-items: center;
                            justify-content: center; font-size: 18px;">
                            💻</div>
                        <div>
                            <div
                                style="color: rgba(255,255,255,.6); font-size: 11px; text-transform: uppercase; letter-spacing: .5px;">
                                {{ __('Asset Info') }}
                            </div>
                            <div style="color: #fff; font-weight: 700; font-family: monospace; font-size: 15px;">
                                {{ $asset->asset_tag }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="asset-info-row">
                    <span class="a-label">{{ __('Asset Tag') }}</span>
                    <span class="a-value">{{ $asset->asset_tag }}</span>
                </div>
                <div class="asset-info-row">
                    <span class="a-label">{{ __('Serial Number') }}</span>
                    <span class="a-value">{{ $asset->serial_number }}</span>
                </div>
                @if ($asset->status)
                    <div class="asset-info-row">
                        <span class="a-label">{{ __('Status') }}</span>
                        <span
                            style="background: rgba(13,110,253,.1); color: #0d6efd;
                        border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                            {{ ucfirst($asset->status->label()) }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- Live Preview --}}
            <div class="preview-card shadow-sm">
                <div style="position: relative; z-index: 1;">
                    @php
                        $emp = $employees->firstWhere('id', $employee_id);
                        $selectedBranch = $branch_id ? \App\Models\branch::find($branch_id) : null;

                        $initials = $emp
                            ? strtoupper(
                                collect(explode(' ', $emp->name))
                                    ->map(fn($w) => $w[0] ?? '')
                                    ->take(2)
                                    ->join(''),
                            )
                            : '??';
                    @endphp

                    <div
                        style="width: 52px; height: 52px; border-radius: 50%;
                        background: rgba(255,255,255,.2);
                        display: flex; align-items: center; justify-content: center;
                        font-size: 18px; font-weight: 800; color: #fff;
                        margin-bottom: 12px;">
                        {{ $emp ? $initials : '👤' }}
                    </div>

                    <div
                        style="color: rgba(255,255,255,.5); font-size: 11px; margin-bottom: 4px;
                        text-transform: uppercase; letter-spacing: .5px;">
                        {{ __('Assigned To') }}
                    </div>
                    <div style="color: #fff; font-weight: 700; font-size: 15px; margin-bottom: 8px;">
                        {{ $emp?->name ?? '—' }}
                    </div>

                    @if ($selectedBranch)
                        <div style="color: rgba(255,255,255,.7); font-size: 13px;">
                            <i class="fa fa-building me-1"></i> {{ $selectedBranch->name }}
                        </div>
                    @endif

                    @if (!$emp)
                        <div style="color: rgba(255,255,255,.4); font-size: 12px; margin-top: 4px;">
                            {{ __('Select an employee to preview') }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tips --}}
            <div class="info-card">
                <h6>
                    <span
                        style="width: 24px; height: 24px; background: rgba(13,110,253,.1);
                        border-radius: 7px; display: inline-flex; align-items: center;
                        justify-content: center; font-size: 12px;">
                        <i class="fa fa-lightbulb text-primary"></i>
                    </span>
                    {{ __('Tips') }}
                </h6>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #0d6efd;"></div>
                    <span>{{ __('Make sure the employee is in the correct branch') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #0d6efd;"></div>
                    <span>{{ __('Assignment will be logged in the asset history') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #10b981;"></div>
                    <span>{{ __('You can return the asset later from the assets list') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>
