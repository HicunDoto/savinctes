@extends('templates.sidebar')

@section('container')

<h3 class="mb-4 text-4xl font-extrabold leading-none tracking-tight">@if (isset($data)) Edit Event @else Buat Event @endif</h3>
  @if (session('status'))
    <div class="alert alert-danger">
        {{ session('status') }}
    </div>
  @endif
 @if (isset($data))
 <form action="{{url('/user')}}/{{$data->id}}/edit-event" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
     <div>
         <input type="hidden" name="ID" id="promoid" value="{{$data->id}}">
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Event</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="title" id="nama" value="{{$data->title}}" placeholder="nama event">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Event</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="description" id="deskripsi" value="{{$data->description}}" placeholder="deskripsi">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="date" name="date" id="masa_aktif" value="{{$data->date}}" >
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam</label>
             <input class="timepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="time" name="time" id="time" value="{{date('H:i', strtotime($data->time))}}" placeholder="00:00">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lokasi</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="location" id="location" value="{{$data->location}}" placeholder="Surabaya">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slot</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="number" name="slots_available" id="slots_available" value="{{$data->slots_available}}" placeholder="0">
         </div>
         <div class="mb-2">
             <button class="simpan text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">SIMPAN</button>
         </div>
     </div>
 </form>
 @else
 <form action="{{url('/user')}}" method="post" enctype="multipart/form-data">
        @csrf
     <div>
         <input type="hidden" name="ID" id="promoid" value="">
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Event</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="title" id="nama" value="" placeholder="nama event">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Event</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="description" id="deskripsi" value="" placeholder="deskripsi">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="date" name="date" id="masa_aktif" value="" >
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam</label>
             <input class="timepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="time" name="time" id="time" value="00:00" placeholder="00:00">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lokasi</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="location" id="location" value="" placeholder="Surabaya">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slot</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="number" name="slots_available" id="slots_available" value="" placeholder="0">
         </div>
         <div class="mb-2">
             <button class="simpan text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">SIMPAN</button>
         </div>
     </div>
 </form>
 @endif
@endsection