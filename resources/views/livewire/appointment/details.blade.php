<div class="absolute min-h-screen w-full inset-0 z-40 flex items-center justify-center bg-white">
    <div class="flex flex-col w-[800px] bg-white shadow-lg p-5 gap-5">
        <section>
            <h1 class="font-bold text-lg font-poppins">Your Mechanic Reservation is currently on <span class="text-orange-500 uppercase">{{ $appointmentDetails['status'] }}</span> status</h1>
            <p class="text-xs">One of our team will contact you within 2-3 hours to confirm the reservation details.</p>
        </section>
        <section class="relative h-72 p-5">
            <strong class="text-lg">Reservation No. <span class="text-blue-500">{{ $appointmentDetails['appointment_number'] }}</span></strong>
            <img class="absolute inset-0" src="{{ Vite::asset('resources/images/homeBanner.svg')}}" alt="">
        </section>
        <section class="flex text-xs justify-between">
            <span>Appointment Date & Time: <span class="text-blue-500">{{ Carbon\Carbon::parse($appointmentDetails['appointment_date'])->format('F d, Y') }} ({{ $appointmentDetails['appointment_time'] }})</span></span>
            <span>Vehicle: <span class="text-blue-500">{{ $appointmentDetails['vehicle'] }}</span></span>
            <span>Service Type: <span class="text-blue-500">{{ $appointmentDetails['service_type'] }}</span></span>
        </section>
        <section>
            <span class="text-xs text-gray-500"><a href="/login" class="underline" wire:navigate>Login</a> to your account to get updates about your reservations/job services</span>
        </section>
    </div>
</div>