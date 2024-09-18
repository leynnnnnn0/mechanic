<div class="relative">
     <!-- Nav bar -->
     <section class="fixed top-0 z-50 w-full">
          <livewire:navigation />
     </section>
     <!-- Home Page -->
     <section class="lg:px-[400px] md:px-[200px] relative flex items-center justify-center min-h-screen">
          <section class="space-y-5 mb-16">
               <h1 class="text-6xl font-bold text-blue-500">AUTO MAINTENANCE,<br /> SERVICE & REPAIR</h1>
               <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Labore sit libero quo rerum quasi atque consectetur dolorum saepe reiciendis, modi deleniti voluptate aspernatur eveniet? Nesciunt assumenda laborum delectus laboriosam odio?</p>
               <button class="px-4 py-1 text-lg bg-blue-500 font-bold rounded-sm text-white">
                    Book an appointment
               </button>
          </section>
          <section class="absolute bottom-0">
               <img src="{{ Vite::asset('resources/images/homeBanner.svg')}}" class="object-fill" alt="vehicle">
          </section>
     </section>
     <!-- Why Choose Us? -->
     <!-- Easy Booking process Real time updates warranty flat rate pricing customer support -->
     <section class="h-[400px] bg-blue-50 flex flex-col justify-center items-center p-5 gap-10">
          <h1 class="text-3xl font-bold text-blue-500">
               Why Choose Us?
          </h1>
          <div class="flex items-center gap-5 justify-center">
               <div class="p-5 h-52 rounded-lg w-96">
                    <div>
                         <img src="{{ Vite::asset('resources/images/calendar.jpg') }}" class="h-16" alt="calendar">
                    </div>
                    <h1 class="text-xl font-bold">Easy Booking Process</h1>
                    <p class="text-sm">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Soluta, iste. Lorem ipsum dolor sit amet.</p>
               </div>
               <div class="p-5 h-52 rounded-lg w-96">
                    <div>
                         <img src="{{ Vite::asset('resources/images/calendar.jpg') }}" class="h-16" alt="calendar">
                    </div>
                    <h1 class="text-xl font-bold">Easy Booking Process</h1>
                    <p class="text-sm">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Soluta, iste. Lorem ipsum dolor sit amet.</p>
               </div>
               <div class="p-5 h-52 rounded-lg w-96">
                    <div>
                         <img src="{{ Vite::asset('resources/images/calendar.jpg') }}" class="h-16" alt="calendar">
                    </div>
                    <h1 class="text-xl font-bold">Easy Booking Process</h1>
                    <p class="text-sm">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Soluta, iste. Lorem ipsum dolor sit amet.</p>
               </div>
          </div>
     </section>
     <!-- our team -->
     <section class="h-[600px] flex flex-col justify-center items-center p-5 gap-10">
          <h1 class="text-3xl font-bold text-blue-500">
               Our Trusted Mechanics
          </h1>
          <div class="flex items-center justify-center gap-5">
               <img src="{{ Vite::asset('resources/images/mec1.png')}}" alt="">
               <img src="{{ Vite::asset('resources/images/mec2.png')}}" alt="">
               <img src="{{ Vite::asset('resources/images/mec3.png')}}" alt="">
               <img src="{{ Vite::asset('resources/images/mec4.png')}}" alt="">
               <img src="{{ Vite::asset('resources/images/mec5.png')}}" alt="">
          </div>

     </section>

     <footer class="px-[200px] h-16 flex items-center border-t border-gray-300">
          <h1>© 2024 mecahanic.com. All rights reserved.</h1>
     </footer>
</div>