<div>
    <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>

            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                    {{-- ===================== NOTIFICATIONS ===================== --}}
                    <li class="nav-item">
                        <div class="dropdown" dir="ltr">
                            <a class="btn btn-dark position-relative" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-bell-ringing"></i>
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style="font-size: 0.5rem;">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow"
                                style="min-width: 300px; max-height: 400px; overflow-y: auto;">
                                <li class="dropdown-header border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>{{ __('Notifications') }}</span>
                                        @if (auth()->user()->unreadNotifications->count() > 0)
                                            <a href="#" wire:click="markAllAsRead" class="text-primary"
                                                style="text-decoration: none; font-size: 0.75rem;">
                                                {{ __('Read all') }}
                                            </a>
                                        @endif
                                    </div>
                                </li>

                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <li wire:key="notification-{{ $notification->id }}">
                                        <a class="dropdown-item py-2 border-bottom"
                                            href="{{ route('it.tickets.show', $notification->data['ticket_id']) }}">
                                            <div class="d-flex flex-column">
                                                <strong class="text-dark" style="font-size: 0.85rem;">
                                                    {{ $notification->data['title'] }}
                                                </strong>
                                                <span class="text-muted" style="font-size: 0.8rem;">
                                                    {{ $notification->data['user_name'] }}:
                                                    {{ Str::limit($notification->data['message'], 40) }}
                                                </span>
                                                <small class="text-primary" style="font-size: 0.7rem;">
                                                    <i class="ti ti-clock"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="p-3 text-center text-muted">
                                        <i class="ti ti-mail-opened d-block fs-4"></i>
                                        <small>{{ __('There are no new notifications') }}</small>
                                    </li>
                                @endforelse

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-center text-primary small" href="#">
                                        {{ __('Show all') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- ===================== USER MENU ===================== --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{-- <img src="{{ asset('asset/images/f.jpg') }}" alt=""
                            width="35" height="35" class="rounded-circle shadow"> --}}
                            <div style=" width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;"
                                class=" bg-success bg-opacity-50  text-dark">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                            <div class="message-body">
                                <a class="d-flex align-items-center gap-2 dropdown-item">
                                    <i class="ti ti-user fs-6"></i>
                                    <p class="mb-0 fs-3">{{ Auth::user()->name }}</p>
                                </a>
                                <a wire:click="logout" class="btn btn-outline-primary mx-3 mt-2 d-block">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>



</div>
