<div>
    @push('styles')
    <style>
        .filter-btn {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 7px 14px;
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            background: #fff;
            cursor: pointer;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .filter-btn:hover {
            border-color: #0d6efd;
            color: #0d6efd;
            background: rgba(13, 110, 253, .04);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #0d6efd, #0047c4);
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 12px rgba(13, 110, 253, .25);
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap .s-ico {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 13px;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px 14px 10px 38px;
            font-size: 14px;
            color: #111827;
            background: #fafafa;
            transition: all .2s;
            outline: none;
        }

        .search-input:focus {
            border-color: #0d6efd;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, .08);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .table-wrap {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: visible;
        }

        .action-drop .dropdown-menu {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
            padding: 6px;
            min-width: 160px;
            z-index: 9999;
        }

        .action-drop .dropdown-item {
            font-size: 13px;
            padding: 8px 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-drop .dropdown-item:hover {
            background: #f3f4f6;
        }

    </style>
    @endpush

    {{-- ══════ Header ══════ --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h6 class="fw-bold mb-0">{{ __('Users') }}</h6>
            <small class="text-muted">{{ __('Manage system users and their roles') }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('user-management.roles') }}" wire:navigate class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold" style="font-size: 13px;">
                <i class="fa fa-shield-halved me-1"></i> {{ __('Roles & Permissions') }}
            </a>
            <a href="{{ route('user-management.create') }}" wire:navigate class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                <i class="fas fa-plus me-1"></i> {{ __('Add User') }}
            </a>
        </div>
    </div>

    {{-- ══════ Filters ══════ --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div class="d-flex flex-wrap gap-2">
            <button wire:click="$set('roleFilter', '')" class="filter-btn {{ $roleFilter === '' ? 'active' : '' }}">
                <i class="fa fa-users" style="font-size: 11px;"></i> {{ __('All') }}
            </button>
            @foreach($roles as $role)
            <button wire:click="$set('roleFilter', '{{ $role->name }}')" class="filter-btn {{ $roleFilter === $role->name ? 'active' : '' }}">
                {{ ucfirst($role->name) }}
            </button>
            @endforeach
        </div>
        <div class="d-flex align-items-center gap-2">
            <select wire:model.change="perPage" class="filter-btn" style="border-radius: 10px;">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <div class="search-wrap" style="min-width: 240px;">
                <i class="fa fa-search s-ico"></i>
                <input type="text" wire:model.live.debounce.400ms="search" class="search-input" placeholder="{{ __('Search by name or email...') }}">
            </div>
        </div>
    </div>

    {{-- ══════ Table ══════ --}}
    @if($users->count())
    <div class="table-wrap shadow-sm">
        <table class="table table-hover align-middle mb-0">
            <thead style="background: #f9fafb;">
                <tr>
                    <th class="ps-4 py-3 text-muted small" style="width: 55px;">#</th>
                    <th class="py-3 text-muted small">{{ __('User') }}</th>
                    <th class="py-3 text-muted small">{{ __('Email') }}</th>
                    <th class="py-3 text-muted small">{{ __('Role') }}</th>
                    <th class="py-3 text-muted small">{{ __('Status') }}</th>
                    <th class="py-3 text-muted small">{{ __('Joined') }}</th>
                    <th class="py-3 pe-4 text-muted small text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                <tr>
                    <td class="ps-4">
                        <span class="badge bg-light text-muted border" style="font-size: 11px;">
                            {{ $users->firstItem() + $key }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @php
                            $parts = explode(' ', $user->name);
                            $ini = strtoupper(substr($parts[0],0,1) . (isset($parts[1]) ? substr($parts[1],0,1) : substr($parts[0],1,1)));
                            $colors = ['rgba(13,110,253,.15)', 'rgba(25,135,84,.15)', 'rgba(255,193,7,.2)', 'rgba(220,53,69,.15)', 'rgba(111,66,193,.15)'];
                            $color = $colors[$user->id % count($colors)];
                            @endphp
                            <div class="user-avatar" style="background: {{ $color }}; color: #111827;">
                                {{ $ini }}
                            </div>
                            <div>
                                <div class="fw-bold small">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                <span style="font-size: 10px; color: #0d6efd; font-weight: 700;">{{ __('You') }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="text-muted small">{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                        <span style="background: rgba(13,110,253,.08); color: #0d6efd;
                                    border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                            {{ $role->name }}
                        </span>
                        @endforeach
                        @if($user->roles->isEmpty())
                        <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>
                        @if($user->status ?? true)
                        <span style="background:#d1e7dd;color:#0f5132;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:700;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#198754;display:inline-block;margin-right:4px;"></span>
                            {{ __('Active') }}
                        </span>
                        @else
                        <span style="background:#e2e3e5;color:#41464b;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:700;">
                            {{ __('Inactive') }}
                        </span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="pe-4 text-end action-drop">
                        <div class="dropdown {{ $loop->remaining < 2 ? 'dropup' : '' }}">
                            <button class="btn btn-sm rounded-pill px-3" style="background:#f3f4f6;border:1px solid #e5e7eb;color:#374151;" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user-management.edit', $user->id) }}" wire:navigate>
                                        <i class="fas fa-edit text-primary"></i> {{ __('Edit') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user-management.roles') }}?user={{ $user->id }}" wire:navigate>
                                        <i class="fa fa-shield-halved text-warning"></i> {{ __('Roles') }}
                                    </a>
                                </li>
                                <li>
                                    <button class="dropdown-item" wire:click="toggleActive({{ $user->id }})">
                                        @if($user->status ?? true)
                                        <i class="fa fa-ban text-warning"></i> {{ __('Deactivate') }}
                                        @else
                                        <i class="fa fa-check-circle text-success"></i> {{ __('Activate') }}
                                        @endif
                                    </button>
                                </li>
                                @if($user->id !== auth()->id())
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <button class="dropdown-item" onclick="confirmDelete({{ $user->id }}, 'delete-user')">
                                        <i class="fas fa-trash text-danger"></i> {{ __('Delete') }}
                                    </button>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex justify-content-end">
        {{ $users->links() }}
    </div>
    @else
    <div class="text-center py-5 text-muted">
        <div style="font-size: 48px; margin-bottom: 12px;">👥</div>
        <h6 class="fw-bold text-dark mb-1">{{ __('No users found') }}</h6>
        <p class="small mb-3">{{ __('Add your first user to get started') }}</p>
        <a href="{{ route('user-management.create') }}" wire:navigate class="btn btn-primary btn-sm rounded-pill px-4">
            <i class="fas fa-plus me-1"></i> {{ __('Add User') }}
        </a>
    </div>
    @endif

</div>

@push('js')
<script src="{{ asset('assets/js/confirmDelete.js') }}"></script>
@endpush
