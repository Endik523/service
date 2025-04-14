<div class="w-64 bg-white h-screen shadow-md">
    <div class="p-4 flex items-center">
     <div class="text-2xl font-bold text-purple-600">
      <img src="{{ asset('assets/otw.png') }}" class="image" alt="">
     </div>
    </div>
    <nav class="mt-6">
     <ul>
      <li class="flex items-center p-2 text-gray-700 hover:bg-gray-200">
       <i class="fas fa-tachometer-alt mr-3">
       </i>
       <a href="{{ route('dashboard') }}">Dashboard</a>
      </li>

      <li class="flex items-center p-2 text-gray-700 hover:bg-gray-200">
       <i class="fas fa-chart-line mr-3">
       </i>
       <a href="{{ route('kerusakan') }}">Status</a>
      </li>

      <li class="flex items-center p-2 text-gray-700 hover:bg-gray-200">
       <i class="fas fa-project-diagram mr-3">
       </i>
       <a href="{{ route('payment') }}">Pembayaran</a>
      </li>


     </ul>
    </nav>
    <div class="mt-6">
     <h3 class="text-gray-600 px-4">
      APPS
     </h3>
     <div>
      <div class="flex items-center p-2 text-gray-700 hover:bg-gray-200">
       <i class="fas fa-calendar-alt mr-3">
       </i>
       <a href="{{ route('calender') }}">Calendar</a>

      </div>

      <li class="flex items-center p-2 text-gray-700 hover:bg-gray-200">
       <i class="fas fa-envelope mr-3">
       </i>
       <a href="#">Email</a>
      </li>

      <li class="flex items-center p-2 text-gray-700 hover:bg-gray-200">
       <i class="fas fa-folder mr-3">
       </i>
       <a href="#">File Manager</a>
      </li>

      <li class="flex items-center p-2 text-gray-700 hover:bg-gray-200">
       <i class="fas fa-file-invoice mr-3">
       </i>
       <a href="#">Invoice</a>
      </li>

      <li class="flex items-center p-2 text-gray-700 hover:bg-gray-200">
       <i class="fas fa-user mr-3">
       </i>
       <a href="#">Profile</a>
      </li>
     </div>
    </div>
   </div>
