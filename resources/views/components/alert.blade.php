<div class="fixed inset-x-0 bottom-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50">
    <div
        x-data="{ show: false, message: '' }"
        x-init="() => {
            Livewire.on('alert', alertMessage  => {
                message = alertMessage;
                show = true;
                setTimeout(() => show = false, 5000);
            })
        }"
        x-show="show"
        x-description="Notification panel, show/hide based on alert state."
        @click.away="show = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="max-w-sm w-full bg-blue-400 shadow-lg rounded-lg pointer-events-auto">
        <div class="rounded-lg shadow-xs overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        {{--                            <x-svg.icons.check-circle class="h-6 w-6 text-blue-400"/>--}}
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm leading-5 font-medium text-white" x-text="message"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                            {{--                                <x-svg.icons.x class="h-5 w-5" />--}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
