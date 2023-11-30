@extends('templates.sidebar')

@section('title','List Event')

@section('container')
<h3 class="mb-4 text-4xl font-extrabold leading-none tracking-tight">List Event</h3>
<a href="{{ url('/admin/create-event') }}" style="position: absolute;" class="btn-tambah-paket focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Tambah Event</a>
<div style="margin-top: 76px;" class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Event
                </th>
                <th scope="col" class="px-6 py-3">
                    Lokasi
                </th>
                <th scope="col" class="px-6 py-3">
                    Status Event
                </th>
                <th style="text-align: center" scope="col" class="px-6 py-3">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr class="@if ($item['highlight'] == '1') bg-blue-50 @else bg-white @endif border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                       {{ $loop->iteration}}
                    </th>
                    <td class="px-6 py-4">
                        {{ $item['title']}}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item['location']}}
                    </td>
                    <td class="px-6 py-4">
                        @if ($item['status_event']==1)
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">On Going</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Done</span>
                        @endif
                    </td>
                    <td style="text-align: center" class="px-6 py-4">
                        <div><a class="text-white bg-purple-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href ="/admin/{{ $item['ID']}}/detail-event">Detail</a>
                        <a class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href ="/admin/{{ $item['ID']}}/edit">Edit</a>
                        <form action="/admin/event/{{ $item['ID']}}" method="post" style="display: contents"> @csrf  <button type="submit" class="text-white bg-red-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Hapus</button></form></div> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
</div>

@endsection