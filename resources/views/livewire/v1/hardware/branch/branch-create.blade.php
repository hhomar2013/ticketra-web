<div>
    @push('styles')

    @endpush
    <style>
        .branch-page {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
            align-items: start;
        }

        /* ── Form Panel ── */
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

        /* ── Fields ── */
        .f-group {
            margin-bottom: 0;
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

        .f-wrap .f-ico.ta-ico {
            top: 14px;
            transform: none;
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

        /* ── Submit Button ── */
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

        /* ── Side Panel ── */
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
            background: #0d6efd;
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

        .preview-avatar {
            width: 52px;
            height: 52px;
            border-radius: 15px;
            background: rgba(255, 255, 255, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 1px;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
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
    <div class="branch-page">

        {{-- ══════════════ FORM PANEL ══════════════ --}}
        <div class="form-panel shadow-sm">

            {{-- Header --}}
            <div class="form-panel-header">
                <div class="header-icon" style="{{ $IsEdit ? 'background: rgba(255,193,7,.12);' : 'background: rgba(13,110,253,.1);' }}">
                    {{ $IsEdit ? '✏️' : '🏢' }}
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size: 16px;">
                        {{ $IsEdit ? __('Edit Branch') : __('Create New Branch') }}
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 12px;">
                        @if ($branch)
                        {{ __('Editing') }}: <strong>{{ $branch->name }}</strong>
                        @else
                        {{ __('Fill in the branch details below') }}
                        @endif
                    </p>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="form-panel-body">
                <form wire:submit.prevent="createBranch">
                    <div class="row g-4">

                        {{-- Name --}}
                        <div class="col-lg-6 f-group">
                            <label class="f-lbl">{{ __('Branch Name') }} <span class="text-danger">*</span></label>
                            <div class="f-wrap">
                                <i class="fa fa-building f-ico"></i>
                                <input type="text" wire:model.live="name" class="f-input @error('name') is-invalid @enderror" placeholder="{{ __('e.g. Cairo HQ') }}">
                            </div>
                            @error('name')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="col-lg-6 f-group">
                            <label class="f-lbl">{{ __('Phone') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-phone f-ico"></i>
                                <input type="text" wire:model="phone" class="f-input @error('phone') is-invalid @enderror" placeholder="+20 10 0000 0000">
                            </div>
                            @error('phone')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-lg-6 f-group">
                            <label class="f-lbl">{{ __('Email') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-envelope f-ico"></i>
                                <input type="email" wire:model="email" class="f-input @error('email') is-invalid @enderror" placeholder="branch@company.com">
                            </div>
                            @error('email')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Location --}}
                        <div class="col-lg-6 f-group">
                            <label class="f-lbl">{{ __('Location') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-location-dot f-ico"></i>
                                <input type="text" wire:model="location" class="f-input @error('location') is-invalid @enderror" placeholder="{{ __('e.g. Cairo, Egypt') }}">
                            </div>
                            @error('location')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="col-12 f-group">
                            <label class="f-lbl">{{ __('Description') }}</label>
                            <div class="f-wrap">
                                <i class="fa fa-align-left f-ico ta-ico"></i>
                                <textarea wire:model="description" rows="3" class="f-input @error('description') is-invalid @enderror" placeholder="{{ __('Optional notes about this branch...') }}">
                                </textarea>
                            </div>
                            @error('description')
                            <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex align-items-center gap-2 mt-4 pt-4" style="border-top: 1px solid #f3f4f6;">
                        <button type="submit" class="btn-submit">
                            <span wire:loading.remove wire:target="createBranch">
                                <i class="fa {{ $IsEdit ? 'fa-floppy-disk' : 'fa-plus' }}"></i>
                                {{ $IsEdit ? __('Save Changes') : __('Create Branch') }}
                            </span>
                            <span wire:loading wire:target="createBranch">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ __('Saving...') }}
                            </span>
                        </button>
                        <a href="{{ route('settings.config', ['page' => 'branches']) }}" wire:navigate class="btn btn-outline-secondary rounded-pill px-4 fw-bold" style="font-size: 13px;">
                            <i class="fa fa-arrow-left me-1"></i> {{ __('Back') }}
                        </a>
                    </div>

                </form>
            </div>
        </div>

        {{-- ══════════════ SIDE PANEL ══════════════ --}}
        <div class="side-panel">

            {{-- Live Preview Card --}}
            <div class="preview-card shadow-sm">
                <div style="position: relative; z-index: 1;">
                    <div class="preview-avatar">
                        {{ $name ? strtoupper(substr(explode(' ', trim($name))[0], 0, 1) . (str_contains(trim($name), ' ') ? substr(explode(' ', trim($name))[1], 0, 1) : (strlen(trim($name)) > 1 ? $name[1] : '?'))) : '??' }}
                    </div>
                    <div class="text-white fw-bold mb-1" style="font-size: 16px;">
                        {{ $name ?: __('Branch Name') }}
                    </div>
                    @if($location)
                    <div class="text-white text-opacity-75 small mb-1">
                        <i class="fa fa-location-dot me-1"></i> {{ $location }}
                    </div>
                    @endif
                    @if($email)
                    <div class="text-white text-opacity-75 small mb-1">
                        <i class="fa fa-envelope me-1"></i> {{ $email }}
                    </div>
                    @endif
                    @if($phone)
                    <div class="text-white text-opacity-75 small">
                        <i class="fa fa-phone me-1"></i> {{ $phone }}
                    </div>
                    @endif
                    @if(!$location && !$email && !$phone)
                    <div class="text-white text-opacity-50 small">
                        {{ __('Fill in the form to preview') }}
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
                    <div class="tip-dot"></div>
                    <span>{{ __('Use a clear, recognizable name for each branch') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot"></div>
                    <span>{{ __('Adding a location helps identify branches quickly') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot"></div>
                    <span>{{ __('Email and phone are shown to users in the portal') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #10b981;"></div>
                    <span>{{ __('After creating, assign IT staff and users to this branch') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>
