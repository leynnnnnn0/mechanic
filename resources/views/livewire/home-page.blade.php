<div class="relative">
     @if(!request()->session()->get('acknowledged'))
     <x-credentials wire:click="acknowledge" />
     @endif

     <!-- Nav bar -->
     <section class="fixed top-0 z-50 w-full">
          <livewire:navigation />
     </section>
     <!-- Home Page -->
     <section class="2xl:px-[400px] xl:px-[250px] md:px-[100px] relative flex items-center justify-center min-h-screen px-10">
          <section class="space-y-5 mb-16">
               <h1 class="lg:text-5xl font-bold text-blue-500 sm:text-4xl text-xl">AUTO MAINTENANCE,<br /> SERVICE & REPAIR</h1>
               <p class="lg:text-md sm:text-sm text-xs">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Labore sit libero quo rerum quasi atque consectetur dolorum saepe reiciendis, modi deleniti voluptate aspernatur eveniet? Nesciunt assumenda laborum delectus laboriosam odio?</p>
               <div>
                    @if(auth('customer')->check())
                    <a href="/customer/appointments/create" class="cursor-pointer z-10 px-4 py-1 lg:text-lg bg-blue-500 font-bold rounded-sm text-white sm:text-lg  text-sm" wire:navigate>
                         Book an appointment
                    </a>
                    @else
                    <a href="/appointment" class="cursor-pointer z-10 px-4 py-1 lg:text-lg bg-blue-500 font-bold rounded-sm text-white sm:text-lg  text-sm" wire:navigate>
                         Book an appointment
                    </a>
                    @endif
               </div>
          </section>
          <section class="absolute bottom-0">
               <img src="{{ Vite::asset('resources/images/homeBanner.svg')}}" class="object-fill" alt="vehicle">
          </section>
     </section>
     <!-- Why Choose Us? -->
     <!-- Easy Booking process Real time updates warranty flat rate pricing customer support -->
     <section class="h-fit py-16 bg-blue-50 flex flex-col justify-center items-center p-5 gap-10">
          <h1 class="text-3xl font-bold text-blue-500">
               Why Choose Us?
          </h1>
          <div class="flex lg:flex-row md:flex-col items-center gap-5 justify-center flex-col">
               <x-choose-us-box />
               <x-choose-us-box />
               <x-choose-us-box />
          </div>
     </section>
     <!-- our team -->
     <section class="flex flex-col justify-center items-center p-5 gap-10 h-auto">
          <h1 class="text-3xl font-bold text-blue-500 text-center">
               Our Trusted Mechanics
          </h1>
          <div class="lg:grid xl:grid-cols-5 lg:grid-cols-3 gap-5">
               <img src="{{ Vite::asset('resources/images/mec1.png')}}" alt="">
               <img src="{{ Vite::asset('resources/images/mec2.png')}}" alt="">
               <img src="{{ Vite::asset('resources/images/mec3.png')}}" alt="">
               <img src="{{ Vite::asset('resources/images/mec4.png')}}" alt="">
               <img src="{{ Vite::asset('resources/images/mec5.png')}}" alt="">
          </div>

     </section>

     <footer class="h-16 flex items-center border-t border-gray-300 px-10">
          <h1 class="text-xs">© 2024 mecahanic.com. All rights reserved.</h1>
     </footer>
</div>