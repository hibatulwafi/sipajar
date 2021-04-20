@extends('layouts.app')

@section("head_title", "Home")
@section("title")

<link href="{{ asset('/css/style1.css')}}" rel="stylesheet" type="text/css">
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
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

                    <h4 class="mt-0 mb-4 header-title">Simulasi Perhitungan</h4>
                    <form action="{{ route('simulasipost') }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama Titik Sumur</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="ex : Politeknik Sukabumi" name="op_nama" id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">No Wajib Pajak</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="ex : Hibatul Wafi" name='wp_nama' id="example-text-input" required>
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
                                @foreach($combo2 as $row)
                                <option value="{{$row->harga_id}}" >{{__($row->harga_nominal)}} - {{__($row->harga_jenis)}}</option>
                                @endforeach
                            </select>                            
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kelompok</label>
                            <div class="col-sm-10">
                            <select name="kelompok_id" id="input-name" class="form-control">
                                @foreach($combo3 as $row)
                                <option value="{{$row->kelompok_id}}" >{{__($row->kelompok_nama)}} - {{__($row->kelompok_keterangan)}}</option>
                                @endforeach
                            </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Meter (M<sup>3</sup>)</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Kapasitas Pada Meteran" name='meter' id="example-text-input" required>
                            </div>
                        </div>

                        <button type="submit" class='btn btn-primary float-right'>Submit</button>
                    </form>    

                    <div class="row col-sm-12">
                    <h4 class="mt-0 mb-4 header-title">Komponen Sumber Daya Alam</h4>
                    </div>

                    <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                         <tr>
                            <th>Nama</th>
                            <th>Peringkat</th>
                            <th>Bobot</th>
                         </tr>
                        </thead>


                        <tbody>
                          @foreach($combo1 as $data)
                            <tr>
                             <td>{{ $data->kriteria_nama }}</td>
                             <td>{{ $data->kriteria_peringkat }}</td>
                             <td>{{ $data->kriteria_bobot }}</td>
                            </tr>
                            @endforeach
                            @forelse($combo1 as $data)
                            @empty
                            <tr class='text-center'>
                                <td colspan="6">Tidak ada data</td>
                            </tr>
                           @endforelse
                        </tbody>
                    </table>

                    <div class="row col-sm-12">
                    <h4 class="mt-0 mb-4 header-title">Harga Air Baku</h4>
                    </div>

                    <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                         <tr>
                            <th>Jenis</th>
                            <th>Harga Per<sup>3</sup></th>
                            <th>Status</th>
                         </tr>
                        </thead>


                        <tbody>
                          @foreach($combo2 as $data)
                            <tr>
                              <td>{{ $data->harga_jenis }}</td>
                              <td>{{ $data->harga_nominal }}</td>
                              <td> @if($data->harga_status == 1)
                                  <span class="badge badge-success"> Aktif </span>
                                  @elseif($data->harga_status == 0)
                                  <span class="badge badge-success">Non Aktif </span>
                                  @endif
                              </td>
                            </tr>
                            @endforeach
                            @forelse($combo2 as $data)
                            @empty
                            <tr class='text-center'>
                                <td colspan="6">Tidak ada data</td>
                            </tr>
                           @endforelse
                        </tbody>
                    </table>

                    <div class="row col-sm-12">
                    <h4 class="mt-0 mb-4 header-title">Komponen Peruntukan dan Pengelolaan Air Tanah</h4>
                    </div>

                    <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                         <tr>
                            <th width="17%">Volume Pengambilan Peruntukan</th>
                            <th width="20%">Deskripsi</th>
                            <th>0 - 50 M<sup>3</sup></th>
                            <th>51 - 500 M<sup>3</sup></th>
                            <th>501 - 1000 M<sup>3</sup></th>
                            <th>1001 - 2500 M<sup>3</sup></th>
                            <th>> 2500 M<sup>3</sup></th>
                         </tr>
                        </thead>


                        <tbody>
                          @foreach($combo3 as $data)
                            <tr>
                               <td>{{ $data->kelompok_nama }}</td>
                               <td>{{ $data->kelompok_keterangan }}</td>
                               <td>{{ $data->kelompok_limapuluh }}</td>
                               <td>{{ $data->kelompok_limaratus }}</td>
                               <td>{{ $data->kelompok_seribu }}</td>
                               <td>{{ $data->kelompok_duaribulima }}</td>
                               <td>{{ $data->kelompok_lebih }}</td>
                            </tr>
                            @endforeach
                            @forelse($combo3 as $data)
                            @empty
                            <tr class='text-center'>
                                <td colspan="6">Tidak ada data</td>
                            </tr>
                           @endforelse
                        </tbody>
                    </table>
                                                            
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

</div> <!-- end container-fluid -->
@endsection
