<div>
    @push('styles')
    <style>
        .branch-page { display: grid; grid-template-columns: 1fr 360px; gap: 20px; align-items: start; }
        .form-panel { background: #fff; border: 1px solid #e5e7eb; border-radius: 20px; overflow: hidden; }
        .form-panel-header { padding: 24px 28px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; gap: 14px; }
        .form-panel-header .header-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
        .form-panel-body { padding: 28px; }
        .f-lbl { font-size: 11px; font-weight: 700; letter-spacing: .7px; text-transform: uppercase; color: #9ca3af; margin-bottom: 7px; display: block; }
        .f-wrap { position: relative; }
        .f-wrap .f-ico { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #d1d5db; font-size: 13px; pointer-events: none; transition: color .2s; }
        .f-wrap:focus-within .f-ico { color: #0d6efd; }
        .f-input { width: 100%; border: 1.5px solid #e5e7eb; border-radius: 12px; padding: 11px 14px 11px 40px; font-size: 14px; color: #111827; background: #fafafa; transition: all .2s; outline: none; }
        .f-input::placeholder { color: #d1d5db; }
        .f-input:focus { border-color: #0d6efd; background: #fff; box-shadow: 0 0 0 4px rgba(13,110,253,.09); }
        .f-input.is-invalid { border-color: #ef4444; background: #fff8f8; }
        select.f-input { cursor: pointer; }
        .f-err { font-size: 11px; color: #ef4444; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
        .section-divider { font-size: 11px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; color: #9ca3af; display: flex; align-items: center; gap: 10px; margin: 4px 0 16px; }
        .section-divider::after { content: ''; flex: 1; height: 1px; background: #f3f4f6; }
        .btn-submit { background: linear-gradient(135deg, #0d6efd, #0047c4); border: none; border-radius: 12px; color: #fff; font-size: 14px; font-weight: 700; padding: 13px 28px; cursor: pointer; transition: transform .15s, box-shadow .2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(13,110,253,.3); }
        .side-panel { display: flex; flex-direction: column; gap: 16px; }
        .preview-card { background: linear-gradient(135deg, #0d6efd 0%, #0047c4 100%); border-radius: 16px; padding: 20px; position: relative; overflow: hidden; }
        .preview-card::before { content: ''; position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,.08); }
        .preview-card::after { content: ''; position: absolute; bottom: -15px; left: 30px; width: 70px; height: 70px; border-radius: 50%; background: rgba(255,255,255,.05); }
        .info-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 20px; }
        .info-card h6 { font-size: 13px; font-weight: 700; color: #111827; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
        .tip-item { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 12px; font-size: 13px; color: #6b7280; line-height: 1.5; }
        .tip-item:last-child { margin-bottom: 0; }
        .tip-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; margin-top: 6px; }
        .toggle-wrap { display: flex; align-items: center; justify-content: space-between; }
        .toggle-switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; cursor: pointer; inset: 0; background: #e5e7eb; border-radius: 24px; transition: .25s; }
        .toggle-slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: .25s; box-shadow: 0 1px 4px rgba(0,0,0,.15); }
        .toggle-switch input:checked + .toggle-slider { background: #0d6efd; }
        .toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }
        @media (max-width: 900px) { .branch-page { grid-template-columns: 1fr; } .side-panel { order: -1; } }
    </style>
    @endpush

    <div class="branch-page">

        {{-- ══════ FORM PANEL ══════ --}}
        <div class="form-panel shadow-sm">
            <div class="form-panel-header">
                <div class="header-icon"
                    style="{{ $IsEdit ? 'background:rgba(255,193,7,.12);' : 'background:rgba(13,110,253,.1);' }}">
                    {{ $IsEdit ? '✏️' : '👤' }}
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-size: 16px;">
                        {{ $IsEdit ? __('Edit User') : __('Create New User') }}
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 12px;">
                        {{ __('Fill in the user details below') }}
                    </p>
                </div>
            </div>

            <div class="form-panel-body">
                <div class="row g-4">

                    {{-- ── Personal Info ── --}}
                    <div class="col-12"><div class="section-divider">{{ __('Personal Info') }}</div></div>

                    <div class="col-md-6">
                        <label class="f-lbl">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                        <div class="f-wrap">
                            <i class="fa fa-user f-ico"></i>
                            <input type="text" wire:model.live="name"
                                class="f-input @error('name') is-invalid @enderror"
                                placeholder="{{ __('e.g. Ahmed Mohamed') }}">
                        </div>
                        @error('name') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="f-lbl">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                        <div class="f-wrap">
                            <i class="fa fa-envelope f-ico"></i>
                            <input type="email" wire:model.live="email"
                                class="f-input @error('email') is-invalid @enderror"
                                placeholder="user@company.com">
                        </div>
                        @error('email') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>

                    {{-- ── Security ── --}}
                    <div class="col-12"><div class="section-divider">{{ __('Security') }}</div></div>

                    <div class="col-md-6">
                        <label class="f-lbl">
                            {{ __('Password') }}
                            @if($IsEdit) <span class="text-muted fw-normal" style="text-transform:none;letter-spacing:0;">({{ __('leave blank to keep') }})</span> @else <span class="text-danger">*</span> @endif
                        </label>
                        <div class="f-wrap">
                            <i class="fa fa-lock f-ico"></i>
                            <input type="password" wire:model="password"
                                class="f-input @error('password') is-invalid @enderror"
                                placeholder="••••••••">
                        </div>
                        @error('password') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="f-lbl">{{ __('Role') }} <span class="text-danger">*</span></label>
                        <div class="f-wrap">
                            <i class="fa fa-shield-halved f-ico"></i>
                            <select wire:model.live="role" class="f-input @error('role') is-invalid @enderror">
                                <option value="">{{ __('Select Role') }}</option>
                                @foreach($roles as $r)
                                    <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('role') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>

                    {{-- ── Settings ── --}}
                    <div class="col-12"><div class="section-divider">{{ __('Settings') }}</div></div>

                    <div class="col-12">
                        <div class="toggle-wrap p-3 rounded-3" style="background:#f9fafb;border:1px solid #f3f4f6;">
                            <div>
                                <div class="fw-bold small">{{ __('Active Account') }}</div>
                                <div class="text-muted" style="font-size: 12px;">{{ __('User can login to the system') }}</div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" wire:model.live="is_active">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                </div>

                {{-- Actions --}}
                <div class="d-flex align-items-center gap-2 mt-4 pt-4" style="border-top: 1px solid #f3f4f6;">
                    <button wire:click="save" class="btn-submit">
                        <span wire:loading.remove wire:target="save">
                            <i class="fa {{ $IsEdit ? 'fa-floppy-disk' : 'fa-plus' }}"></i>
                            {{ $IsEdit ? __('Save Changes') : __('Create User') }}
                        </span>
                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm"></span>
                            {{ __('Saving...') }}
                        </span>
                    </button>
                    <a href="{{ route('user-management.index') }}" wire:navigate
                        class="btn btn-outline-secondary rounded-pill px-4 fw-bold" style="font-size:13px;">
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
                    @php
                        $n = trim($name ?? '');
                        $parts = explode(' ', $n);
                        $ini = $n ? strtoupper(substr($parts[0],0,1).(isset($parts[1])?substr($parts[1],0,1):substr($parts[0],1,1))) : '??';
                    @endphp
                    <div style="width:52px;height:52px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800;color:#fff;margin-bottom:12px;">
                        {{ $ini }}
                    </div>
                    <div style="color:#fff;font-weight:700;font-size:16px;margin-bottom:4px;">
                        {{ $n ?: __('User Name') }}
                    </div>
                    <div style="color:rgba(255,255,255,.7);font-size:13px;margin-bottom:8px;">
                        {{ ($email ?? '') ?: 'email@company.com' }}
                    </div>
                    @if($role)
                        <div style="background:rgba(255,255,255,.15);border-radius:20px;padding:4px 12px;display:inline-block;font-size:12px;font-weight:700;color:#fff;">
                            <i class="fa fa-shield-halved me-1"></i> {{ ucfirst($role) }}
                        </div>
                    @endif
                    <div class="mt-2">
                        <span style="font-size:11px;color:rgba(255,255,255,.6);">
                            {{ $is_active ? '🟢 '.__('Active') : '🔴 '.__('Inactive') }}
                        </span>
                    </div>
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
                    <span>{{ __('Use a real email - it will be used for notifications') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background:#0d6efd;"></div>
                    <span>{{ __('Password must be at least 8 characters') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background:#0d6efd;"></div>
                    <span>{{ __('Role determines what the user can access') }}</span>
                </div>
                <div class="tip-item">
                    <div class="tip-dot" style="background:#10b981;"></div>
                    <span>{{ __('Deactivated users cannot login to the system') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>
