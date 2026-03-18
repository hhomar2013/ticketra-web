<?php
namespace App\Livewire\V1\Includes;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    // ✅ شيلنا $listeners القديم خالص

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->to('/login');
    }
    #[On('markAllAsRead')]
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    #[On('refreshNotifications')] // ✅ Livewire 3 syntax
    public function render()
    {
        return view('livewire.v1.includes.header');
    }
}
