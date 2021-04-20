@extends('layouts.app')

@section("head_title", "Laporan")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Titik Sumur</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                           Kelola Penggunaan > Laporan Masuk
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
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                          <thead>
                            <tr>
                                <th>No</th>
                                <th>Titik Sumur</th>
                                <th>Wajib Pajak</th>
                                <th>Bulan</th>
                                <th>Meteran</th>
                                <th>Validasi</th>
                                <th>Dibuat Pada</th>
                                <th>Aksi</th>
                            </tr>
                           </thead>
                           <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach($qry as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->op_nama }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->foto_bulan."/".$data->foto_tahun }}</td>
                                <td>{{ $data->meter }}</td>
                                <td> <center>
                                @if($data->status_validasi == 0)
                                    <span class="badge badge-warning"> Sedang Evaluasi </span>
                                @elseif($data->status_validasi == 1)
                                    <span class="badge badge-danger"> Ditolak </span>
                                @elseif($data->status_validasi == 2)
                                    <span class="badge badge-success"> Diterima </span>
                                @else
                                    <span class="badge badge-info"> Error </span>
                                @endif
                                </center>
                                </td>
                                <td>{{ date('d M Y', strtotime($data->created_at)) }}</td>
                                <td> 
                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-center{{$data->foto_id }}">
                                        <i class="far fa-eye"></i>
                                        </button>

                                        <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg{{$data->foto_id }}">
                                        <i class="mdi mdi-checkbox-marked-outline"></i>
                                        </button>
                                        
                                    </div>

                                        <div class="modal fade bs-example-modal-center{{$data->foto_id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0">Image Preview</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <img width="100%" src="{{ $data->path.$data->foto_gambar }}"  >
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        <div class="modal fade bs-example-modal-lg{{$data->foto_id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0"> Verifikasi Laporan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div class="row">

                                                    <div class="col-sm-6">
                                                    <img width="100%" src="{{ $data->path.$data->foto_gambar }}"  >
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <form action="{{ route('laporan.terima') }}" method="post" enctype='multipart/form-data'>
                                                    @csrf
                                                        <div class="form-group row">
                                                        <div class="col-sm-12">
                                                        <h4> {{ $data->meter}} M<sup>3</sup> </h4> <br>
                                                        </div>
                                                            <div class="col-sm-12">
                                                            <label class=" col-form-label">Ubah Meteran</label>
                                                            <input class="form-control" type="hidden" value="{{ $data->foto_id}}" placeholder="meter" name="foto_id" id="foto_id" >
                                                            <input class="form-control" type="number" value="{{ $data->meter}}" placeholder="meter" name="meter" id="meter" >
                                                            </div>
                                                        </div>

                                                    <button type="submit" class='btn btn-primary float-right'>Terima</button>

                                                    @if($data->status_input == 0)
                                                    <a href="{{route('laporan.tolak' , $data->foto_id )}}"  class="btn btn-danger waves-effect waves-light" >
                                                    Tolak
                                                    </a>
                                                    @endif
                                                    </form>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                </td>
                            </tr>
                            @endforeach
                            @forelse($qry as $data)
                            @empty
                            <tr class='text-center'>
                                <td colspan="8">Tidak ada data</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- end container-fluid -->
@endsection

