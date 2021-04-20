@extends('layouts.app')

@section("head_title", "Master Jenis")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Jenis</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Menampilkan seluruh data Jenis
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
                    <h4 class="mt-0 header-title">Daftar Jenis</h4>
                    <p class="text-muted m-b-30 font-14">Berikut adalah data seluruh Jenis</p>
                    </div> 
                  </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    <div class="card-actions ">
                        <a class='btn btn-primary float-left' href="{{ route('jenis.create') }}"><i class='ti ti-plus'></i> Tambah Jenis</a>
                        <form action="" method="get" class='form-inline float-right mb-3'>
                            <input type="text" class="form-control" placeholder='Cari nama..' name='search'>
                            <button type="submit" class='btn btn-primary ml-2'>Cari</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Dibuat Pada</th>
                                <th>Terakhir Update</th>
                                <th>Aksi</th>
                            </tr>
                            @foreach($jenis as $rows)
                            <tr>
                                <td>{{ $rows->jn_id }}</td>
                                <td>{{ $rows->jn_nama }}</td>
                                <td>{{ date('d M Y, H.i.s A', strtotime($rows->dibuat_pada))  }}</td>
                                <td>{{ date('d M Y, H.i.s A', strtotime($rows->diupdate_pada))  }}</td>
                                <td>  
                                    <div class="d-inline-flex">
                                        <a href="{{ route('jenis.edit', ['jeni' => $rows->jn_id]) }}" class='btn btn-warning mr-2'>Edit</a>
                                        <form action="{{ route('jenis.destroy', ['jeni' => $rows->jn_id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class='btn btn-danger' onclick="return confirm('Yakin Hapus?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @forelse($jenis as $rows)
                            @empty
                            <tr class='text-center'>
                                <td colspan="6">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- end container-fluid -->
@endsection
