<?php
namespace App\Livewire\V1\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    #[Layout('layouts.guest')]
    public $email = '';
    public $password = '';
    public $remember = false;

    public function updated($property)
    {
        $this->validateOnly($property, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }

    public function login()
    {
        // dd($this->email, $this->password, $this->remember);
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (
            Auth::attempt([
                'email' => $this->email,
                'password' => $this->password,
            ], $this->remember)
        ) {

            session()->regenerate();
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->intended('/dashboard');
            } else {
                return redirect()->intended('/founders/dashboard');
            }

        } else {
            $this->addError('email', __('Invalid login credentials.'));
        }

    }

    public function render()
    {
        return view('livewire.v1.auth.login');
    }
}
