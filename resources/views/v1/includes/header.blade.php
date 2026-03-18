<div wire:poll.15s="checkNewNotifications">

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
                    <li class="nav-item">
                        <div class="dropdown" wire:poll.15s dir="ltr"> {{-- تحديث كل 15 ثانية لجلب الإشعارات الجديدة --}}
                            <a class="btn btn-dark position-relative" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-bell-ringing"></i>

                                {{-- الـ Badge يظهر فقط إذا كان هناك إشعارات غير مقروءة --}}
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style="font-size: 0.5rem;">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow"
                                style="min-width: 300px; max-height: 400px; overflow-y: auto;">
                                <li class="dropdown-header border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>{{ __('الإشعارات') }}</span>
                                        @if (auth()->user()->unreadNotifications->count() > 0)
                                            <a href="#" wire:click.prevent="markAllAsRead"
                                                class="text-xs text-primary"
                                                style="text-decoration: none; font-size: 0.75rem;">تعيين كقراءة</a>
                                        @endif
                                    </div>
                                </li>

                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <li>
                                        {{-- الرابط يوجه لصفحة التذكرة بناءً على الـ ID المخزن في الإشعار --}}
                                        <a class="dropdown-item py-2 border-bottom"
                                            href="{{ route('user.tickets.show', $notification->data['ticket_id']) }}">
                                            <div class="d-flex flex-column">
                                                <strong
                                                    class="text-sm text-dark">{{ $notification->data['title'] }}</strong>
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
                                        <small>لا توجد إشعارات جديدة</small>
                                    </li>
                                @endforelse

                                {{-- خيار لرؤية كل الإشعارات إذا أردت --}}
                                {{-- <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-center text-primary small" href="#">عرض الكل</a></li>               --}}
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('asset/images/f.jpg') }}" alt="" width="35" height="35"
                                class="rounded-circle shadow">
                        </a>

                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                            <div class="message-body">
                                <a class="d-flex align-items-center gap-2 dropdown-item text-center">
                                    <i class="ti ti-user fs-6"></i>
                                    <p class="mb-0 fs-3 ">{{ Auth::user()->name }}</p>
                                </a>
                                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                    <i class="ti ti-mail fs-6"></i>
                                    <p class="mb-0 fs-3">My Account</p>
                                </a>
                                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                    <i class="ti ti-list-check fs-6"></i>
                                    <p class="mb-0 fs-3">My Task</p>
                                </a>
                                <a wire:click="logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

</div>
