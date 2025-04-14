<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Dashboard
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Bootstrap JavaScript (untuk komponen yang memerlukan JavaScript seperti modal, tooltip, dll.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 </head>
 <body class="bg-gray-100">
  <div class="flex">

   <!-- Sidebar -->
   @include('partials.sidebaradmin')

   <!-- Main Content -->
   <div class="flex-1 p-6">

    <!-- Header -->
    @include('partials.headeradmin')

    <!-- main content -->
    @yield('content')

    <!-- Projects Overview -->
    {{-- <div class="bg-purple-600 text-white p-6 rounded-lg mb-6">
     <div class="flex justify-between items-center">
      <h2 class="text-2xl font-bold">
       Projects
      </h2>
      <button class="bg-white text-purple-600 px-4 py-2 rounded-lg">
       Create New Project
      </button>
     </div>
     <div class="grid grid-cols-4 gap-4 mt-6">
      <div class="bg-white text-purple-600 p-4 rounded-lg flex flex-col items-center">
       <i class="fas fa-folder-open text-2xl mb-2">
       </i>
       <div class="text-3xl font-bold">
        18
       </div>
       <div class="text-sm">
        2 Completed
       </div>
      </div>
      <div class="bg-white text-purple-600 p-4 rounded-lg flex flex-col items-center">
       <i class="fas fa-tasks text-2xl mb-2">
       </i>
       <div class="text-3xl font-bold">
        132
       </div>
       <div class="text-sm">
        28 Completed
       </div>
      </div>
      <div class="bg-white text-purple-600 p-4 rounded-lg flex flex-col items-center">
       <i class="fas fa-users text-2xl mb-2">
       </i>
       <div class="text-3xl font-bold">
        12
       </div>
       <div class="text-sm">
        1 Completed
       </div>
      </div>
      <div class="bg-white text-purple-600 p-4 rounded-lg flex flex-col items-center">
       <i class="fas fa-chart-line text-2xl mb-2">
       </i>
       <div class="text-3xl font-bold">
        76%
       </div>
       <div class="text-sm">
        5% Completed
       </div>
      </div>
     </div>
    </div> --}}

    <!-- Active Projects -->
    {{-- <div class="grid grid-cols-3 gap-6">
     <div class="col-span-2 bg-white p-6 rounded-lg shadow-md">
      <h3 class="text-xl font-bold mb-4">
       Active Projects
      </h3>
      <table class="w-full text-left">
       <thead>
        <tr>
         <th class="pb-2">
          Project name
         </th>
         <th class="pb-2">
          Hours
         </th>
         <th class="pb-2">
          Priority
         </th>
         <th class="pb-2">
          Members
         </th>
         <th class="pb-2">
          Progress
         </th>
        </tr>
       </thead>
       <tbody>
        <tr class="border-t">
         <td class="py-2 flex items-center">
          <img alt="Dropbox Design System logo" class="mr-2" height="20" src="https://storage.googleapis.com/a1aa/image/ZWjDnp70yI0qp2x75GfVf0r-qdE2fFiFR_VRpOO7uKM.jpg" width="20"/>
          Dropbox Design System
         </td>
         <td class="py-2">
          34
         </td>
         <td class="py-2">
          <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">
           Medium
          </span>
         </td>
         <td class="py-2 flex items-center">
          <img alt="Member 1" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/ZS2GOe-4ele2Lj-U6XkUeo5MiRyr0wg7LVMnpVwP7DU.jpg" width="20"/>
          <img alt="Member 2" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/RRdqQg_5Iv4GgVsRtac7WN2CdhIKQcUh7owlku86hDw.jpg" width="20"/>
          <img alt="Member 3" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/z3PAF8kb8z4WtZb2-980IZnKCkJuV4oSF1DxF6bXUeY.jpg" width="20"/>
          <img alt="Member 4" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/IEzVpwDhkWrDDSmKJavGDFDkcfPPzBbDwAlsBuTqhog.jpg" width="20"/>
          <img alt="Member 5" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/o9VGc4z9TmQ_aTtE5Q2nVrOj0Z5_DITy9OZfhQtW6Rw.jpg" width="20"/>
          <span class="text-gray-500">
           +5
          </span>
         </td>
         <td class="py-2">
          <div class="w-full bg-gray-200 rounded-full h-2">
           <div class="bg-blue-600 h-2 rounded-full" style="width: 15%">
           </div>
          </div>
         </td>
        </tr>
        <tr class="border-t">
         <td class="py-2 flex items-center">
          <img alt="Slack Team UI Design logo" class="mr-2" height="20" src="https://storage.googleapis.com/a1aa/image/ZUq5TDeh9SZ2yymCDjI4seuEaupLG9Oec7gRFsYUN4s.jpg" width="20"/>
          Slack Team UI Design
         </td>
         <td class="py-2">
          47
         </td>
         <td class="py-2">
          <span class="bg-red-200 text-red-800 px-2 py-1 rounded">
           High
          </span>
         </td>
         <td class="py-2 flex items-center">
          <img alt="Member 1" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/ZS2GOe-4ele2Lj-U6XkUeo5MiRyr0wg7LVMnpVwP7DU.jpg" width="20"/>
          <img alt="Member 2" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/RRdqQg_5Iv4GgVsRtac7WN2CdhIKQcUh7owlku86hDw.jpg" width="20"/>
          <img alt="Member 3" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/z3PAF8kb8z4WtZb2-980IZnKCkJuV4oSF1DxF6bXUeY.jpg" width="20"/>
          <img alt="Member 4" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/IEzVpwDhkWrDDSmKJavGDFDkcfPPzBbDwAlsBuTqhog.jpg" width="20"/>
          <img alt="Member 5" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/o9VGc4z9TmQ_aTtE5Q2nVrOj0Z5_DITy9OZfhQtW6Rw.jpg" width="20"/>
          <span class="text-gray-500">
           +5
          </span>
         </td>
         <td class="py-2">
          <div class="w-full bg-gray-200 rounded-full h-2">
           <div class="bg-blue-600 h-2 rounded-full" style="width: 35%">
           </div>
          </div>
         </td>
        </tr>
        <tr class="border-t">
         <td class="py-2 flex items-center">
          <img alt="GitHub Satellite logo" class="mr-2" height="20" src="https://storage.googleapis.com/a1aa/image/Nq5xl7NRWVwCITFX8FTx_nG6IG9jkhUMVWuQA3Chblo.jpg" width="20"/>
          GitHub Satellite
         </td>
         <td class="py-2">
          120
         </td>
         <td class="py-2">
          <span class="bg-green-200 text-green-800 px-2 py-1 rounded">
           Low
          </span>
         </td>
         <td class="py-2 flex items-center">
          <img alt="Member 1" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/ZS2GOe-4ele2Lj-U6XkUeo5MiRyr0wg7LVMnpVwP7DU.jpg" width="20"/>
          <img alt="Member 2" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/RRdqQg_5Iv4GgVsRtac7WN2CdhIKQcUh7owlku86hDw.jpg" width="20"/>
          <img alt="Member 3" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/z3PAF8kb8z4WtZb2-980IZnKCkJuV4oSF1DxF6bXUeY.jpg" width="20"/>
          <img alt="Member 4" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/IEzVpwDhkWrDDSmKJavGDFDkcfPPzBbDwAlsBuTqhog.jpg" width="20"/>
          <img alt="Member 5" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/o9VGc4z9TmQ_aTtE5Q2nVrOj0Z5_DITy9OZfhQtW6Rw.jpg" width="20"/>
          <span class="text-gray-500">
           +1
          </span>
         </td>
         <td class="py-2">
          <div class="w-full bg-gray-200 rounded-full h-2">
           <div class="bg-blue-600 h-2 rounded-full" style="width: 75%">
           </div>
          </div>
         </td>
        </tr>
        <tr class="border-t">
         <td class="py-2 flex items-center">
          <img alt="3D Character Modelling logo" class="mr-2" height="20" src="https://storage.googleapis.com/a1aa/image/lKh3Kvm9NYoIz1HFZvQ2TdvpzAMpQfjB33AF_1IW11k.jpg" width="20"/>
          3D Character Modelling
         </td>
         <td class="py-2">
          89
         </td>
         <td class="py-2">
          <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">
           Medium
          </span>
         </td>
         <td class="py-2 flex items-center">
          <img alt="Member 1" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/ZS2GOe-4ele2Lj-U6XkUeo5MiRyr0wg7LVMnpVwP7DU.jpg" width="20"/>
          <img alt="Member 2" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/RRdqQg_5Iv4GgVsRtac7WN2CdhIKQcUh7owlku86hDw.jpg" width="20"/>
          <img alt="Member 3" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/z3PAF8kb8z4WtZb2-980IZnKCkJuV4oSF1DxF6bXUeY.jpg" width="20"/>
          <img alt="Member 4" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/IEzVpwDhkWrDDSmKJavGDFDkcfPPzBbDwAlsBuTqhog.jpg" width="20"/>
          <img alt="Member 5" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/o9VGc4z9TmQ_aTtE5Q2nVrOj0Z5_DITy9OZfhQtW6Rw.jpg" width="20"/>
          <span class="text-gray-500">
           +5
          </span>
         </td>
         <td class="py-2">
          <div class="w-full bg-gray-200 rounded-full h-2">
           <div class="bg-blue-600 h-2 rounded-full" style="width: 63%">
           </div>
          </div>
         </td>
        </tr>
        <tr class="border-t">
         <td class="py-2 flex items-center">
          <img alt="Webapp Design System logo" class="mr-2" height="20" src="https://storage.googleapis.com/a1aa/image/9XjiQYdM2RemDNZJuWIZUb_H8mfRPArvsB5TQfuCl3c.jpg" width="20"/>
          Webapp Design System
         </td>
         <td class="py-2">
          108
         </td>
         <td class="py-2">
          <span class="bg-green-200 text-green-800 px-2 py-1 rounded">
           Track
          </span>
         </td>
         <td class="py-2 flex items-center">
          <img alt="Member 1" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/ZS2GOe-4ele2Lj-U6XkUeo5MiRyr0wg7LVMnpVwP7DU.jpg" width="20"/>
          <img alt="Member 2" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/RRdqQg_5Iv4GgVsRtac7WN2CdhIKQcUh7owlku86hDw.jpg" width="20"/>
          <img alt="Member 3" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/z3PAF8kb8z4WtZb2-980IZnKCkJuV4oSF1DxF6bXUeY.jpg" width="20"/>
          <img alt="Member 4" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/IEzVpwDhkWrDDSmKJavGDFDkcfPPzBbDwAlsBuTqhog.jpg" width="20"/>
          <img alt="Member 5" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/o9VGc4z9TmQ_aTtE5Q2nVrOj0Z5_DITy9OZfhQtW6Rw.jpg" width="20"/>
          <span class="text-gray-500">
           +5
          </span>
         </td>
         <td class="py-2">
          <div class="w-full bg-gray-200 rounded-full h-2">
           <div class="bg-blue-600 h-2 rounded-full" style="width: 100%">
           </div>
          </div>
         </td>
        </tr>
        <tr class="border-t">
         <td class="py-2 flex items-center">
          <img alt="Github Event Design logo" class="mr-2" height="20" src="https://storage.googleapis.com/a1aa/image/KxlMMKSAPrzsZ88dtGawJLasQC8pCe0rY59njds95c8.jpg" width="20"/>
          Github Event Design
         </td>
         <td class="py-2">
          120
         </td>
         <td class="py-2">
          <span class="bg-green-200 text-green-800 px-2 py-1 rounded">
           Low
          </span>
         </td>
         <td class="py-2 flex items-center">
          <img alt="Member 1" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/ZS2GOe-4ele2Lj-U6XkUeo5MiRyr0wg7LVMnpVwP7DU.jpg" width="20"/>
          <img alt="Member 2" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/RRdqQg_5Iv4GgVsRtac7WN2CdhIKQcUh7owlku86hDw.jpg" width="20"/>
          <img alt="Member 3" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/z3PAF8kb8z4WtZb2-980IZnKCkJuV4oSF1DxF6bXUeY.jpg" width="20"/>
          <img alt="Member 4" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/IEzVpwDhkWrDDSmKJavGDFDkcfPPzBbDwAlsBuTqhog.jpg" width="20"/>
          <img alt="Member 5" class="rounded-full mr-1" height="20" src="https://storage.googleapis.com/a1aa/image/o9VGc4z9TmQ_aTtE5Q2nVrOj0Z5_DITy9OZfhQtW6Rw.jpg" width="20"/>
          <span class="text-gray-500">
           +1
          </span>
         </td>
         <td class="py-2">
          <div class="w-full bg-gray-200 rounded-full h-2">
           <div class="bg-blue-600 h-2 rounded-full" style="width: 75%">
           </div>
          </div>
         </td>
        </tr>
       </tbody>
      </table>
     </div>
     <!-- Tasks Performance -->
     <div class="bg-white p-6 rounded-lg shadow-md">
      <h3 class="text-xl font-bold mb-4">
       Tasks Performance
      </h3>
      <div class="flex justify-center mb-4">
       <img alt="Tasks Performance Chart" height="200" src="https://storage.googleapis.com/a1aa/image/2iJUk_pdd5osr7Cb6iDkRLVVp0u5LJUpYWf5Bj594E4.jpg" width="200"/>
      </div>
      <div class="flex justify-around">
       <div class="text-center">
        <div class="text-2xl font-bold">
         76%
        </div>
        <div class="text-sm text-gray-500">
         Completed
        </div>
       </div>
       <div class="text-center">
        <div class="text-2xl font-bold">
         32%
        </div>
        <div class="text-sm text-gray-500">
         In Progress
        </div>
       </div>
       <div class="text-center">
        <div class="text-2xl font-bold">
         13%
        </div>
        <div class="text-sm text-gray-500">
         Pending
        </div>
       </div>
      </div>
     </div>
    </div> --}}



   </div>
  </div>
  @include('partials.scriptadmin')
 </body>
</html>
