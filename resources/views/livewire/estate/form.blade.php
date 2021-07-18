<div class="grid grid-cols-1 gap-6">
    <label class="block">
        <span class="text-gray-700">Name</span>
        <input type="text" wire:model="estate.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        @error('estate.name') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label class="block">
        <span class="text-gray-700">Url</span>
        <input type="text" wire:model.lazy="estate.url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        @error('estate.url') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <div class="block">
        <label class="inline-flex items-center">
            <input type="checkbox" wire:model="estate.active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50" value="1">
            <span class="ml-2">Active</span>
        </label>
    </div>
    <label class="block">
        <span class="text-gray-700">Selector All</span>
        <input type="text" wire:model.lazy="estate.selector_all" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        @error('estate.selector_all') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label class="block">
        <span class="text-gray-700">Selector Each</span>
        <input type="text" wire:model.lazy="estate.selector_each" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        @error('estate.selector_each') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label class="block">
        <span class="text-gray-700">Selector Name</span>
        <input type="text" wire:model.lazy="estate.selector_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        @error('estate.selector_name') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label class="block">
        <span class="text-gray-700">Selector Description</span>
        <input type="text" wire:model.lazy="estate.selector_description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        @error('estate.selector_description') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label class="block">
        <span class="text-gray-700">Selector Photo</span>
        <input type="text" wire:model.lazy="estate.selector_photo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        @error('estate.selector_photo') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label class="block">
        <span class="text-gray-700">Selector Price</span>
        <input type="text" wire:model.lazy="estate.selector_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        @error('estate.selector_price') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label class="block">
        <span class="text-gray-700">Selector Link</span>
        <input type="text" wire:model.lazy="estate.selector_link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        @error('estate.selector_link') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>

    {{ $slot ?? '' }}
</div>
