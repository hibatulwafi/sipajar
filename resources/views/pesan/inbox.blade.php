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
                            Pesan Masuk
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
                                <a href="{{route('inbox')}}" class="active">Pesan Masuk <span class="ml-1">({{$total}})</span></a>
                                <a href="{{route('outbox')}}">Pesan Terkirim  <span class="ml-1">({{$outbox}})</span></a>
                                <a href="{{route('trash')}}">Sampah  <span class="ml-1">({{$sampah}})</span></a>
                            </div>
                        </div>
                        <div class="email-rightbar mb-3">
                            
                            <div class="card">
                                <div class="btn-toolbar p-3" role="toolbar">
                                    Pesan Masuk
                                </div>
                                <div class="col-12">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                      <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pengirim</th>
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
                                                    <a href="{{route('delete' , $data->pesan_id )}}"  class="btn btn-danger waves-effect waves-light">
                                                    <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    </a>
                                                </div>
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