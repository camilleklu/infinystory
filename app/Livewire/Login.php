<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    #[Validate('required|email')]
    public $email;

    #[Validate('required')]
    public $password;

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            // En gros cela regarde la page ou tu était mais cela redirect home si il n'y a pas de page spécifique
            return redirect()->intended(route('home'));
        }
    }
    public function render()
    {
        return view('livewire.login');
    }
}
