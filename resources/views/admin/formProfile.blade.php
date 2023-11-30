@extends('templates.sidebar')

@section('container')

<h3 class="mb-4 text-4xl font-extrabold leading-none tracking-tight">Edit Akun</h3>
  @if (session('status'))
    <div class="alert alert-danger">
        {{ session('status') }}
    </div>
  @endif
 <form action="{{url('/admin')}}/{{$user->id}}/edit-profile" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
     <div>
         <input type="hidden" name="ID" id="promoid" value="{{$user->id}}">
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="name" id="nama" value="{{$user->name}}" placeholder="nama event">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="email" name="email" id="deskripsi" value="{{$user->email}}" placeholder="deskripsi">
         </div>
         <div class="mb-2">
             <button class="simpan text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">SIMPAN</button>
         </div>
     </div>
 </form>
@endsection