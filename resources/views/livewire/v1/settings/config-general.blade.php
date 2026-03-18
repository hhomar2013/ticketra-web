<div>
    @push('styles')
    <style>
        .setting-section {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .setting-section-header {
            padding: 16px 20px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-icon {
            width: 32px; height: 32px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        .setting-section-body { padding: 20px; }

        .setting-field label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 6px;
            display: block;
        }
        .setting-field .field-hint {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 4px;
        }
        .s-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            color: #111827;
            background: #f9fafb;
            transition: all .2s;
            outline: none;
        }
        .s-input:focus {
            border-color: #0d6efd;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13,110,253,.08);
        }
        select.s-input { cursor: pointer; }

        /* Toggle Switch */
        .toggle-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .toggle-wrap:last-child { border-bottom: none; padding-bottom: 0; }
        .toggle-wrap:first-child { padding-top: 0; }
        .toggle-info h6 {
            font-size: 14px; font-weight: 600;
            color: #111827; margin-bottom: 2px;
        }
        .toggle-info p { font-size: 12px; color: #9ca3af; margin: 0; }

        .toggle-switch {
            position: relative;
            width: 44px; height: 24px;
            flex-shrink: 0;
        }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
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
            width: 18px; height: 18px;
            left: 3px; top: 3px;
            background: #fff;
            border-radius: 50%;
            transition: .25s;
            box-shadow: 0 1px 4px rgba(0,0,0,.15);
        }
        .toggle-switch input:checked + .toggle-slider { background: #0d6efd; }
        .toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }

        .save-bar {
            position: sticky;
            bottom: 0;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            padding: 16px 0;
            margin-top: 8px;
            z-index: 10;
        }
        .btn-save {
            background: linear-gradient(135deg, #0d6efd, #0047c4);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            padding: 12px 32px;
            cursor: pointer;
            transition: transform .15s, box-shadow .2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-save:hover  { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(13,110,253,.3); }
        .btn-save:active { transform: translateY(0); }

        .maintenance-banner {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 1px solid #fbbf24;
            border-radius: 12px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }
    </style>
    @endpush

    <div>

        {{-- Maintenance Warning --}}
        @if ($maintenance_mode)
            <div class="maintenance-banner">
                <span style="font-size: 22px;">⚠️</span>
                <div>
                    <div style="font-size: 13px; font-weight: 700; color: #92400e;">
                        {{ __('Maintenance Mode is ON') }}
                    </div>
                    <div style="font-size: 12px; color: #b45309;">
                        {{ __('Users cannot access the system right now') }}
                    </div>
                </div>
            </div>
        @endif

        {{-- ══════ 1. System Info ══════ --}}
        <div class="setting-section">
            <div class="setting-section-header">
                <div class="section-icon bg-primary bg-opacity-10">
                    <i class="fa fa-globe text-primary"></i>
                </div>
                <div>
                    <div style="font-size: 14px; font-weight: 700; color: #111827;">
                        {{ __('System Information') }}
                    </div>
                    <div style="font-size: 11px; color: #9ca3af;">
                        {{ __('Basic system identity and localization') }}
                    </div>
                </div>
            </div>
            <div class="setting-section-body">
                <div class="row g-3">

                    <div class="col-lg-6 setting-field">
                        <label>{{ __('System Name') }}</label>
                        <input type="text" wire:model="app_name"
                            class="s-input @error('app_name') border-danger @enderror"
                            placeholder="My IT System">
                        @error('app_name')
                            <div class="text-danger" style="font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                        @enderror
                        <div class="field-hint">{{ __('Displayed in browser tab and emails') }}</div>
                    </div>

                    <div class="col-lg-6 setting-field">
                        <label>{{ __('Timezone') }}</label>
                        <select wire:model="app_timezone" class="s-input">
                            <option value="UTC">UTC</option>
                            <option value="Africa/Cairo">Africa/Cairo (GMT+2)</option>
                            <option value="Asia/Riyadh">Asia/Riyadh (GMT+3)</option>
                            <option value="Asia/Dubai">Asia/Dubai (GMT+4)</option>
                            <option value="Europe/London">Europe/London (GMT+0)</option>
                            <option value="America/New_York">America/New_York (GMT-5)</option>
                        </select>
                        <div class="field-hint">{{ __('Affects timestamps and scheduled tasks') }}</div>
                    </div>

                    <div class="col-lg-6 setting-field">
                        <label>{{ __('Default Language') }}</label>
                        <select wire:model="app_language" class="s-input">
                            <option value="en">🇬🇧 English</option>
                            <option value="ar">🇸🇦 العربية</option>
                        </select>
                        <div class="field-hint">{{ __('System default language') }}</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════ 2. Support Contact ══════ --}}
        <div class="setting-section">
            <div class="setting-section-header">
                <div class="section-icon bg-success bg-opacity-10">
                    <i class="fa fa-headset text-success"></i>
                </div>
                <div>
                    <div style="font-size: 14px; font-weight: 700; color: #111827;">
                        {{ __('Support Contact') }}
                    </div>
                    <div style="font-size: 11px; color: #9ca3af;">
                        {{ __('Contact info shown to users') }}
                    </div>
                </div>
            </div>
            <div class="setting-section-body">
                <div class="row g-3">

                    <div class="col-lg-6 setting-field">
                        <label>{{ __('Support Email') }}</label>
                        <input type="email" wire:model="support_email"
                            class="s-input @error('support_email') border-danger @enderror"
                            placeholder="support@company.com">
                        @error('support_email')
                            <div class="text-danger" style="font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                        @enderror
                        <div class="field-hint">{{ __('Notifications and replies sent from this email') }}</div>
                    </div>

                    <div class="col-lg-6 setting-field">
                        <label>{{ __('Support Phone') }}</label>
                        <input type="text" wire:model="support_phone"
                            class="s-input @error('support_phone') border-danger @enderror"
                            placeholder="+20 10 0000 0000">
                        @error('support_phone')
                            <div class="text-danger" style="font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                        @enderror
                        <div class="field-hint">{{ __('Displayed on the support portal') }}</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════ 3. Ticket Settings ══════ --}}
        <div class="setting-section">
            <div class="setting-section-header">
                <div class="section-icon bg-warning bg-opacity-10">
                    <i class="fa fa-ticket text-warning"></i>
                </div>
                <div>
                    <div style="font-size: 14px; font-weight: 700; color: #111827;">
                        {{ __('Ticket Settings') }}
                    </div>
                    <div style="font-size: 11px; color: #9ca3af;">
                        {{ __('Control ticket behavior and lifecycle') }}
                    </div>
                </div>
            </div>
            <div class="setting-section-body">

                <div class="toggle-wrap">
                    <div class="toggle-info">
                        <h6>{{ __('Allow Users to Delete Tickets') }}</h6>
                        <p>{{ __('Users can delete their own new tickets') }}</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" wire:model.live="allow_user_delete">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="toggle-wrap">
                    <div class="toggle-info">
                        <h6>{{ __('Auto-Close Inactive Tickets') }}</h6>
                        <p>{{ __('Automatically close tickets with no activity') }}</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" wire:model.live="auto_close">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                @if ($auto_close)
                    <div class="mt-3 setting-field" style="max-width: 280px;">
                        <label>{{ __('Auto-Close After (days)') }}</label>
                        <input type="number" wire:model="auto_close_days"
                            class="s-input" min="1" max="365">
                        <div class="field-hint">
                            {{ __('Tickets inactive for this many days will be closed') }}
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- ══════ 4. Maintenance ══════ --}}
        <div class="setting-section">
            <div class="setting-section-header">
                <div class="section-icon bg-danger bg-opacity-10">
                    <i class="fa fa-triangle-exclamation text-danger"></i>
                </div>
                <div>
                    <div style="font-size: 14px; font-weight: 700; color: #111827;">
                        {{ __('Maintenance') }}
                    </div>
                    <div style="font-size: 11px; color: #9ca3af;">
                        {{ __('System availability control') }}
                    </div>
                </div>
            </div>
            <div class="setting-section-body">

                <div class="toggle-wrap">
                    <div class="toggle-info">
                        <h6>{{ __('Maintenance Mode') }}</h6>
                        <p>{{ __('Block all users from accessing the system except admins') }}</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" wire:model.live="maintenance_mode">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

            </div>
        </div>

        {{-- ══════ Save Bar ══════ --}}
        <div class="save-bar">
            <div class="d-flex align-items-center justify-content-between">
                <p class="text-muted small mb-0">
                    <i class="fa fa-circle-info me-1 text-primary"></i>
                    {{ __('Changes will take effect immediately after saving') }}
                </p>
                <button wire:click="save" class="btn-save">
                    <span wire:loading.remove wire:target="save">
                        <i class="fa fa-floppy-disk"></i>
                        {{ __('Save Settings') }}
                    </span>
                    <span wire:loading wire:target="save">
                        <span class="spinner-border spinner-border-sm"></span>
                        {{ __('Saving...') }}
                    </span>
                </button>
            </div>
        </div>

    </div>
</div>
