<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Estates
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">

            <table class="table-auto bg-white text-left w-full border-collapse"> <!--Border collapse doesn't work on this site yet but it's available in newer tailwind versions -->
                <thead>
                <tr>
                    @foreach(['id', 'name', 'url', ''] as $th)
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">
                            {{ $th }}
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>

                @foreach($estates as $estate)
                    <tr>
                        <td class="py-4 px-6 border-b border-grey-light">{{$estate->id }}</td>
                        <td class="py-4 px-6 border-b border-grey-light">{{$estate->name }}</td>
                        <td class="py-4 px-6 border-b border-grey-light">
                            <a href="{{ $estate->url }}">{{ $estate->url }}</a>
                        </td>

                        <td class="py-4 px-6 border-b border-grey-light">
                            <a href="{{action([\App\Http\Controllers\EstateController::class, 'edit'], $estate->id)}}" class="text-white no-underline text-center mr-2 p-1 rounded bg-blue-600">✏</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{action([\App\Http\Controllers\EstateController::class, 'create'])}}" class="ml-auto text-white no-underline text-center mr-2 p-1 rounded bg-green-600">➕</a>
        </div>
    </div>
</x-app-layout>
