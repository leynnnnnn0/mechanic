<x-filament-panels::page>
    <div class="flex items-center justify-center">
        <div class="bg-blue-500">
            <a class="px-4 py-2 rounded-lg font-bold bg-primary-500 text-white" href="/customer/customers/{{ auth('customer')->user()->customer_id }}/edit" wire:navigate>
                Edit Details
            </a>
        </div>
    </div>
    {{ $this->infolist }}
</x-filament-panels::page>