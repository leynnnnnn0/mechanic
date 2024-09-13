@php
$timeSlots = [
    '8:00 am - 9:00 am',
    '9:00 am - 10:00 am',
    '10:00 am - 11:00 am',
    '11:00 am - 12:00 pm',
    '1:00 am - 2:00 pm',
    '2:00 am - 3:00 pm',
    '3:00 am - 4:00 pm',
    '4:00 am - 5:00 pm',
]
@endphp
<div class="rounded-lg h-40 border border-gray-300 p-3 grid sm:grid-cols-3 gap-2">
    <h1 class="col-span-full text-sm font-semibold">Select appointment time</h1>
    @foreach($timeSlots as $time)
        <x-time-button>
            {{ $time }}
        </x-time-button>
    @endforeach
</div>
