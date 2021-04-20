@extends('layouts.app')

@section("head_title", "Master kecamatan")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
            <h4 class="page-title">Kecamatan</h4>
                     <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Kelola Parameter</a></li>
                                <li class="breadcrumb-item active">Kecamatan</li>
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
                    <h4 class="mt-0 header-title">Daftar Kecamatan</h4>
                    <p class="text-muted m-b-30 font-14">Berikut adalah data seluruh Kecamatan</p>
                    </div>

                    <div class="col-6">
                    <div class = "float-right">
                    <a href="{{ route('kota.index') }}"  class='btn btn-info mr-2'><i class="ti-home"></i> kota</a>
                    <a href="{{ route('kecamatan.index') }}"  class='btn btn-warning mr-2'><i class="ti-home"></i> kecamatan</a>
                    <a href="{{ route('kelurahan.index') }}"  class='btn btn-info mr-2'><i class="ti-home"></i> Kelurahan</a>
                    </div>
                    </div>  
                  </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    <div class="card-actions ">
                        <a class='btn btn-primary float-left' href="{{ route('kecamatan.create') }}"><i class='ti ti-plus'></i> Tambah kecamatan</a>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

        <div class="row">
                    <div class="col-12">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead> 
                                <tr>
                                <th>ID</th>
                                <th>Kecamatan</th>
                                <th>Kota</th>
                                <th>Aksi</th>
                                </thead>

                          <tbody>
                            </tr>
                            @foreach($kecamatans as $kecamatan)
                            <tr>
                                <td>{{ $kecamatan->kecamatan_id }}</td>
                                <td>{{ $kecamatan->kecamatan_nama }}</td>
                                <td>{{ $kecamatan->kota_nama }}</td>
                                <td>  
                                    <div class="d-inline-flex">
                                        <a href="{{ route('kecamatan.edit', ['kecamatan' => $kecamatan->kecamatan_id]) }}" class='btn btn-warning mr-2'>Edit</a>
                                        <form action="{{ route('kecamatan.destroy', ['kecamatan' => $kecamatan->kecamatan_id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class='btn btn-danger' onclick="return confirm('Yakin Hapus?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @forelse($kecamatans as $kecamatan)
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
