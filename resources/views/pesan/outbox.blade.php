@extends('layouts.app')

@section("head_title", "Pesan Masuk")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Pesan</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item ">
                            Pesan
                        </li>
                        <li class="breedcrumb-item active">
                            Pesan Keluar
                        </li> 
                    </ol>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

<div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="email-leftbar card">
                            <a href="{{route('kirimpesan')}}" class="btn btn-success btn-rounded btn-custom btn-block waves-effect waves-light">Buat Pesan</a>

                            <div class="mail-list m-t-20">
                                <a href="{{route('inbox')}}" >Pesan Masuk <span class="ml-1">({{$total}})</span></a>
                                <a href="{{route('outbox')}}" class="active">Pesan Terkirim  <span class="ml-1">({{$outbox}})</span></a>
                                <a href="{{route('trash')}}">Sampah  <span class="ml-1">({{$sampah}})</span></a>
                            </div>
                        </div>
                        <div class="email-rightbar mb-3">
                            
                            <div class="card">
                                <div class="btn-toolbar p-3" role="toolbar">
                                    Pesan Keluar
                                </div>
                                <div class="col-12">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                      <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Penerima</th>
                                            <th>Subjek</th>
                                            <th>Isi</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                       </thead>
                                       <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($pesan as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->user_email }}</td>
                                            <td>{{ $data->pesan_subjek }}</td>
                                            <td>{{ $data->pesan_isi}}</td>
                                            <td>{{ date('d M Y', strtotime($data->tanggal)) }}</td>
                                            <td> 
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-center{{$data->pesan_id }}">
                                                    <i class="far fa-eye"></i>
                                                    </button>
                                                </div>

                                                    <div class="modal fade bs-example-modal-center{{$data->pesan_id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0">Detail Preview</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                            </td>
                                        </tr>
                                        @endforeach
                                        @forelse($pesan as $data)
                                        @empty
                                        <tr class='text-center'>
                                            <td colspan="6">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection