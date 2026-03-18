<?php
namespace App\Livewire\V1\UsersManagement;

use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;

    public string $search     = '';
    public string $roleFilter = '';
    public int $perPage       = 10;

    public function updatingSearch(): void
    {$this->resetPage();}
    public function updatingRoleFilter(): void
    {$this->resetPage();}

    public function deleteUser(int $id): void
    {
        $user = User::findOrFail($id);

        // ✅ منع حذف نفسه
        if ($user->id === FacadesAuth::id()) {
            $this->dispatch('show-toast', ['message' => __('You cannot delete yourself'), 'type' => 'error']);
            return;
        }

        $user->delete();
        $this->dispatch('show-toast', ['message' => __('User deleted successfully'), 'type' => 'success']);
    }


    public function toggleActive(int $id): void
    {
        $user = User::findOrFail($id);
        $user->update(['status' => ! $user->status]);
        $this->dispatch('show-toast', [
            'message' => $user->status ? __('User activated') : __('User deactivated'),
            'type'    => 'success',
        ]);
    }

    #[On('refreshUsers')]
    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
            )
            ->when($this->roleFilter, fn($q) =>
                $q->role($this->roleFilter)
            )
            ->latest()
            ->paginate($this->perPage);

        $roles = \Spatie\Permission\Models\Role::all();

        return view('livewire.v1.users-management.users-index', compact('users', 'roles'));
    }
}
