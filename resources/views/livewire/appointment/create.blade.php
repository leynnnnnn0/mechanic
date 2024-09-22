<div class="relative bg-white rounded shadow-lg h-fit">
    <div class="flex divide-x-2 h-16 border-b border-gray-300">
        <x-appointment-step :active="true" :currentStep="$step === 1">
            Personal Details <x-carbon-person style="color: white; height: 30px" />
        </x-appointment-step>
        <x-appointment-step :active="$step > 1" :currentStep="$step === 2">
            Car Details <x-carbon-car style="color: white; height: 30px" />
        </x-appointment-step>
        <x-appointment-step :active="$step > 2" :currentStep="$step === 3">
            Appointment Details
            <x-carbon-volume-file-storage style="color: white; height: 30px" />
        </x-appointment-step>
        <x-appointment-step :active="$step > 3" :currentStep="$step === 4">
            Confirm All Details
            <x-carbon-checkmark-outline style="color: white; height: 30px" />
        </x-appointment-step>
    </div>

    <div class="grid grid-cols-2 p-5 gap-5 w-full">
        @if($step === 1)
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

        <x-form-input-div class="col-span-2">
            <x-label>Street Address</x-label>
            <x-input wire:model.live="form.street_address" />
            @error('form.street_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>City</x-label>
            <x-input wire:model.live="form.city" />
            @error('form.city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Barangay</x-label>
            <x-input wire:model.live="form.barangay" />
            @error('form.barangay') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>State or Provice</x-label>
            <x-input wire:model.live="form.state_or_province" />
            @error('form.state_or_province') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Postal Code</x-label>
            <x-input wire:model.live="form.postal_code" />
            @error('form.postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>

        <div class="col-span-2">
            <livewire:appointment.map :form="$form" />
        </div>

        @elseif($step === 2)
        <x-form-input-div>
            <x-label>Make</x-label>
            <x-select wire:model="form.make">
                @foreach ($makes as $make)
                <option value="{{ $make}}">{{ $make }}</option>
                @endforeach
            </x-select>
            @error('form.make') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Model</x-label>
            <x-input wire:model="form.model" />
            @error('form.model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Year</x-label>
            <x-select wire:model="form.year">
                @foreach ($years as $year)
                <option value="{{ $year}}">{{ $year }}</option>
                @endforeach
            </x-select>
            @error('form.year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>
        <x-form-input-div>
            <x-label>Color</x-label>
            <x-input wire:model="form.color" />
            @error('form.color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-form-input-div>

        @elseif($step === 3)
        <x-form-input-div class="col-span-2">
            <x-label>Service Type</x-label>
            <x-select wire:model="form.service_type">
                @foreach ($services as $service)
                <option class="uppercase" value="{{ $service->value }}">{{ $service->value }}</option>
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

        @elseif($step === 4)
        <div class="rounded-sm h-full w-full shadow-md p-10 col-span-2">
            <div class="grid lg:grid-cols-3 md:grid-cols-2 col-span-2 text-gray-900 gap-10 grid-cols-1">
                <section class="flex-1">
                    <div class="border-y border-gray-300 border-dashed py-5 mb-5 flex items-center justify-between">
                        <h1 class="text-xl font-bold">Personal Details</h1>
                        <button wire:click="goToStep(3)" class="text-blue-500 font-bold text-sm">Edit</button>
                    </div>
                    <x-form-input-div class="gap-0">
                        <x-label>First Name</x-label>
                        <strong>{{ $form->first_name ?? 'none'}}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Last Name</x-label>
                        <strong>{{ $form->last_name ?? 'none'}}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Email</x-label>
                        <strong>{{ $form->email ?? 'none'}}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Phone Number</x-label>
                        <strong>{{ $form->phone_number ?? 'none' }}</strong>
                    </x-form-input-div>
                </section>

                <section class="flex-1">
                    <div class="flex items-center justify-between border-y border-gray-300 border-dashed py-5 mb-5">
                        <h1 class="text-xl font-bold">Car Details</h1>
                        <button wire:click="goToStep(1)" class="text-blue-500 font-bold text-sm">Edit</button>
                    </div>
                    <x-form-input-div class="gap-0">
                        <x-label>Make</x-label>
                        <strong>{{ $form->make ?? 'none' }}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Model</x-label>
                        <strong>{{ $form->model ?? 'none' }}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Year</x-label>
                        <strong>{{ $form->year ?? 'none' }}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Color</x-label>
                        <strong>{{ $form->color ?? 'none' }}</strong>
                    </x-form-input-div>
                </section>

                <section class="flex-1">
                    <div class="border-y border-gray-300 border-dashed py-5 mb-5 flex items-center justify-between">
                        <h1 class="text-xl font-bold">Appointment Details</h1>
                        <button wire:click="goToStep(2)" class="text-blue-500 font-bold text-sm">Edit</button>
                    </div>
                    <x-form-input-div class="gap-0">
                        <x-label>Service Type</x-label>
                        <strong>{{ $form->service_type ?? 'None'}}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Is Emergency?</x-label>
                        <strong>{{ $form->is_emergency ? 'Yes' : 'No' }}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Needs to be towed?</x-label>
                        <strong>{{ $form->to_be_towed ? 'Yes' : 'No' }}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Description</x-label>
                        <strong>{{ $form->description ?: 'none' }}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Notes</x-label>
                        <strong>{{ $form->additional_notes ?: 'none' }}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Appointment Date</x-label>
                        <strong>{{ $form->appointment_date ?? 'none'}}</strong>
                    </x-form-input-div>
                    <x-form-input-div class="gap-0">
                        <x-label>Appointment Time</x-label>
                        <strong>{{ $form->appointment_time ?? 'none'}}</strong>
                    </x-form-input-div>
                </section>

            </div>
        </div>

        @endif
        <div class="col-span-2 flex justify-end gap-2">
            @if($step > 1)
            <button wire:click="previousStep" class="px-4 py-1 rounded-lg border border-gray-300 text-black font-bold text-sm">Back</button>
            @endif
            @if($step < 4)
                <button wire:click="nextStep" class="px-4 py-1 rounded-lg bg-blue-500 text-white font-bold text-sm">Next</button>
                @else
                <button wire:click="submit" class="px-4 py-1 rounded-lg bg-blue-500 text-white font-bold text-sm">Submit</button>
                @endif
        </div>
    </div>
</div>