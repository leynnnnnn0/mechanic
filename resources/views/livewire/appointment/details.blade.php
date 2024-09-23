<div class="absolute min-h-screen w-full inset-0 z-40 flex items-center justify-center bg-white">
    <div class="flex flex-col w-[800px] bg-white shadow-lg p-5 gap-5 m-5">
        <section>
            <h1 class="font-bold md:text-2xl text-sm font-poppins">Your Mechanic Reservation is currently on <span class="text-orange-500 uppercase">{{ $appointmentDetails['status'] }}</span> status</h1>
            <p class="md:text-sm text-[9px]">One of our team will contact you within 2-3 hours to confirm the reservation details.</p>
        </section>
        <section class="relative h-auto">
            <strong class="text-lg">Reservation No. <span class="text-blue-500">{{ $appointmentDetails['appointment_number'] }}</span></strong>
            <img src="{{ Vite::asset('resources/images/homeBanner.svg')}}" alt="vehicle">
        </section>
        <section class="flex text-xs justify-between flex-col">
            <section class="flex flex-col">
                <span class="md:text-xs text-[9px]">Appointment Date & Time: </span>
                <span class="md:text-sm text-blue-500 font-bold">{{ Carbon\Carbon::parse($appointmentDetails['appointment_date'])->format('F d, Y') }} ({{ $appointmentDetails['appointment_time'] }})</span>
            </section>
            <section class="flex flex-col">
                <span class="md:text-xs text-[9px]">Vehicle:</span>
                <span class="md:text-sm text-blue-500 font-bold">{{ $appointmentDetails['vehicle'] }}</span>
            </section>
            <section class="flex flex-col">
                <span class="md:text-xs text-[9px]">Service Type: </span>
                <span class="md:text-sm text-blue-500 font-bold">{{ $appointmentDetails['service_type'] }}</span>
            </section>
        </section>
        <section>
            <p class="md:text-sm text-[9px] text-gray-500"><a href="/login" class="underline" wire:navigate>Login</a> to your account to get updates about your reservations/job services</p>
        </section>
    </div>
</div>