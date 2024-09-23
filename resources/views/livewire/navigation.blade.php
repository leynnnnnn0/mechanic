<div lazy x-data="menu">
    <template x-if="show">
        <div class="min-h-screen w-full bg-blue-300 fixed inset-0">
            <button @click="toggle" class="absolute right-5 top-5">
                <x-bi-x-circle style="color: white;" />
            </button>
            <div class="flex flex-col items-center justify-center h-full gap-5">
                <x-menu-link @click="toggle" href="/" :active="request()->is('/')">Home</x-menu-link>
                <x-menu-link @click="toggle" href="/" :active="request()->is('about')">About</x-menu-link>
                <x-menu-link @click="toggle" href="/" :active="request()->is('service')">Service</x-menu-link>
                <x-menu-link @click="toggle" href="/appointment" :active="request()->is('appointment')">Appointment</x-menu-link>
                <x-menu-link @click="toggle" href="/track-status" :active="request()->is('track-status')">Track Status</x-menu-link>
                <x-menu-link @click="toggle" href="/register" :active="request()->is('register')">Register</x-menu-link>
                <x-menu-link @click="toggle" href="/customer/login" :active="request()->is('track-status')">Login</x-menu-link>
            </div>
        </div>
    </template>
    <nav class="2xl:px-[300px] xl:px-[100px] lg:px-[100px] md:px-[100px] h-24 flex items-center justify-between bg-white px-10">
        <section class="flex items-center gap-10">
            <a href="/" class="text-lg font-bold text-blue-500" wire:navigate>MECHANIC</a>
            <div class="space-x-5 lg:block hidden">
                <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                <x-nav-link href="/" :active="request()->is('about')">About</x-nav-link>
                <x-nav-link href="/" :active="request()->is('service')">Service</x-nav-link>
                <x-nav-link href="/appointment" :active="request()->is('appointment')">Appointment</x-nav-link>
                <x-nav-link href="/track-status" :active="request()->is('track-status')">Track Status</x-nav-link>
            </div>
        </section>
        <section class="space-x-3 lg:block hidden">
            <a href="/register" class="text-md font-medium" wire:navigate>Register</a>
            <a href="/customer/login" class="bg-blue-500 rounded-lg px-5 py-1 text-md text-white font-medium" wire:navigate>Login</a>
        </section>
        <section class="lg:hidden">
            <button @click="toggle">
                <img class="size-5" src="{{ Vite::asset('resources/images/icons/burger.svg')}}" alt="menu tab">
            </button>
        </section>
    </nav>
    </divx>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('menu', () => ({
                show: false,

                toggle() {
                    this.show = !this.show
                }
            }))
        })
    </script>