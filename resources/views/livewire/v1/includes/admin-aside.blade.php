<aside class="left-sidebar">
    <div>
        {{-- ══════ Brand Logo ══════ --}}
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a class="text-nowrap">
                <img src="{{ asset('asset/images/cover.png') }}" alt="{{ config('app.name') }}" style="width: 12rem;" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        {{-- ══════ Navigation ══════ --}}
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                {{-- ── Dashboard ── --}}
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">{{ __('Home') }}</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" wire:navigate.hover>
                        <span>
                            <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">{{ __('Dashboard') }}</span>
                    </a>
                </li>

                {{-- ── Ticket Management ── --}}
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">{{ __('Ticket Management') }}</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('it.tickets.*') ? 'active' : '' }}" href="{{ route('it.tickets.index') }}" wire:navigate>
                        <span>
                            <iconify-icon icon="solar:ticket-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">{{ __('Tickets') }}</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('it.reports.*') ? 'active' : '' }}" href="{{ route('it.reports.feedback') }}" wire:navigate>
                        <span>
                            <iconify-icon icon="solar:star-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">{{ __('Feedback Reports') }}</span>
                    </a>
                </li>

                {{-- ── Hardware Management ── --}}
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">{{ __('Hardware Management') }}</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('hardware.assets.*') ? 'active' : '' }}" href="{{ route('hardware.assets.index') }}" wire:navigate>
                        <span>
                            <iconify-icon icon="solar:laptop-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">{{ __('Assets') }}</span>
                    </a>
                </li>

                {{-- ── Maintenance ── --}}
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">{{ __('Maintenance') }}</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('maintenance.invoices.*') ? 'active' : '' }}" href="{{ route('maintenance.invoices.index') }}" wire:navigate>
                        <span>
                            <iconify-icon icon="solar:wrench" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">{{ __('Maintenance Invoices') }}</span>
                    </a>
                </li>

                {{-- ── Settings ── --}}
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">{{ __('Settings') }}</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->is('settings/config*') ? 'active' : '' }}" href="{{ route('settings.config') }}" wire:navigate>
                        <span>
                            <iconify-icon icon="solar:settings-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">{{ __('Configurations') }}</span>
                    </a>
                </li>

            </ul>
        </nav>
        {{-- End Navigation --}}

    </div>
</aside>
