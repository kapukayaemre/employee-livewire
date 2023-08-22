<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;

class UserIndex extends Component
{
    public function render()
    {
        return view('livewire.users.user-index')->layout("layouts.main");
    }
}
