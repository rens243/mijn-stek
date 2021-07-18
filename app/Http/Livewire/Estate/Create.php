<?php

namespace App\Http\Livewire\Estate;

use App\Http\Controllers\EstateController;
use App\Models\House\Estate;
use App\Http\Requests\Estate as EstateRequest;
use Livewire\Component;

class Create extends Component
{
    public Estate $estate;

    protected EstateRequest $formRequest;

    public function mount() {
        $this->estate = new Estate;
    }

    public function rules()
    {
        if (!isset($this->formRequest)) {
            $this->formRequest = new EstateRequest();
            $this->formRequest->actionIsCreate();
        }
        return $this->formRequest->rules();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();

        // Stupid null checkbox
        $this->estate->active = (bool)$this->estate->active;

        if (!$this->estate->save()) {
            // flash error
            $this->emit('alert', 'Estate could saved.');
            return null;
        }

        $this->emit('alert', 'Estate succesfully added.');
        return redirect(action([EstateController::class, 'edit'], $this->estate->id));
    }

    public function render()
    {
        return view('livewire.estate.create');
    }
}
