<div>
    <style>
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
            margin-bottom: 20px;
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
    </style>

    <div class="form-panel shadow-sm">
        <div class="form-panel-header">
            <div class="header-icon"
                style="background: linear-gradient(135deg, #0d6efd, #0047c4); color: #fff; box-shadow: 0 6px 16px rgba(13,110,253,.25);">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0">
                    {{ $action === 'edit' ? __('Edit Department') : __('Add New Department') }}</h6>
                <small
                    class="text-muted">{{ $action === 'edit' ? __('Update department details') : __('Create a new department') }}</small>
            </div>
        </div>

        <div class="form-panel-body">
            <div class="row">
                <div class="col-lg-8">
                    {{-- Name --}}
                    <div class="f-group">
                        <label class="f-lbl">{{ __('Department Name') }}</label>
                        <div class="f-wrap">
                            <i class="fas fa-signature f-ico"></i>
                            <input type="text" class="form-control f-input @error('name') is-invalid @enderror"
                                placeholder="{{ __('e.g., Human Resources, Finance, IT') }}" wire:model.live="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <h6 class="d-flex align-items-center gap-2 text-primary"><i class="ti ti-info-circle"></i>
                            {{ __('Information') }}</h6>
                        <div class="tip-item">
                            <span class="tip-dot bg-primary"></span>
                            <span class="flex-grow-1">{{ __('Enter the department name.') }}</span>
                        </div>
                        <div class="tip-item">
                            <span class="tip-dot bg-primary"></span>
                            <span class="flex-grow-1">{{ __('The name must be unique and not repeated.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3">
                <button type="submit" wire:click.prevent="save" class="btn-submit">
                    <span wire:loading.remove wire:target="save">
                        <i class="fa {{ $action === 'edit' ? 'fa-floppy-disk' : 'fa-plus' }}"></i>
                        {{ $action === 'edit' ? __('Update') : __('Save') }}
                    </span>
                    <span wire:loading wire:target="save">
                        <span class="spinner-border spinner-border-sm"></span>
                        {{ __('Saving...') }}
                    </span>
                </button>
                <a href="{{ route('settings.config', ['page' => 'departments']) }}"
                    class="btn btn-outline-secondary rounded-pill px-4 fw-bold" style="font-size: 13px;">
                    <i class="fa fa-arrow-left me-1"></i> {{ __('Back') }}
                </a>

            </div>
        </div>
    </div>
</div>
