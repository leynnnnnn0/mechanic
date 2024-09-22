<div>
    <nav class="2xl:px-[400px] xl:px-[250px] lg:px-[100px] md:px-[100px] h-24 flex items-center justify-between bg-white px-10">
        <section class="flex items-center gap-10">
            <h1 class="text-lg font-bold text-blue-500">MECHANIC</h1>
            <div class="space-x-5 lg:block hidden">
                <a href="/" class="text-sm font-bold" href="#" wire:navigate>Home</a>
                <a class="text-sm font-bold" href="#">About</a>
                <a class="text-sm font-bold" href="#">Service</a>
                <a class="text-sm font-bold" href="/appointment" wire:navigate>Appointment</a>
                <a class="text-sm font-bold" href="/track-status" wire:navigate>Track Status</a>
            </div>
        </section>
        <section class="space-x-3 lg:block hidden">
            <a href="/register" class="text-md font-medium" wire:navigate>Register</a>
            <a href="/customer/login" class="bg-blue-500 rounded-lg px-5 py-1 text-md text-white font-medium" wire:navigate>Login</a>
        </section>
        <section class="lg:hidden">
            <img class="size-5" src="{{ Vite::asset('resources/images/icons/burger.svg')}}" alt="menu tab">
        </section>
    </nav>
</div>