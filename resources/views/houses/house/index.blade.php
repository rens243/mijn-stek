<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Houses
            <a class="ml-auto text-base leading-7 no-underline" href="{{ action([\App\Http\Controllers\EstateController::class, 'index']) }}">
                ⚙
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <livewire:house.index />
        </div>
    </div>
</x-app-layout>
