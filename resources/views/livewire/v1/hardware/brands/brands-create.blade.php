<div>
    <style>
        .branch-page {
            display: grid;
            grid-template-columns: 1fr 380px;
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

        .f-err {
            font-size: 11px;
            color: #ef4444;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Logo Upload ── */
        .logo-upload-wrap {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo-preview {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            border: 2px solid #e5e7eb;
            object-fit: contain;
            padding: 6px;
            background: #f9fafb;
            flex-shrink: 0;
            transition: border-color .2s;
        }

        .logo-upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f3f4f6;
            border: 1.5px dashed #d1d5db;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 13px;
            color: #6b7280;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
        }

        .logo-upload-btn:hover {
            border-color: #0d6efd;
            background: rgba(13, 110, 253, .04);
            color: #0d6efd;
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

    <div class="branch-page">

        {{-- ══════════════ FORM PANEL ══════════════ --}}
        <div class="form-panel shadow-sm">
            <div class="form-panel-header">
                <div class="header-icon"
                    style="{{ $IsEdit ? 'background: rgba(255,193,7,.12);' : 'background: rgba(13,110,253,.1);' }}">
                    {{ $IsEdit ? '✏️' : '🏷️' }}
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size: 16px;">
                        {{ $IsEdit ? __('Edit Brand') : __('Create New Brand') }}
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 12px;">
                        @if ($brand)
                            {{ __('Editing') }}: <strong>{{ $brand->name }}</strong>
                        @else
                            {{ __('Fill in the brand details below') }}
                        @endif
                    </p>
                </div>
            </div>

            <div class="form-panel-body">
                <form wire:submit.prevent="submitBrand">
                    <div class="row g-4">

                        {{-- Name --}}
                        <div class="col-12">
                            <label class="f-lbl">{{ __('Brand Name') }} <span class="text-danger">*</span></label>
                            <div class="f-wrap">
                                <i class="fa fa-tag f-ico"></i>
                                <input type="text" wire:model.live="name"
                                    class="f-input @error('name') is-invalid @enderror"
                                    placeholder="{{ __('e.g. Dell, HP, Lenovo') }}">
                            </div>
                            @error('name')
                                <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Logo Upload --}}
                        <div class="col-12">
                            <label class="f-lbl">{{ __('Brand Logo') }}</label>
                            <div class="logo-upload-wrap">

                                {{-- Preview --}}
                                @if ($logo)
                                    {{ $this->getPreviewUrl($logo) }}
                                    <img src="{{ $this->getPreviewUrl($logo) }}" alt="preview" class="logo-preview"
                                        style="border-color: #0d6efd;">
                                @elseif ($old_logo)
                                    <img src="{{ asset('storage/' . $old_logo) }}" alt="logo" class="logo-preview">
                                @else
                                    <div
                                        style="width: 80px; height: 80px; border-radius: 16px;
                                        border: 2px dashed #e5e7eb; background: #f9fafb;
                                        display: flex; align-items: center; justify-content: center;
                                        font-size: 28px; flex-shrink: 0;">
                                        🏷️
                                    </div>
                                @endif

                                {{-- Upload Button --}}
                                <label for="logo-input" class="logo-upload-btn">
                                    <i class="fa fa-upload"></i>
                                    @if ($logo || $old_logo)
                                        {{ __('Change Logo') }}
                                    @else
                                        {{ __('Upload Logo') }}
                                    @endif
                                    <input type="file" id="logo-input" wire:model="logo" accept="image/*" hidden>
                                </label>

                                <div wire:loading wire:target="logo" class="text-muted small">
                                    <span class="spinner-border spinner-border-sm me-1"></span>
                                    {{ __('Uploading...') }}
                                </div>
                            </div>
                            <div class="text-muted mt-2" style="font-size: 11px;">
                                <i class="fa fa-circle-info me-1 text-primary"></i>
                                {{ __('PNG, JPG or SVG. Recommended size: 200x200px') }}
                            </div>
                            @error('logo')
                                <div class="f-err mt-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="d-flex align-items-center gap-2 mt-4 pt-4" style="border-top: 1px solid #f3f4f6;">
                        <button type="submit" class="btn-submit">
                            <span wire:loading.remove wire:target="submitBrand">
                                <i class="fa {{ $IsEdit ? 'fa-floppy-disk' : 'fa-plus' }}"></i>
                                {{ $IsEdit ? __('Save Changes') : __('Create Brand') }}
                            </span>
                            <span wire:loading wire:target="submitBrand">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ __('Saving...') }}
                            </span>
                        </button>
                        <a wire:navigate href="{{ route('settings.config', ['page' => 'brands']) }}"
                            class="btn btn-outline-secondary rounded-pill px-4 fw-bold" style="font-size: 13px;">
                            <i class="fa fa-arrow-left me-1"></i> {{ __('Back') }}
                        </a>
                    </div>

                </form>
            </div>
        </div>

        {{-- ══════════════ SIDE PANEL ══════════════ --}}
        <div class="side-panel">

            {{-- Live Preview --}}
            <div class="preview-card shadow-sm">
                <div style="position: relative; z-index: 1;">

                    {{-- Logo or Avatar --}}
                    @if ($logo)
                        <img src="{{ $logo->temporaryUrl() }}"
                            style="width: 56px; height: 56px; border-radius: 14px;
                                   object-fit: contain; background: rgba(255,255,255,.2);
                                   padding: 6px; margin-bottom: 12px; display: block;">
                    @elseif ($old_logo)
                        <img src="{{ asset('storage/' . $old_logo) }}"
                            style="width: 56px; height: 56px; border-radius: 14px;
                                   object-fit: contain; background: rgba(255,255,255,.2);
                                   padding: 6px; margin-bottom: 12px; display: block;">
                    @else
                        @php
                            $n = trim($name ?? '');
                            $parts = explode(' ', $n);
                            $initials = $n
                                ? strtoupper(
                                    substr($parts[0], 0, 1) .
                                        (isset($parts[1]) ? substr($parts[1], 0, 1) : (strlen($n) > 1 ? $n[1] : '?')),
                                )
                                : '??';
                        @endphp
                        <div
                            style="width: 56px; height: 56px; border-radius: 14px;
                            background: rgba(255,255,255,.2);
                            display: flex; align-items: center; justify-content: center;
                            font-size: 22px; font-weight: 800; color: #fff;
                            margin-bottom: 12px;">
                            {{ $initials }}
                        </div>
                    @endif

                    <div class="text-white fw-bold mb-1" style="font-size: 16px;">
                        {{ $name ?? '' ?: __('Brand Name') }}
                    </div>
                    <div class="text-white text-opacity-75 small">
                        @if ($logo || $old_logo)
                            <i class="fa fa-check-circle me-1"></i> {{ __('Logo uploaded') }}
                        @else
                            {{ __('Fill in the form to preview') }}
                        @endif
                    </div>

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
                    <span>{{ __('Use the official brand name for consistency') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #0d6efd;"></div>
                    <span>{{ __('Upload a clear logo on a white or transparent background') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #0d6efd;"></div>
                    <span>{{ __('After creating the brand, you can add its models') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background: #10b981;"></div>
                    <span>{{ __('Recommended logo size is 200x200px for best display') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>
