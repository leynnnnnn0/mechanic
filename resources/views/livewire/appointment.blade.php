<div class="relative">
    <!-- Nav bar -->
    <section class="fixed top-0 z-50 w-full">
        <livewire:navigation />
    </section>
    <!-- component -->
    <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <div>
                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">

                    <section class="grid grid-cols-2 gap-5">
                        <h1 class="text-lg font-bold col-span-2">
                            Personal Details
                        </h1>
                        <x-form-input-div>
                            <x-label>First Name</x-label>
                            <x-input />
                        </x-form-input-div>
                        <x-form-input-div>
                            <x-label>Last Name</x-label>
                            <x-input />
                        </x-form-input-div>
                    </section>

                    <section class="grid grid-cols-2 gap-5">
                        <h1 class="text-lg font-bold col-span-2">
                            Car Details
                        </h1>
                        <x-form-input-div>
                            <x-label>Make</x-label>
                            <x-input />
                        </x-form-input-div>
                        <x-form-input-div>
                            <x-label>Model</x-label>
                            <x-input />
                        </x-form-input-div>
                        <x-form-input-div>
                            <x-label>Year</x-label>
                            <x-input />
                        </x-form-input-div>
                        <x-form-input-div>
                            <x-label>Color</x-label>
                            <x-input />
                        </x-form-input-div>
                    </section>

                    <section class="grid grid-cols-2 gap-5">
                        <h1 class="text-lg font-bold col-span-2">
                            Appointment Details
                        </h1>
                        <x-form-input-div class="col-span-2">
                            <x-label>Service Type</x-label>
                            <x-select>
                                @foreach ($services as $service)
                                <option value="{{ $service }}">{{ $service }}</option>
                                @endforeach
                            </x-select>
                        </x-form-input-div>
                        <x-form-input-div>
                            <x-label>Description</x-label>
                            <textarea class="border border-black/10 rounded-lg h-10 px-3 resize-none" rows="2" cols="50">
                            </textarea>
                        </x-form-input-div>
                        <x-form-input-div>
                            <x-label>Notes</x-label>
                            <textarea class="border border-black/10 rounded-lg h-10 px-3 resize-none" rows="2" cols="50">
                            </textarea>
                        </x-form-input-div>
                        <x-form-input-div class="flex">
                            <x-label>Is Emergency?</x-label>
                            <div class="flex items-center gap-2">
                                <x-label>Yes</x-label>
                                <input type="radio" name="isEmergency">

                                <x-label>No</x-label>
                                <input type="radio" name="isEmergency">
                            </div>
                        </x-form-input-div>
                        <x-form-input-div class="flex">
                            <x-label>Needs To be Towed?</x-label>
                            <div class="flex items-center gap-2">
                                <x-label>Yes</x-label>
                                <input type="radio" name="towing">

                                <x-label>No</x-label>
                                <input type="radio" name="towing">
                            </div>
                        </x-form-input-div>
                    </section>
                </div>
            </div>

        </div>
    </div>
</div>