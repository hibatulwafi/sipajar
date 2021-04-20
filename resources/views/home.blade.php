@extends('layouts.app')

@section("head_title", "Home")
@section("title")


<link href="{{ asset('/css/style1.css')}}" rel="stylesheet" type="text/css">
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Dashboard</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Selamat Datang, {{Auth::guard('login')->user()->user_first_name." ".Auth::guard('login')->user()->user_last_name}}
                            
                        </li>
                    </ol>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
<div class="container-fluid" id="result">           
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Home</h4>
                    <p>Selamat datang</p>

                    
                </div>

                <!-- Card -->
     <div class="col-sm-12 mb-4">
        <div class="card-group">

            <div class="card col-lg-2 col-md-6 no-padding no-shadow">
                <div class="card-body bg-flat-color-2">
                    <div class="h1 text-muted text-right mb-4">
                        <i class="fa fa-user text-light"></i>
                    </div>
                    <div class="h4 mb-0 text-light">
                        <span class="count">{{$ad}}</span>
                    </div>
                    <small class="text-uppercase font-weight-bold text-light">Total Admin</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>

            
            <div class="card col-lg-2 col-md-6 no-padding no-shadow">
                <div class="card-body bg-flat-color-5">
                    <div class="h1 text-right text-light mb-4">
                        <i class="fa  fa-edit"></i>
                    </div>
                    <div class="h4 mb-0 text-light">
                        <span class="count">{{$pg}}</span> 
                    </div>
                    <small class="text-uppercase font-weight-bold text-light">Laporan Belum Di Proses</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>

            <div class="card col-lg-2 col-md-6 no-padding no-shadow">
                <div class="card-body bg-flat-color-4">
                    <div class="h1 text-light text-right mb-4">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div class="h4 mb-0 text-light">{{$tg}}</div>
                    <small class="text-light text-uppercase font-weight-bold">Tagihan Belum Lunas</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>

            <div class="card col-lg-2 col-md-6 no-padding no-shadow">
                <div class="card-body bg-flat-color-2">
                    <div class="h1 text-muted text-right mb-4">
                        <i class="fa fa-users text-light"></i>
                    </div>

                    <div class="h4 mb-0 text-light">
                        <span class="count"> {{$wp}}</span>
                    </div>
                    <small class="text-uppercase font-weight-bold text-light">Wajib Pajak</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>


            <div class="card col-lg-2 col-md-6 no-padding no-shadow">
                <div class="card-body bg-flat-color-1">
                    <div class="h1 text-light text-right mb-4">
                        <i class="fa fa-building-o"></i>
                    </div>
                    <div class="h4 mb-0 text-light">
                        <span class="count">{{$op}}</span>
                    </div>
                    <small class="text-light text-uppercase font-weight-bold">Objek Pajak</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>

            <div class="card col-lg-2 col-md-6 no-padding no-shadow">
                <div class="card-body bg-flat-color-3">
                    <div class="h1 text-right mb-4">
                        <i class="fa fa-dollar text-light"></i>
                    </div>
                    <div class="h5 mb-0 text-light">
                        <span class="count">@currency($pt)</span>
                    </div>
                    <small class="text-light text-uppercase font-weight-bold">Pendapatan</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>
        </div>
 
 
    </div>
     <!-- end card -->
     <div class="col-sm-12">
        <div class="card">
         <div id="map"></div>
         </div>
     </div>
     <!-- Log -->
    <div class="">
        <div class="col-lg-6">
         <div class="card">
            <div class="card-body">
            <table class="table" id="datatable" >
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">IP</th>
                        <th scope="col" width="40%">Log</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($log as $data)
                     <tr>
                         <td>{{ $data->user_first_name }}</td>
                         <td>{{ date('d M Y h:i', strtotime($data->tanggal)) }}</td>
                         <td>{{ $data->alamat_ip }}</td>
                         <td>{{ $data->desc }}</td>
        
                     </tr>
                     @endforeach
                    @forelse($log as $data)
                     @empty
                     <tr class='text-center'>
                          <td colspan="4">Tidak ada data</td>
                     </tr>
                  @endforelse
                </tbody>
            </table>
        </div>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="card">
            <div class="card-header" style="background-color: #343a40;">
                <strong class="card-title mb-3" style="color:white">User Profil</strong>
            </div>
            <div class="card-body">
                <div class="mx-auto d-block">
                    <img class="rounded-circle mx-auto d-block" width="180" src="images/ava3.png" alt="Card image cap">
                    <h5 class="text-sm-center mt-2 mb-1">{{Auth::guard('login')->user()->user_first_name." ".Auth::guard('login')->user()->user_last_name}}</h5>
                    <div class="location text-sm-center"><i class="ti-email"></i> {{Auth::guard('login')->user()->user_email}} </div>
                </div>
                </hr>
            </div>
        </div><!-- /# card -->
        </div><!-- /# column -->

     </div>  
                <!-- /# end log -->
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
                                     

</div> <!-- end container-fluid -->
@endsection

                                   

@section('map')
        <script>
        mapboxgl.accessToken = 'pk.eyJ1Ijoid2FwaXB1dHJhIiwiYSI6ImNrYzM0em9zaTAwczIzM3BjemlnbXoyd3QifQ.5JkBFnavsM5KAGZvMxNDyg';
        var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [106.92512827677746, -6.928013156983084],
        zoom: 12
        });
         

        @foreach($ops as $data)

        // create the popup
        var popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
        '{{ $data->op_nama}}'
        );
         
           
        var marker = new mapboxgl.Marker()
        .setLngLat([{{ $data->longitude }},{{ $data->latitude }}])
        .setPopup(popup) 
        .addTo(map);               
        @endforeach


        </script>
@endsection