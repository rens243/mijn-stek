<?php

namespace App\Http\Livewire\Estate;

use App\Http\Controllers\EstateController;
use App\Http\Requests\Estate as EstateRequest;
use App\Models\House\Estate;
use Livewire\Component;

class Edit extends Component
{
    public Estate $estate;

    protected EstateRequest $formRequest;

    public function rules()
    {
        if (!isset($this->formRequest)) {
            $this->formRequest = new EstateRequest();
            $this->formRequest->actionIsEdit();
        }
        return $this->formRequest->rules();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Test if estate is working
     */
    public function test()
    {
        $exitCode = \Artisan::call('house:scrape', [
            'estate' => $this->estate->id,
            '--no-save' => true
        ]);

        if ($exitCode !== 1) {
            $this->emit('alert', 'Command successful.');
            return;
        }

        $this->emit('alert', 'Command did not run successfully.');
    }

    public function update()
    {
        $this->validate();

        if (!$this->estate->save()) {
            // flash error
            session()->flash('message', 'Could not update.');
            return null;
        }

        session()->flash('message', 'Estate succesfully updated.');
        return redirect(action([EstateController::class, 'edit'], $this->estate->id));
    }

    public function destroy()
    {
        if (!$this->estate->delete()) {
            session()->flash('message', 'Estate could not be deleted.');
            return null;
        }

        session()->flash('message', 'Estate succesfully deleted.');
        return redirect(action([EstateController::class, 'index']));
    }

    public function render()
    {
        return view('livewire.estate.edit', ['estate' => $this->estate]);
    }
}
