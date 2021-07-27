<?php

namespace App\Http\Livewire\Estate;

use App\Exceptions\HouseParseException;
use App\Http\Controllers\EstateController;
use App\Http\Requests\Estate as EstateRequest;
use App\Models\House\Estate;
use App\Services\HousesService;
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
    public function test(HousesService $housesService)
    {
        // Save estate if needed
        if ($this->estate->isDirty()) $this->estate->save();

        try {
            $houses = $housesService->scrape($this->estate, false, false);
            $countHouses = count($houses);
            $this->emit('alert', "Command ran successfully. Found $countHouses houses.");
        } catch (HouseParseException $e){
            $alertText = "Command failed: ".$e->getMessage();
            $this->emit('alert', $alertText);
        } catch (\Exception $e) {
            $this->emit('alert', 'Command failed.');
        }
    }

    public function update()
    {
        $this->validate();

        if (!$this->estate->save()) {
            // flash error
            $this->emit('alert', 'Could not update.');
            return null;
        }

        $this->emit('alert', 'Estate succesfully updated.');
    }

    public function destroy()
    {
        if (!$this->estate->delete()) {
            $this->emit('alert', 'Estate could not be deleted.');
            return null;
        }

        $this->emit('alert', 'Estate succesfully deleted.');
        return redirect(action([EstateController::class, 'index']));
    }

    public function render()
    {
        return view('livewire.estate.edit', ['estate' => $this->estate]);
    }
}
