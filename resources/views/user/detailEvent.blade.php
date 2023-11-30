@extends('templates.sidebar')

@section('container')

<h3 class="mb-4 text-4xl font-extrabold leading-none tracking-tight">Detail Event</h3>
  @if (session('status'))
    <div class="alert alert-danger">
        {{ session('status') }}
    </div>
  @endif
     <div>
         <input type="hidden" name="ID" id="promoid" value="">
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pembuat Event</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly type="text" name="creator_event" id="creator_event" value="{{$data->creator_event}}" placeholder="pembuat event">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Event</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly type="text" name="title" id="nama" value="{{$data->title}}" placeholder="nama event">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Event</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly type="text" name="description" id="deskripsi" value="{{$data->description}}" placeholder="deskripsi">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly type="date" name="date" id="masa_aktif" value="{{$data->date}}" >
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam</label>
             <input class="timepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly type="time" name="time" id="time" value="{{$data->time}}" placeholder="00:00">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lokasi</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" readonly name="location" id="location" value="{{$data->location}}" placeholder="Surabaya">
         </div>
         <div class="mb-2">
             <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slot</label>
             <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="number" readonly name="slots_available" id="slots_available" value="{{$data->slots_available}}" placeholder="0">
         </div>
     </div>
     @if ($data->status_user_book == 0 && $data->status_event_full == 0 && $data->status_event == 1)
        <div class="mb-2 mt-2">
          <button class="booking simpan text-white bg-yellow-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">BOOKING</button>
        </div>
     @endif
     <div>
        <h4 class="mb-4 mt-4 text-2xl font-extrabold leading-none tracking-tight">List Of Bookings</h4>
        <div style="margin-top: 76px;" class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Booking
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tanggal Booking
                        </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                </table>
        </div>
     </div>
     
<script>
    var getID = 0;
    // console.log($('.idpromo').data('id'))
    $(document).ready( function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{route('detailEvent')}}",
            data: {
                id : {{$data->id}},
                UserID: {{$data->loggin_userid}}
            },
            dataType: 'json',
            success: function(data) {
                let bookingData = data.data.bookings;
                $.each(bookingData, function(index, value){
                    $('tbody').append(`
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">${value.no}</td>    
                            <td class="px-6 py-4">${value.Nama_booking}</td>    
                            <td class="px-6 py-4">${value.Tanggal_booking}</td>    
                        </tr>
                    `)
                })

                $('#table').DataTable({
                    responsive: true,
                    processing: false,
                    serverSide: true,
                    ordering: true,
                    scrollX: true,
                    sScrollXInner: "100%",
                    scrollCollapse: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    order: [
                        // [0, 'desc']
                    ],
                    deferRender : true,
                    columnDefs : [
                        {
                            "orderable" : false,
                            "targets" : [0,1,2],
                        }
                    ]
                });
            },
            error: function(data) {
                console.log(data);
            }

        })
        
    });

    $(document).on('click', '.booking',function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{route('addBooking')}}",
            data: {
                event_id : {{$data->id}},
                UserID: {{$data->loggin_userid}}
            },
            dataType: 'json',
            success: function(data) {
                if(data.status_code == 200){
                    alert('data berhasil disimpan');
                    location.reload();
                }else{
                    alert('data gagal disimpan');
                    location.reload();
                }
            },
            error: function(data) {
                console.log(data);
            }

        })
    });

    
</script>
@endsection