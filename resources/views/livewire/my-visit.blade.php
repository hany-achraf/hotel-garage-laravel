<div class="m-8">
    <div class="flex flex-col w-full">
        {{-- Show visit Plate number --}}
        <div class="flex flex-col w-full">
            <label class="text-sm font-semibold text-gray-600">Plate No.:</label>
            <p class="text-lg font-semibold">{{ $visit->plate_no }}</p>
        </div>

        {{-- Show visit Date --}}
        <div class="flex flex-col w-full">
            <label class="text-sm font-semibold text-gray-600">Entry Time:</label>
            <p class="text-lg font-semibold">{{ $visit->entry_time }}</p>
        </div>

        <x-button class="flex mx-auto my-4" wire:click="pay">Pay now</x-button>
    </div>
</div>
