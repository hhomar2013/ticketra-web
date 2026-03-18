<?php
namespace App\Livewire\V1\UsersManagement;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersRoleAndPermissions extends Component
{
                                  // ── Tabs ──
    public string $tab = 'roles'; // roles | permissions

    // ── Roles ──
    public string $roleName       = '';
    public ?int $editRoleId       = null;
    public array $rolePermissions = [];

    // ── Permissions ──
    public string $permissionName  = '';
    public string $permissionGroup = '';
    public ?int $editPermissionId  = null;

    // ── Assign Role to User ──
    public ?int $assignUserId = null;
    public string $assignRole = '';

    public function saveRole(): void
    {
        $this->validate(['roleName' => 'required|string|max:60']);

        if ($this->editRoleId) {
            $role = Role::findOrFail($this->editRoleId);
            $role->update(['name' => $this->roleName]);
            $role->syncPermissions($this->rolePermissions);
        } else {
            $role = Role::create(['name' => $this->roleName, 'guard_name' => 'web']);
            $role->syncPermissions($this->rolePermissions);
        }

        $this->reset(['roleName', 'editRoleId', 'rolePermissions']);
        $this->dispatch('show-toast', ['message' => __('Role saved successfully'), 'type' => 'success']);
    }

    public function editRole(int $id): void
    {
        $role                  = Role::with('permissions')->findOrFail($id);
        $this->editRoleId      = $id;
        $this->roleName        = $role->name;
        $this->rolePermissions = $role->permissions->pluck('name')->toArray();
    }

    public function deleteRole(int $id): void
    {
        Role::findOrFail($id)->delete();
        $this->dispatch('show-toast', ['message' => __('Role deleted'), 'type' => 'success']);
    }

    public function savePermission(): void
    {
        $this->validate(['permissionName' => 'required|string|max:100']);

        if ($this->editPermissionId) {
            Permission::findOrFail($this->editPermissionId)->update([
                'name' => $this->permissionName,
            ]);
        } else {
            Permission::create([
                'name'       => $this->permissionName,
                'guard_name' => 'web',
            ]);
        }

        $this->reset(['permissionName', 'permissionGroup', 'editPermissionId']);
        $this->dispatch('show-toast', ['message' => __('Permission saved successfully'), 'type' => 'success']);
    }

    public function editPermission(int $id): void
    {
        $perm                   = Permission::findOrFail($id);
        $this->editPermissionId = $id;
        $this->permissionName   = $perm->name;
    }

    public function deletePermission(int $id): void
    {
        Permission::findOrFail($id)->delete();
        $this->dispatch('show-toast', ['message' => __('Permission deleted'), 'type' => 'success']);
    }

    public function assignRoleToUser(): void
    {
        $this->validate([
            'assignUserId' => 'required|exists:users,id',
            'assignRole'   => 'required|exists:roles,name',
        ]);

        User::findOrFail($this->assignUserId)->syncRoles([$this->assignRole]);
        $this->reset(['assignUserId', 'assignRole']);
        $this->dispatch('show-toast', ['message' => __('Role assigned successfully'), 'type' => 'success']);
    }

    public function render()
    {

        $roles = Role::with(['permissions', 'users'])->get();

        $permissions = Permission::orderBy('name')->get();
        $users       = User::with('roles')->latest()->get();

        return view('livewire.v1.users-management.users-role-and-permissions',
            compact('roles', 'permissions', 'users'));
    }
}
