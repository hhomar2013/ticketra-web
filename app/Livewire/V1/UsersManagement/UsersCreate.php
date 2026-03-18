<?php
namespace App\Livewire\V1\UsersManagement;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UsersCreate extends Component
{
    public ?int $userId = null;
    public bool $IsEdit = false;

    public string $name     = '';
    public string $email    = '';
    public string $password = '';
    public string $role     = '';
    public bool $is_active  = true;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $user            = User::findOrFail($id);
            $this->userId    = $id;
            $this->IsEdit    = true;
            $this->name      = $user->name;
            $this->email     = $user->email;
            $this->role      = $user->roles->first()?->name ?? '';
            $this->is_active = $user->status ?? true;
        }
    }

    public function save()
    {
        $rules = [
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email' . ($this->userId ? ',' . $this->userId : ''),
            'role'  => 'required|string|exists:roles,name',
        ];

        if (! $this->IsEdit) {
            $rules['password'] = 'required|min:8';
        }

        $this->validate($rules);

        if ($this->IsEdit) {
            $user = User::findOrFail($this->userId);
            $user->update([
                'name'   => $this->name,
                'email'  => $this->email,
                'status' => $this->is_active,
            ]);
            if ($this->password) {
                $user->update(['password' => Hash::make($this->password)]);
            }
        } else {
            $user = User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => Hash::make($this->password),
                'status'   => $this->is_active,
            ]);
        }

        $user->syncRoles([$this->role]);

        $this->dispatch('show-toast', [
            'message' => $this->IsEdit ? __('User updated successfully') : __('User created successfully'),
            'type'    => 'success',
        ]);

        return redirect()->route('user-management.index');
    }

    public function render()
    {
        $roles = Role::all();
        return view('livewire.v1.users-management.users-create', compact('roles'));
    }
}
