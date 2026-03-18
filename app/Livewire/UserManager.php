<?php
namespace App\Livewire;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserManager extends Component
{

    public $name, $email, $password, $role, $categories, $category_id;
    public $users, $roles, $searchRole;
    public $editingUserId;

    public function mount()
    {
        $this->categories = Category::all();
        $this->roles      = Role::all();
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $query = User::with('roles');
        if ($this->searchRole) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', $this->searchRole);
            });
        }
        $this->users = $query->get();
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'role', 'category_id', 'editingUserId']);
        $this->loadUsers();
    }
    public function createUser()
    {
        $this->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|exists:roles,name',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
            'category_id' => $this->category_id,
        ]);

        $user->assignRole($this->role);

        session()->flash('message', 'User created successfully');
        $this->reset(['name', 'email', 'password', 'role', 'category_id']);
        $this->loadUsers();
    }

    public function editUser($id)
    {
        $user                = User::findOrFail($id);
        $this->editingUserId = $id;
        $this->name          = $user->name;
        $this->email         = $user->email;
        $this->role          = $user->roles->pluck('name')->first();
        $this->category_id   = $user->category_id;
    }

    public function updateUser()
    {
        $this->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $this->editingUserId,
            'role'  => 'required|exists:roles,name',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $user = User::findOrFail($this->editingUserId);
        $user->update([
            'name'  => $this->name,
            'email' => $this->email,
            'category_id' => $this->category_id,
        ]);

        $user->syncRoles([$this->role]);

        session()->flash('message', 'User updated successfully');
        $this->reset(['name', 'email', 'password', 'role', 'editingUserId', 'category_id']);
        $this->loadUsers();
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User deleted successfully');
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.user-manager');
    }
}
