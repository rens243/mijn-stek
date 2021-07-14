<?php

namespace App\Http\Livewire\Estate;

use App\Http\Controllers\EstateController;
use App\Models\House\Estate;
use Livewire\Component;

class Create extends Component
{
    public Estate $estate;

    protected $rules = [
        'estate.name' => 'required|string|min:6',
        'estate.url' => 'required|string|url',
        'estate.selector_all' => 'required|string',
        'estate.selector_name' => 'required|string',
        'estate.selector_each' => 'required|string',
        'estate.selector_photo' => 'required|string',
        'estate.selector_price' => 'required|string',
        'estate.selector_link'=> 'required|string',
        'estate.selector_description' => 'required|string',
    ];

    public function mount() {
        $this->estate = new Estate;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();

        if (!$this->estate->save()) {
            // flash error
            session()->flash('message', 'Estate could saved.');
            return null;
        }

        session()->flash('message', 'Estate succesfully added.');
        return redirect(action([EstateController::class, 'edit'], $this->estate->id));
    }

    public function render()
    {
        return view('livewire.estate.create');
    }
}
