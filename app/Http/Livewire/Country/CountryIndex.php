<?php

namespace App\Http\Livewire\Country;

use App\Models\Country;
use Livewire\Component;

class CountryIndex extends Component
{
    public $search = "";
    public $countryCode;
    public $name;
    public $editMode = false;

    public function showEditModal($id)
    {

    }

    public function deleteCountry($id)
    {

    }

    public function closeModal()
    {

    }

    public function storeCountry()
    {

    }

    public function updateCountry()
    {

    }


    public function render()
    {
        return view('livewire.country.country-index', [
            'countries' => Country::paginate(5)
        ])->layout("layouts.main");
    }
}
