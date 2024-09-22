<div class="relative">
    <!-- Nav bar -->
    <section class="fixed top-0 z-50 w-full">
        <livewire:navigation />
    </section>
    <!-- component -->
    <div class="min-h-screen pt-32 p-6 bg-gray-100 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <div>
                @if($details)
                <livewire:appointment.details :$details />
                @else
                <livewire:appointment.create />
                @endif
            </div>
        </div>
    </div>
</div>