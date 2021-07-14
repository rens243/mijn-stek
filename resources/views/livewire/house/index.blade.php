
<div>
    <div wire:loading class="w-full text-center text-sm mb-4"> loading...</div>

    <ul class="list-none m-0 p-0" wire:loading.class="hidden">
        @foreach ($houses as $house)
            <li class="py-4 px-8 bg-white shadow-lg rounded-lg mb-10">
                <a class="md:flex flex-wrap block no-underline" href="{{ $house->link }}">
                    <img class="w-full md:w-1/3 object-contain" alt="house photo" src="{{$house->photo}}" />
                    <div class="w-full md:w-2/3 md:pl-8 space-y-2 ">
                        <div class="flex items-start">
                            <h2>{{ $house->name }}</h2>
                            <div style="background-color: #{{ $house->estate->hex_color }}" class="ml-auto flex-start px-2 text-white text-center mr-2 mt-4 md:mt-0 rounded-xl">
                                {{ $house->estate->name }}
                            </div>
                            <div class="mt-4 md:mt-0">{{ \Carbon\Carbon::parse($house->updated_at)->diffForHumans() }}</div>
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

