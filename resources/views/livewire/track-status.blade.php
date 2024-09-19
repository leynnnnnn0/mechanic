<div>
    <section class="fixed top-0 z-50 w-full">
        <livewire:navigation />
    </section>
    <section class="min-h-screen w-full flex flex-col items-center justify-center space-y-3">
        <h1 class="text-blue-500 font-bold text-4xl">TRACK YOUR APPOINTMENT/SERVICE JOB STATUS IN ONE CLICK.</h1>
        <form wire:submit.prevent="getResult" class="relative flex items-center w-96 h-16 rounded-full border border-gray-200 focus-within:shadow-lg overflow-hidden">
            <div class="grid place-items-center h-full w-12 text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input
                class="peer h-full w-full outline-none text-sm text-gray-700 pr-2"
                type="text"
                id="search"
                wire:model="query"
                placeholder="Search something.." />
        </form>
        @if($result)
        <div class="relative flex flex-col gap-5 rounded-lg shadow-lg w-96 p-5 mt-5">
            <h1 class="text-md font-light">Appointment Number: <span class="text-blue-500 font-bold text-lg">{{ $result->appointment_number }}</span></h1>
            <strong class="text-sm font-light">Appointment Date: <span class="font-bold text-md">{{ Carbon\Carbon::parse($result->appointment_date)->format('F d, Y')}}</span></strong>
            <strong class="text-sm font-light">Appointment Time: <span class="font-bold text-md">{{ $result->appointment_time }}</span></strong>
            <strong class="text-sm font-light">Status: <span @class(['uppercase font-bold','text-orange-500'=> $result->status === 'pending', 'text-green-500' => $result->status === 'confirmed', 'text-red-500' => $result->status === 'cancelled'
                    ])>{{ $result->status }}</span></strong>
        </div>
        @endif
        </template>
    </section>
</div>