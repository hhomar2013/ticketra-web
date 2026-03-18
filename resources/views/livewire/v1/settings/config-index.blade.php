<div>
    <div class="p-3">

        <style>
            .settings-tab-btn {
                border: 1.5px solid #e5e7eb;
                border-radius: 12px;
                padding: 10px 18px;
                font-size: 13px;
                font-weight: 600;
                color: #6b7280;
                background: #fff;
                cursor: pointer;
                transition: all .2s;
                display: flex;
                align-items: center;
                gap: 8px;
                white-space: nowrap;
            }

            .settings-tab-btn:hover {
                border-color: #0d6efd;
                color: #0d6efd;
                background: rgba(13, 110, 253, .04);
            }

            .settings-tab-btn.active {
                background: linear-gradient(135deg, #0d6efd, #0047c4);
                border-color: transparent;
                color: #fff;
                box-shadow: 0 4px 14px rgba(13, 110, 253, .3);
            }

            .settings-tab-btn .tab-icon {
                width: 28px;
                height: 28px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 13px;
                flex-shrink: 0;
            }

            .settings-tab-btn.active .tab-icon {
                background: rgba(255, 255, 255, .2);
            }

            .settings-tab-btn:not(.active) .tab-icon {
                background: #f3f4f6;
                color: #6b7280;
            }

            .settings-tab-btn.active .tab-icon {
                color: #fff;
            }

            .settings-content {
                background: #fff;
                border-radius: 18px;
                border: 1px solid #e5e7eb;
                padding: 28px;
                min-height: 300px;
            }

        </style>

        {{-- ══════ Header ══════ --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <div style="width: 46px; height: 46px; border-radius: 14px;
                background: linear-gradient(135deg,#0d6efd,#0047c4);
                display: flex; align-items: center; justify-content: center; font-size: 20px;">
                ⚙️
            </div>
            <div>
                <h5 class="fw-bold mb-0">{{ __('System Configurations') }}</h5>
                <small class="text-muted">{{ __('Manage your system settings and preferences') }}</small>
            </div>
        </div>

        {{-- ══════ Tabs ══════ --}}
        <div class="d-flex flex-wrap gap-2 mb-4">

            <button wire:click.prevent="setPage('general')" class="settings-tab-btn {{ $page === 'general' ? 'active' : '' }}">
                <div class="tab-icon"><i class="fa-solid fa-earth-africa"></i></div>
                {{ __('General') }}
            </button>

            <button wire:click.prevent="setPage('branches')" class="settings-tab-btn {{ $page === 'branches' ? 'active' : '' }}">
                <div class="tab-icon"><i class="fa-solid fa-code-branch"></i></div>
                {{ __('Branches') }}
            </button>

            <button wire:click.prevent="setPage('asset-categories')" class="settings-tab-btn {{ $page === 'asset-categories' ? 'active' : '' }}">
                <div class="tab-icon"><i class="fa-solid fa-layer-group"></i></div>
                {{ __('Asset Categories') }}
            </button>

            <button wire:click.prevent="setPage('brands')" class="settings-tab-btn {{ $page === 'brands' ? 'active' : '' }}">
                <div class="tab-icon"><i class="fa-solid fa-layer-group"></i></div>
                {{ __('Brands') }}
            </button>

        </div>


        <div class="settings-content shadow-sm">
            @switch($page)
            @case('general')
            @livewire('v1.settings.config-general')
            @break

            @case('branches')
            @livewire('v1.hardware.branch.branch-index')
            @break

            @case('brands')
            @livewire('v1.hardware.brands.brands-index')
            @break

            @case('asset-categories')
            @livewire('v1.hardware.asset-categories.asset-categories-index')
            @break


            @default
            <div class="text-center text-muted py-5">
                <i class="fa fa-gear fa-3x d-block mb-3 opacity-25"></i>
                <p>{{ __('Select a setting from the tabs above') }}</p>
            </div>
            @endswitch
        </div>

    </div>
</div>
