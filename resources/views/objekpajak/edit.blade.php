@extends('layouts.app')

@section("head_title", "Daftar Titik Sumur")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Titik Sumur</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Edit Data Titik Sumur
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

                    <div class="row">
                        <div class="col-6">  
                        <h4 class="header-title">Edit Titik Sumur </h4>
                        </div>
                        <div class="col-6">  
                        </div>
                    </div>

                    <form action="{{ route('objekpajak.update', ['objekpajak' => $objekpajak->op_id]) }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama Titik Sumur</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="ext : PDAM Kota Sukabumi" value="{{ $objekpajak->op_nama }}" name="op_nama" id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">No IPAT</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Format : 00.00.0.00000000.00.00" value="{{ $objekpajak->nomor_ipat }}" name='nomor_ipat' id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Wajib Pajak</label>
                            <div class="col-sm-10">
                            <select name="wp_id" id="input-name" class="form-control">
                                @foreach($cek2 as $rows)
                                <option value="{{$rows->wp_id}}" >{{__($rows->nama)}}</option>
                                @endforeach  
                                @foreach($combo2 as $row)
                                <option value="{{$row->wp_id}}" >{{__($row->nama)}}</option>
                                @endforeach     
                            </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kriteria</label>
                            <div class="col-sm-10">
                            <select name="kriteria_id" id="input-name" class="form-control">
                                @foreach($cek4 as $rows)
                                <option value="{{$rows->kriteria_id}}" >{{__($rows->kriteria_nama)}}</option>
                                @endforeach  
                                @foreach($combo4 as $row)
                                <option value="{{$row->kriteria_id}}" >{{__($row->kriteria_nama)}}</option>
                                @endforeach   
                            </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Harga Air Baku</label>
                            <div class="col-sm-10">
                            <select name="harga_id" id="input-name" class="form-control">
                                @foreach($cek3 as $rows)
                                <option value="{{$rows->harga_id}}" >{{__($rows->harga_nominal)}} - {{__($rows->harga_jenis)}}</option>
                                @endforeach  
                                @foreach($combo3 as $row)
                                <option value="{{$row->harga_id}}" >{{__($row->harga_nominal)}} - {{__($row->harga_jenis)}}</option>
                                @endforeach   
                            </select>                            
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kelompok</label>
                            <div class="col-sm-10">
                            <select name="kelompok_id" id="input-name" class="form-control">
                                @foreach($cek5 as $rows)
                                <option value="{{$rows->kelompok_id}}" >{{__($rows->kelompok_nama)}} - {{__($rows->kelompok_keterangan)}}</option>
                                @endforeach  
                                @foreach($combo5 as $row)
                                <option value="{{$row->kelompok_id}}" >{{__($row->kelompok_nama)}} - {{__($row->kelompok_keterangan)}}</option>
                                @endforeach 
                            </select>                            
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kelurahan</label>
                            <div class="col-sm-10">
                            <select name="kelurahan_id" id="input-name" class="form-control">
                                @foreach($cek1 as $rows)
                                <option value="{{$rows->kelurahan_id}}" >{{__($rows->kelurahan_nama)}}</option>
                                @endforeach  
                                @foreach($combo1 as $row)
                                <option value="{{$row->kelurahan_id}}" >{{__($row->kelurahan_nama)}}</option>
                                @endforeach 
                            </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Status Meteran</label>
                            <div class="col-sm-10">
                            @if($objekpajak->status_meteran == 0)
                            <select name="status_meteran" id="input-name" class="form-control">
                                <option value="0" >Tidak Ada Meteran</option>
                                <option value="1" >Ada Meteran</option>
                            </select>
                            @else
                            <select name="status_meteran" id="input-name" class="form-control">
                                <option value="1" >Ada Meteran</option>
                                <option value="0" >Tidak Ada Meteran</option>
                            </select>
                            @endif                           
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama Pompa</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Zunitsu" value="{{$objekpajak->mesin_merk}}" name='mesin_merk' id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kapasitas Minimal</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Kapasitas Minimal (Qmin) Pada Pompa" value="{{$objekpajak->kapasitas_minimal}}"  name='kapasitas_minimal' id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kapasitas Maksimal</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Kapasitas Minimal (Qmaks) Pada Pompa" value="{{$objekpajak->kapasitas_maksimal}}" name='kapasitas_maksimal' id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" type="text" name='op_alamat' id="example-text-input">{{$objekpajak->op_alamat}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                        
                        <div class="col-sm-12">
                            <div id="map"></div>
                            <div id="geocoder" class="geocoder"></div>
                        </div>

                        <div class="col-sm-12">
                        <pre id="info"></pre>
                        </div>
                        </div>

                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Latitude</label>
                            <div class="col-sm-10">
                            <input class="form-control" type="number" placeholder="Latitude" name="latitude" value="{{$objekpajak->latitude}}" id="lat" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Longitude</label>
                            <div class="col-sm-10">
                            <input class="form-control" type="number" placeholder="Longitude" name="longitude" value="{{$objekpajak->longitude}}" id="lng" readonly>
                            </div>
                        </div>
                        <button type="submit" class='btn btn-primary float-right'>Submit</button>
                    </form>                    
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

        var marker = new mapboxgl.Popup()
        .setHTML("Lokasi Lama<br>long:"+{{ $objekpajak->longitude }}+"<br>lat:"+{{ $objekpajak->latitude }} )
        .setLngLat([{{ $objekpajak->longitude }},{{ $objekpajak->latitude }}]) 
        .addTo(map);    
        
        map.addControl(
        new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
        })
        );

        map.on('mousemove', function(e) {
                document.getElementById('info').innerHTML =
                JSON.stringify(e.lngLat.wrap());
            
            });
            map.on('click', function(e) {

                document.getElementById('lat').value =  JSON.stringify(e.lngLat.lat);
                document.getElementById('lng').value =  JSON.stringify(e.lngLat.lng);

              
                // tmp marker
                var marker= new mapboxgl.Popup()
                .setHTML("Lokasi Baru ? <br>long:"+JSON.stringify(e.lngLat.lng)+"<br>lat:"+JSON.stringify(e.lngLat.lat) )
                .setLngLat([ JSON.stringify(e.lngLat.lng), JSON.stringify(e.lngLat.lat)])
                .addTo(map);

            });

            map.on('contextmenu', function(e) {
                marker.remove();

        });
        </script>
@endsection