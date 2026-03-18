<aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a class="text-nowrap">
                    <img src="{{ asset('asset/images/cover.png') }}" alt="" class="text-center" style="width: 12rem;" />
                </a>
                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8"></i>
                </div>
            </div>
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                        <span class="hide-menu">{{ __('Home') }} - Users</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('user.dashboard') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                        <span class="hide-menu">{{ __('Tickets') }}</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('tickets.create') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">{{ __('New Ticket') }}</span>
                        </a>
                    </li>
               
                </ul>

            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
