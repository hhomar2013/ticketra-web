<div>
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
        }

        .panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
        }

        .panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-body {
            padding: 20px;
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
            padding: 10px 14px 10px 40px;
            font-size: 14px;
            color: #111827;
            background: #fafafa;
            transition: all .2s;
            outline: none;
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

        .btn-save {
            background: linear-gradient(135deg, #0d6efd, #0047c4);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 24px;
            cursor: pointer;
            transition: transform .15s, box-shadow .2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, .3);
        }

        .perm-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            color: #374151;
            transition: background .15s;
        }

        .perm-checkbox:hover {
            background: #f3f4f6;
        }

        .perm-checkbox input {
            width: 15px;
            height: 15px;
            accent-color: #0d6efd;
            cursor: pointer;
        }

        .item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f9fafb;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-row .item-name {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }

        .item-row .item-meta {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 2px;
        }

        .item-actions {
            display: flex;
            gap: 6px;
        }

        .btn-edit-sm {
            background: rgba(13, 110, 253, .08);
            color: #0d6efd;
            border: 1px solid rgba(13, 110, 253, .15);
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-edit-sm:hover {
            background: rgba(13, 110, 253, .15);
        }

        .btn-del-sm {
            background: rgba(220, 53, 69, .08);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, .15);
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-del-sm:hover {
            background: rgba(220, 53, 69, .15);
        }

        .user-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f9fafb;
        }

        .user-row:last-child {
            border-bottom: none;
        }

        .user-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(13, 110, 253, .1);
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

    </style>

    {{-- ══════ Header ══════ --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h6 class="fw-bold mb-0">{{ __('Roles & Permissions') }}</h6>
            <small class="text-muted">{{ __('Manage system access control') }}</small>
        </div>
        <a href="{{ route('user-management.index') }}" wire:navigate class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold" style="font-size:13px;">
            <i class="fa fa-arrow-left me-1"></i> {{ __('Back to Users') }}
        </a>
    </div>

    {{-- ══════ Tabs ══════ --}}
    <div class="d-flex flex-wrap gap-2 mb-4">
        <button wire:click="$set('tab','roles')" class="settings-tab-btn {{ $tab === 'roles' ? 'active' : '' }}">
            <div class="tab-icon"><i class="fa fa-shield-halved"></i></div>
            {{ __('Roles') }}
            <span class="badge rounded-pill ms-1 {{ $tab === 'roles' ? 'bg-white text-primary' : 'bg-primary-subtle text-primary' }}" style="font-size:10px;">{{ $roles->count() }}</span>
        </button>
        <button wire:click="$set('tab','permissions')" class="settings-tab-btn {{ $tab === 'permissions' ? 'active' : '' }}">
            <div class="tab-icon"><i class="fa fa-key"></i></div>
            {{ __('Permissions') }}
            <span class="badge rounded-pill ms-1 {{ $tab === 'permissions' ? 'bg-white text-primary' : 'bg-primary-subtle text-primary' }}" style="font-size:10px;">{{ $permissions->count() }}</span>
        </button>
        <button wire:click="$set('tab','assign')" class="settings-tab-btn {{ $tab === 'assign' ? 'active' : '' }}">
            <div class="tab-icon"><i class="fa fa-user-shield"></i></div>
            {{ __('Assign Roles') }}
        </button>
    </div>

    {{-- ══════ ROLES TAB ══════ --}}
    @if($tab === 'roles')
    <div class="row g-3">

        {{-- Add/Edit Role --}}
        <div class="col-lg-5">
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <div>
                        <div class="fw-bold small">{{ $editRoleId ? __('Edit Role') : __('Add New Role') }}</div>
                        <div class="text-muted" style="font-size:11px;">{{ __('Define role name and permissions') }}</div>
                    </div>
                    @if($editRoleId)
                    <button wire:click="$set('editRoleId', null)" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size:11px;">
                        {{ __('Cancel') }}
                    </button>
                    @endif
                </div>
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="f-lbl">{{ __('Role Name') }}</label>
                        <div class="f-wrap">
                            <i class="fa fa-shield-halved f-ico"></i>
                            <input type="text" wire:model="roleName" class="f-input @error('roleName') is-invalid @enderror" placeholder="{{ __('e.g. supervisor, it, user') }}">
                        </div>
                        @error('roleName') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>

                    {{-- Permissions Checkboxes --}}
                    <div class="mb-3">
                        <label class="f-lbl">{{ __('Assign Permissions') }}</label>
                        <div class="border rounded-3 p-2" style="max-height: 200px; overflow-y: auto;">
                            @forelse($permissions as $perm)
                            <label class="perm-checkbox">
                                <input type="checkbox" wire:model="rolePermissions" value="{{ $perm->name }}">
                                {{ $perm->name }}
                            </label>
                            @empty
                            <p class="text-muted small text-center py-2 mb-0">{{ __('No permissions yet') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <button wire:click="saveRole" class="btn-save w-100 justify-content-center">
                        <span wire:loading.remove wire:target="saveRole">
                            <i class="fa {{ $editRoleId ? 'fa-floppy-disk' : 'fa-plus' }}"></i>
                            {{ $editRoleId ? __('Update Role') : __('Create Role') }}
                        </span>
                        <span wire:loading wire:target="saveRole">
                            <span class="spinner-border spinner-border-sm"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Roles List --}}
        <div class="col-lg-7">
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <div class="fw-bold small">{{ __('All Roles') }}</div>
                    <span class="badge rounded-pill px-3" style="background:rgba(13,110,253,.1);color:#0d6efd;font-size:11px;">
                        {{ $roles->count() }} {{ __('roles') }}
                    </span>
                </div>
                <div class="panel-body">
                    @forelse($roles as $role)
                    <div class="item-row">
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:32px;height:32px;border-radius:9px;background:rgba(13,110,253,.1);display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-shield-halved text-primary" style="font-size:13px;"></i>
                                </div>
                                <div>
                                    <div class="item-name">{{ ucfirst($role->name) }}</div>
                                    <div class="item-meta">
                                        {{ $role->users_count ?? 0 }} {{ __('users') }} •
                                        {{ $role->permissions->count() }} {{ __('permissions') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item-actions">
                            <button wire:click="editRole({{ $role->id }})" class="btn-edit-sm">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button wire:click="deleteRole({{ $role->id }})" wire:confirm="{{ __('Delete this role?') }}" class="btn-del-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <div style="font-size:36px;margin-bottom:8px;">🛡️</div>
                        <p class="small mb-0">{{ __('No roles yet') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
    @endif

    {{-- ══════ PERMISSIONS TAB ══════ --}}
    @if($tab === 'permissions')
    <div class="row g-3">

        {{-- Add Permission --}}
        <div class="col-lg-4">
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <div>
                        <div class="fw-bold small">{{ $editPermissionId ? __('Edit Permission') : __('Add Permission') }}</div>
                        <div class="text-muted" style="font-size:11px;">{{ __('e.g. manage tickets, view reports') }}</div>
                    </div>
                    @if($editPermissionId)
                    <button wire:click="$set('editPermissionId', null)" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size:11px;">{{ __('Cancel') }}</button>
                    @endif
                </div>
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="f-lbl">{{ __('Permission Name') }}</label>
                        <div class="f-wrap">
                            <i class="fa fa-key f-ico"></i>
                            <input type="text" wire:model="permissionName" class="f-input @error('permissionName') is-invalid @enderror" placeholder="{{ __('e.g. manage tickets') }}">
                        </div>
                        @error('permissionName') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>
                    <button wire:click="savePermission" class="btn-save w-100 justify-content-center">
                        <span wire:loading.remove wire:target="savePermission">
                            <i class="fa {{ $editPermissionId ? 'fa-floppy-disk' : 'fa-plus' }}"></i>
                            {{ $editPermissionId ? __('Update') : __('Add Permission') }}
                        </span>
                        <span wire:loading wire:target="savePermission">
                            <span class="spinner-border spinner-border-sm"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Permissions List --}}
        <div class="col-lg-8">
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <div class="fw-bold small">{{ __('All Permissions') }}</div>
                    <span class="badge rounded-pill px-3" style="background:rgba(13,110,253,.1);color:#0d6efd;font-size:11px;">
                        {{ $permissions->count() }} {{ __('permissions') }}
                    </span>
                </div>
                <div class="panel-body" style="max-height:400px;overflow-y:auto;">
                    @forelse($permissions as $perm)
                    <div class="item-row">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:30px;height:30px;border-radius:8px;background:rgba(111,66,193,.1);display:flex;align-items:center;justify-content:center;">
                                <i class="fa fa-key" style="font-size:12px;color:#6f42c1;"></i>
                            </div>
                            <div class="item-name">{{ $perm->name }}</div>
                        </div>
                        <div class="item-actions">
                            <button wire:click="editPermission({{ $perm->id }})" class="btn-edit-sm">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button wire:click="deletePermission({{ $perm->id }})" wire:confirm="{{ __('Delete this permission?') }}" class="btn-del-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <div style="font-size:36px;margin-bottom:8px;">🔑</div>
                        <p class="small mb-0">{{ __('No permissions yet') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
    @endif

    {{-- ══════ ASSIGN ROLES TAB ══════ --}}
    @if($tab === 'assign')
    <div class="row g-3">

        {{-- Assign Form --}}
        <div class="col-lg-4">
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <div>
                        <div class="fw-bold small">{{ __('Assign Role to User') }}</div>
                        <div class="text-muted" style="font-size:11px;">{{ __('Override user role instantly') }}</div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="f-lbl">{{ __('User') }}</label>
                        <div class="f-wrap">
                            <i class="fa fa-user f-ico"></i>
                            <select wire:model.live="assignUserId" class="f-input @error('assignUserId') is-invalid @enderror">
                                <option value="">{{ __('Select User') }}</option>
                                @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('assignUserId') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="f-lbl">{{ __('Role') }}</label>
                        <div class="f-wrap">
                            <i class="fa fa-shield-halved f-ico"></i>
                            <select wire:model="assignRole" class="f-input @error('assignRole') is-invalid @enderror">
                                <option value="">{{ __('Select Role') }}</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('assignRole') <div class="f-err"><i class="fa fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>
                    <button wire:click="assignRoleToUser" class="btn-save w-100 justify-content-center">
                        <span wire:loading.remove wire:target="assignRoleToUser">
                            <i class="fa fa-user-shield"></i> {{ __('Assign Role') }}
                        </span>
                        <span wire:loading wire:target="assignRoleToUser">
                            <span class="spinner-border spinner-border-sm"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Users + Roles List --}}
        <div class="col-lg-8">
            <div class="panel shadow-sm">
                <div class="panel-header">
                    <div class="fw-bold small">{{ __('Users & Their Roles') }}</div>
                    <span class="badge rounded-pill px-3" style="background:rgba(13,110,253,.1);color:#0d6efd;font-size:11px;">
                        {{ $users->count() }} {{ __('users') }}
                    </span>
                </div>
                <div class="panel-body" style="max-height: 400px; overflow-y: auto;">
                    @foreach($users as $u)
                    @php
                    $up = explode(' ', $u->name);
                    $ui = strtoupper(substr($up[0],0,1).(isset($up[1])?substr($up[1],0,1):substr($up[0],1,1)));
                    @endphp
                    <div class="user-row">
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar-sm">{{ $ui }}</div>
                            <div>
                                <div class="fw-bold small">{{ $u->name }}</div>
                                <div class="text-muted" style="font-size:11px;">{{ $u->email }}</div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-1">
                            @forelse($u->roles as $r)
                            <span style="background:rgba(13,110,253,.08);color:#0d6efd;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:700;">
                                {{ $r->name }}
                            </span>
                            @empty
                            <span class="text-muted small">{{ __('No role') }}</span>
                            @endforelse
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
    @endif

</div>
