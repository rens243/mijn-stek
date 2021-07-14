<?php

namespace App\Http\Livewire\House;

use App\Models\House\House;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $queryString = [];

    public function render()
    {
        $this->queryString = [];
        return view('livewire.house.index', [
            'houses' => House::query()->orderBy('created_at', 'desc')->paginate(10),
        ]);

    }
}
