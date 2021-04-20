@extends('layouts.app')

@section("head_title", "Daftar Titik Sumur")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Titik Sumur</h4>
                    
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

                    <h4 class="mt-0 mb-4 header-title">Tambah Titik Sumur</h4>
                    <form action="{{ route('objekpajak.store') }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama Titik Sumur</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="ext : PDAM Kota Sukabumi" name="op_nama" id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">No IPAT</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Format : 00.00.0.00000000.00.00" name='nomor_ipat' id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Wajib Pajak</label>
                            <div class="col-sm-10">
                            <select name="wp_id" id="input-name" class="form-control">
                                @foreach($combo3 as $row)
                                <option value="{{$row->wp_id}}" >{{__($row->nama)}}</option>
                                @endforeach
                            </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kriteria</label>
                            <div class="col-sm-10">
                            <select name="kriteria_id" id="input-name" class="form-control">
                                @foreach($combo1 as $row)
                                <option value="{{$row->kriteria_id}}" >{{__($row->kriteria_nama)}}</option>
                                @endforeach
                            </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Harga Air Baku</label>
                            <div class="col-sm-10">
                            <select name="harga_id" id="input-name" class="form-control">
                                @foreach($combo4 as $row)
                                <option value="{{$row->harga_id}}" >{{__($row->harga_nominal)}} - {{__($row->harga_jenis)}}</option>
                                @endforeach
                            </select>                            
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kelompok</label>
                            <div class="col-sm-10">
                            <select name="kelompok_id" id="input-name" class="form-control">
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
                                @foreach($combo2 as $row)
                                <option value="{{$row->kelurahan_id}}" >{{__($row->kelurahan_nama)}}</option>
                                @endforeach
                            </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Status Meteran</label>
                            <div class="col-sm-10">
                            <select name="status_meteran" id="input-name" class="form-control">
                                <option value="1" >Ada Meteran</option>
                                <option value="0" >Tidak Ada Meteran</option>
                            </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama Pompa</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Zunitsu" name='mesin_merk' id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kapasitas Minimal</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Kapasitas Minimal (Qmin) Pada Pompa" name='kapasitas_minimal' id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kapasitas Maksimal</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Kapasitas Minimal (Qmaks) Pada Pompa" name='kapasitas_maksimal' id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" type="text" name='op_alamat' id="example-text-input">
                                </textarea>
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
                            <input class="form-control" type="number" placeholder="Latitude" name="latitude" id="lat" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Longitude</label>
                            <div class="col-sm-10">
                            <input class="form-control" type="number" placeholder="Longitude" name="longitude" id="lng" readonly>
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
                .setHTML("Disini ? <br>long:"+JSON.stringify(e.lngLat.lng)+"<br>lat:"+JSON.stringify(e.lngLat.lat) )
                .setLngLat([ JSON.stringify(e.lngLat.lng), JSON.stringify(e.lngLat.lat)])
                .addTo(map);

            });

            map.on('contextmenu', function(e) {
                marker.remove();

        });
        </script>
@endsection