<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Edit Estate ({{ $estate->id }})
            <a class="ml-auto text-base leading-7 no-underline" href="{{ action([\App\Http\Controllers\EstateController::class, 'index']) }}">
                ⚙
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white px-8 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="my-8 w-full">
                    <livewire:estate.edit :estate="$estate"/>
                </div>
            </div>
        </div>
    </div>

    <livewire:alert />
</x-app-layout>
