<div>
    <form wire:submit.prevent="update">
        <input type="hidden" wire:model="estate.id">
        @include('livewire.estate.form', ['estate' => $estate])
        <div class="flex mt-2">
            <button type="submit" class="text-white block p-2 px-4 mr-2 rounded bg-green-600">
                Update
            </button>
        </div>
    </form>

    <div class="flex mt-2">
        <button wire:click="test" class="text-white block p-2 px-4 rounded bg-blue-600">
            Test
        </button>
        <button wire:click="destroy" class="ml-auto text-white block p-2 px-4 mr-2 rounded bg-red-600">
            Delete
        </button>
    </div>
</div>
