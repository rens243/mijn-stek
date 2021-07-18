<?php

namespace App\Http\Livewire\House;

use App\Models\House\House;
use Livewire\Component;
use App\Http\Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $queryString = [];

    public function render()
    {
        return view('livewire.house.index', [
            'houses' => House::query()
                ->orderBy('created_at', 'desc')
                ->paginate(20),
        ]);

    }
}
