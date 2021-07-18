@push('scripts')
    <script>
        Livewire.on('goToTop', () => {
            console.log('scrolll???L)')
            window.scrollTo({
                top: 0,
                left: 0,
            })
        })
    </script>
@endpush

<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
                Houses
                <a class="ml-auto text-base leading-7 cursor-pointer no-underline mr-2" wire:click="$refresh">
                    🔄
                </a>
                <a class="text-base leading-7 no-underline" href="{{ action([\App\Http\Controllers\EstateController::class, 'index']) }}">
                    ⚙
                </a>
            </h2>
        </x-slot>

        <div class="py-12" wire:poll.visible.60s>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>
{{--                    <div wire:loading class="w-full text-center text-sm mb-4"> loading...</div>--}}

                    <ul class="list-none m-0 p-0">
                        @foreach ($houses as $house)
                            <li class="py-4 px-8 bg-white shadow-lg rounded-lg mb-10">
                                <a class="md:flex flex-wrap block no-underline" href="{{ $house->link }}">
                                    <img class="w-full md:w-1/3 object-contain" alt="house photo" src="{{$house->photo}}" />
                                    <div class="w-full md:w-2/3 md:pl-8 space-y-2 ">
                                        <div class="flex items-start">
                                            <h2>{{ $house->name }}</h2>
                                            <div style="background-color: #{{ $house->estate->hex_color }}" class="ml-auto whitespace-nowrap flex-start px-2 text-white text-center mr-2 mt-4 md:mt-0 rounded-xl">
                                                {{ $house->estate->name }}
                                            </div>
                                            <div class="mt-4 md:mt-0">{{ \Carbon\Carbon::parse($house->created_at)->diffForHumans() }}</div>
                                        </div>

                                        <h4>{{ $house->price }}</h4>

                                        @foreach (Str::of($house->description)->explode('\n') as $descriptionPart)
                                            <p>{{ $descriptionPart }}</p>
                                        @endforeach
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{ $houses->links() }}
                </div>
            </div>
        </div>
    </x-app-layout>
</div>


