<div class="bg-white rounded shadow-lg h-fit">
    <div class="flex divide-x-2 h-16 border-b border-gray-300">
        <section class="font-bold flex-1 flex items-center justify-center p-5 bg-blue-500">
            <h1 class="font-bold text-2xl text-white">
                Car Details
            </h1>
        </section>
        <section class="font-bold flex-1 flex items-center justify-center p-5 {{$step > 1 ? 'bg-blue-500' : 'bg-blue-200'}}">
            <h1 class="font-bold text-2xl text-white">
                Appointment Details
            </h1>
        </section>
        <section class="font-bold flex-1 flex items-center justify-center p-5 {{$step > 2 ? 'bg-blue-500' : 'bg-blue-200'}}">
            <h1 class="font-bold text-2xl text-white">
                Personal Details
            </h1>
        </section>
    </div>

    <div class="grid grid-cols-2 p-5 gap-5">

        @if($step === 1)
        <x-form-input-div>
            <x-label>Make</x-label>
            <x-input wire:model="form.make" />
            @error('form.make') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Model</x-label>
            <x-input wire:model="form.model" />
            @error('form.model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Year</x-label>
            <x-input wire:model="form.year" />
            @error('form.year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Color</x-label>
            <x-input wire:model="form.color" />
            @error('form.color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>

        @elseif($step === 2)
        <x-form-input-div class="col-span-2">
            <x-label>Service Type</x-label>
            <x-select wire:model="form.service_type">
                @foreach ($services as $service)
                <option value="{{ $service }}">{{ $service }}</option>
                @endforeach
            </x-select>
            @error('form.service_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Description</x-label>
            <textarea wire:model="form.description" class="border border-black/10 rounded-lg h-10 px-3 resize-none" rows="2" cols="50">
                            </textarea>
            @error('form.description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Notes</x-label>
            <textarea wire:model="form.additional_notes" class="border border-black/10 rounded-lg h-10 px-3 resize-none" rows="2" cols="50">
                            </textarea>
            @error('form.additional_notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div class="flex">
            <x-label>Is Emergency?</x-label>
            <div class="flex items-center gap-2">
                <x-label>Yes</x-label>
                <input wire:model="form.is_emergency" value="1" type="radio" name="isEmergency">

                <x-label>No</x-label>
                <input wire:model="form.is_emergency" value="0" type="radio" name="isEmergency">
            </div>
            @error('form.is_emergency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div class="flex">
            <x-label>Needs To be Towed?</x-label>
            <div class="flex items-center gap-2">
                <x-label>Yes</x-label>
                <input wire:model="form.to_be_towed" value="1" type="radio" name="towing">

                <x-label>No</x-label>
                <input wire:model="form.to_be_towed" value="0" type="radio" name="towing">
            </div>
            @error('form.to_be_towed') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Appointment Date</x-label>
            <x-input type="date" wire:model="form.appointment_date" />
            @error('form.appointment_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Appointment Time</x-label>
            <x-select wire:model="form.appointment_time">
                @foreach ($timeSlots as $timeSlot)
                <option value="{{ $timeSlot}}">{{ $timeSlot }}</option>
                @endforeach
            </x-select>
            @error('form.appointment_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>

        @elseif($step === 3)
        <x-form-input-div>
            <x-label>First Name</x-label>
            <x-input wire:model="form.first_name" />
            @error('form.first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Last Name</x-label>
            <x-input wire:model="form.last_name" />
            @error('form.last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Email</x-label>
            <x-input wire:model="form.email" />
            @error('form.email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Phone number</x-label>
            <x-input wire:model="form.phone_number" />
            @error('form.phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        @endif
        <div class="col-span-2 flex justify-end gap-2">
            @if($step > 1)
            <button wire:click="previousStep" class="px-4 py-1 rounded-lg border border-gray-300 text-black font-bold text-sm">Back</button>
            @endif
            @if($step < 3)
                <button wire:click="nextStep" class="px-4 py-1 rounded-lg bg-blue-500 text-white font-bold text-sm">Next</button>
                @else
                <button wire:click="nextStep" class="px-4 py-1 rounded-lg bg-blue-500 text-white font-bold text-sm">Submit</button>
                @endif
        </div>
    </div>

</div>