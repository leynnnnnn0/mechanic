<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button type="submit">
                Create Service Job
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
