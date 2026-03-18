<div>
    <style>
        .branch-page {
            display: grid;
            grid-template-columns: 1fr 1fr;
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
            width: 100%;
            justify-content: center;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(13, 110, 253, .3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Models List Panel */
        .models-panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            overflow: hidden;
        }

        .models-panel-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .model-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 24px;
            border-bottom: 1px solid #f9fafb;
            transition: background .15s;
        }

        .model-item:last-child {
            border-bottom: none;
        }

        .model-item:hover {
            background: #fafafa;
        }

        .model-avatar {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: rgba(13, 110, 253, .1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #0d6efd;
            flex-shrink: 0;
        }

        .btn-delete {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(220, 53, 69, .08);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, .15);
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-delete:hover {
            background: rgba(220, 53, 69, .15);
        }

        @media (max-width: 768px) {
            .branch-page {
                grid-template-columns: 1fr;
            }
        }

    </style>

    {{-- ══════ Page Header ══════ --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        @if($brands->logo)
        <img src="{{ asset('storage/' . $brands->logo) }}" style="width: 48px; height: 48px; border-radius: 14px;
                       object-fit: contain; border: 1px solid #e5e7eb;
                       padding: 5px; background: #fff;">
        @else
        <div style="width: 48px; height: 48px; border-radius: 14px;
                background: rgba(13,110,253,.1);
                display: flex; align-items: center; justify-content: center;
                font-size: 18px; font-weight: 700; color: #0d6efd;">
            {{ strtoupper(substr($brands->name, 0, 2)) }}
        </div>
        @endif
        <div>
            <h5 class="fw-bold mb-0">{{ $brands->name }}</h5>
            <small class="text-muted">{{ __('Manage models for this brand') }}</small>
        </div>
        <a href="{{ route('hardware.brands') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 ms-auto fw-bold" style="font-size: 13px;">
            <i class="fa fa-arrow-left me-1"></i> {{ __('Back to Brands') }}
        </a>
    </div>

    <div class="branch-page">

        {{-- ══════ ADD MODEL FORM ══════ --}}
        <div class="form-panel shadow-sm">
            <div class="form-panel-header">
                <div class="header-icon" style="background: rgba(13,110,253,.1);">
                    ➕
                </div>
                <div>
                    <h6 class="fw-bold mb-0" style="font-size: 15px;">{{ __('Add New Model') }}</h6>
                    <p class="text-muted mb-0" style="font-size: 12px;">
                        {{ __('Add a model to') }} <strong>{{ $brands->name }}</strong>
                    </p>
                </div>
            </div>

            <div class="form-panel-body">
                <form wire:submit.prevent="submitModel">

                    <div class="mb-4">
                        <label class="f-lbl">{{ __('Model Name') }} <span class="text-danger">*</span></label>
                        <div class="f-wrap">
                            <i class="fa fa-cube f-ico"></i>
                            <input type="text" wire:model="name" class="f-input @error('name') is-invalid @enderror" placeholder="{{ __('e.g. Latitude 5420, ProBook 450') }}">
                        </div>
                        @error('name')
                        <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <span wire:loading.remove wire:target="submitModel">
                            <i class="fa fa-plus"></i> {{ __('Add Model') }}
                        </span>
                        <span wire:loading wire:target="submitModel">
                            <span class="spinner-border spinner-border-sm"></span>
                            {{ __('Adding...') }}
                        </span>
                    </button>

                </form>
            </div>
        </div>

        {{-- ══════ MODELS LIST ══════ --}}
        <div class="models-panel shadow-sm">
            <div class="models-panel-header">
                <div>
                    <h6 class="fw-bold mb-0" style="font-size: 15px;">{{ __('Models') }}</h6>
                    <small class="text-muted">{{ __('All models for this brand') }}</small>
                </div>
                <span class="badge rounded-pill px-3 py-2" style="background: rgba(13,110,253,.1); color: #0d6efd; font-size: 12px;">
                    {{ $models->count() }} {{ __('models') }}
                </span>
            </div>

            @forelse ($models as $model)
            <div class="model-item">
                <div class="d-flex align-items-center gap-2">
                    <div class="model-avatar">
                        {{ strtoupper(substr($model->name, 0, 2)) }}
                    </div>
                    <span class="fw-bold small">{{ $model->name }}</span>
                </div>
                <button onclick="confirmDelete({{ $model->id }}, 'delete-model')" class="btn-delete">
                    <i class="fas fa-trash" style="font-size: 11px;"></i>
                    {{ __('Delete') }}
                </button>
            </div>
            @empty
            <div class="text-center py-5 text-muted">
                <div style="font-size: 40px; margin-bottom: 10px;">📦</div>
                <p class="small mb-0">{{ __('No models yet') }}</p>
                <small>{{ __('Add your first model using the form') }}</small>
            </div>
            @endforelse

        </div>

    </div>

</div>

@push('js')
<script src="{{ asset('assets/js/confirmDelete.js') }}"></script>
@endpush
