@extends('layouts.app')

@section("head_title", "Hitung")

@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Hitung NPA</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                         Laporan Masuk > Hitung
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
        
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
            </div>
            @endif

            <div class="card m-b-20">
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice-title">
                            <h4 class="float-right font-16"><strong>{{$id}}</strong></h4>
                            <h3 class="mt-0">
                                <img src="{{ asset('/images/logo npa 2.png')}}" alt="logo" height="24"/>
                            </h3>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <address>
                                    <strong>Wajib Pajak</strong><br>
                                    {{$wp}}<br>
                                    {{$alamat}}<br>
                                    NPWPD : {{$npwpd}}
                                </address>
                            </div>
                            <div class="col-6 text-right">
                                <address>
                                    <strong>Titik Sumur</strong><br>
                                    {{$op_nama}}<br>
                                    {{$op_alamat}}<br>
                                    {{$kelompok}}
                                </address>
                            </div>
                        </div>


                        
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td><strong>Nilai Komponen Sumber Daya Alam</strong></td>
                                        <td class="text-center"><strong>Peringkat</strong></td>
                                        <td class="text-right"><strong>Bobot</strong></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                    <tr> 
                                        <td>{{$kriteria}}</td>
                                        <td class="text-center">{{$peringkat}}</td>
                                        <td class="text-right">{{$bobot}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- npa --> 
                    <div class="col-12">
                        <div>
                            <div class="p-2">
                                <h3 class="font-20"><strong>Nilai Perolehan Air</strong></h3>
                            </div>
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <td><strong>No</strong></td>
                                            <td class="text-center"><strong>Volume</strong></td>
                                            <td class="text-center"><strong>FNA</strong></td>
                                            <td class="text-center"><strong>HAB</strong></td>
                                            <td class="text-center"><strong>HDA</strong></td>
                                            <td class="text-right"><strong>NPA</strong></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                        <tr> 
                                            <td>1</td>
                                            <td class="text-center">{{$nilai1}} M<sup>3</sup></td>
                                            <td class="text-center">{{$fna1}}</td>
                                            <td class="text-center">@currency($hab)</td>
                                            <td class="text-center">@currency($hda1)</td>
                                            <td class="text-right">@currency($npa1)</td>
                                        </tr>

                                        <tr> 
                                            <td>2</td>
                                            <td class="text-center">{{$nilai2}} M<sup>3</sup></td>
                                            <td class="text-center">{{$fna2}}</td>
                                            <td class="text-center">@currency($hab)</td>
                                            <td class="text-center">@currency($hda2)</td>
                                            <td class="text-right">@currency($npa2)</td>
                                        </tr>

                                        <tr> 
                                            <td>3</td>
                                            <td class="text-center">{{$nilai3}} M<sup>3</sup></td>
                                            <td class="text-center">{{$fna3}}</td>
                                            <td class="text-center">@currency($hab)</td>
                                            <td class="text-center">@currency($hda3)</td>
                                            <td class="text-right">@currency($npa3)</td>
                                        </tr>

                                        <tr> 
                                            <td>4</td>
                                            <td class="text-center">{{$nilai4}} M<sup>3</sup></td>
                                            <td class="text-center">{{$fna4}}</td>
                                            <td class="text-center">@currency($hab)</td>
                                            <td class="text-center">@currency($hda4)</td>
                                            <td class="text-right">@currency($npa4)</td>
                                        </tr>

                                        <tr> 
                                            <td>5</td>
                                            <td class="text-center">{{$nilai5}} M<sup>3</sup></td>
                                            <td class="text-center">{{$fna5}}</td>
                                            <td class="text-center">@currency($hab)</td>
                                            <td class="text-center">@currency($hda5)</td>
                                            <td class="text-right">@currency($npa5)</td>
                                        </tr>
                                       
                                        <tr>
                                            <td class="no-line">*</td>
                                            <td class="no-line text-center"> <strong> {{$volume}} M<sup>3</sup></strong></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong>Total</strong></td>
                                            <td class="no-line text-right"><h4 class="m-0">@currency($total)</h4></td>
                                        </tr>
                                        </tbody>
                                    </table><

                                    
                                </div>
                            </div>
                    </div>


                    <div class="col-12">
                        <div>
                            <div class="p-2">
                                <h3 class="font-20"><strong>Pajak Air Tanah Yang Di Bayar</strong></h3>
                            </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <td class="no-line" width="50%">&nbsp;</td>
                                            <td class="no-line"><strong>NILAI PEROLEHAN AIR (NPA)</strong></td>
                                            <td class="no-line text-right">@currency($total)</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>    
                                            <td class="no-line" width="50%">&nbsp;</td>
                                            <td class="no-line"><strong>Pajak</strong></td>
                                            <td class="no-line text-right">20% x @currency($total)</td>
                                        </tr>
                                    
                                        <tr>
                                            <td class="no-line" width="50%">&nbsp;</td>
                                            <td class="no-line">
                                                <strong>Total Pajak </strong></td>
                                            <td class="no-line text-right"><h4 class="m-0">@currency($pajak)</h4></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                      
                                </div> 

                                <div class="col-sm-12">
                                    <div class="card">
                                     <div id="map"></div>
                                     </div>
                                 </div>

                                 
                                <div class="d-print-none">
                                    <div class="float-right">
                                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                        <a href="{{route('tagihan.addtagihan' , [$op_id , $total , $pajak , $volume ,$wp_id,$pg_id] )}}" class="btn btn-primary waves-effect waves-light">Send</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                       
                         

                </div> <!-- end row -->
                </div>
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

        var marker = new mapboxgl.Marker()
        .setLngLat([{{ $flong }},{{ $flat }}]) 
        .addTo(map);  


        var marker = new mapboxgl.Marker()
        .setLngLat([{{ $oplong }},{{ $oplat }}]) 
        .addTo(map); 

     </script>
    
@endsection