<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;
    public $search = "";
    public $username;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $userId;
    public $editMode = false;

    protected $rules = [
        "username"  => "required",
        "firstName" => "required",
        "lastName"  => "required",
        "email"     => "required",
        "password"  => "required",
    ];

    public function storeUser()
    {
        $this->validate();

        User::create([
            "username"   => $this->username,
            "first_name" => $this->firstName,
            "last_name"  => $this->lastName,
            "email"      => $this->email,
            "password"   => Hash::make($this->password)
        ]);
        $this->reset();
        $this->dispatchBrowserEvent("closeModal");

        session()->flash("user-message", "User successfully created");
    }

    public function showEditModal($id)
    {
        $this->reset();
        $this->editMode = true;
        /*** Find User */
        $this->userId = $id;
        /*** Load User */
        $this->loadUser();
        /*** Show Modal */
        $this->dispatchBrowserEvent("showModal");
    }

    public function loadUser()
    {
        $user            = User::find($this->userId);
        $this->username  = $user->username;
        $this->firstName = $user->first_name;
        $this->lastName  = $user->last_name;
        $this->email     = $user->email;
    }

    public function updateUser()
    {
        $validated = $this->validate([
            "username"  => "required",
            "firstName" => "required",
            "lastName"  => "required",
            "email"     => "required"
        ]);

        $user = User::find($this->userId);
        $user->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent("closeModal");
        session()->flash("user-message", "User successfully updated");
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        session()->flash("user-message", "User successfully deleted");
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent("closeModal");
        $this->reset();
    }

    public function render()
    {
        $users = User::paginate(5);
        if (strlen($this->search) > 2) {
            $users = User::where("username", 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.users.user-index', ["users" => $users])->layout("layouts.main");
    }
}
