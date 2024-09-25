<div class="flex items-center justify-center fixed inset-0 h-screen bg-black/50 z-[6000] p-5">
    <div class="h-auto w-[900px] p-5 bg-white rounded-lg shadow-lg">
        <p class="font-bold md:text-2xl">For testing the system you can use the following credentials.</p>
        <section class="flex h-full gap-5 justify-between flex-col">
            <div class="h-auto p-5 rounded-lg shadow-lg">
                <h1 class="text-blue-500 font-bold">Customer Dashboard</h1>
                <h1 class="text-xs">https://mechanic.fly.dev/customer</h1>
                <section class="flex flex-col mt-5">
                    <x-label :isRequired="false">Email</x-label>
                    <strong class="text-sm">jane@example.com</strong>
                </section>
                <section class="flex flex-col mt-2">
                    <x-label :isRequired="false">Password</x-label>
                    <strong class="text-sm">password</strong>
                </section>
            </div>
            <div class="h-auto p-5 rounded-lg shadow-lg">
                <h1 class="text-blue-500 font-bold">Mechanic Dashboard</h1>
                <h1 class="text-xs">https://mechanic.fly.dev/mechanic</h1>
                <section class="flex flex-col mt-5">
                    <x-label :isRequired="false">Email</x-label>
                    <strong class="text-sm">john@example.com</strong>
                </section>
                <section class="flex flex-col mt-2">
                    <x-label :isRequired="false">Password</x-label>
                    <strong class="text-sm">password</strong>
                </section>
            </div>
            <div class="h-auto p-5 rounded-lg shadow-lg">
                <h1 class="text-blue-500 font-bold">Admin Dashboard</h1>
                <h1 class="text-xs">https://mechanic.fly.dev/admin</h1>
                <section class="flex flex-col mt-5">
                    <x-label :isRequired="false">Email</x-label>
                    <strong class="text-sm">admin@example.com</strong>
                </section>
                <section class="flex flex-col mt-2">
                    <x-label :isRequired="false">Password</x-label>
                    <strong class="text-sm">password</strong>
                </section>
            </div>
        </section>
        <div class="w-full flex justify-end">
            <button {{$attributes}} class="hover:bg-opacity-75 px-4 py-1 font-bold rounded-lg mt-5 bg-blue-500 text-white">Got it</button>
        </div>
    </div>
</div>