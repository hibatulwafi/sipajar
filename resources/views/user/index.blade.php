@extends('layouts.app')

@section("head_title", "Daftar Pengguna")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Pengguna</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Menampilkan seluruh data pengguna
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
                    <h4 class="mt-0 header-title">Pengguna</h4>
                    <p class="text-muted m-b-30 font-14">Berikut adalah data seluruh pengguna</p>
                  </div>
                  <div class="col-6">
                    <a class='btn btn-primary float-right' href="{{ route('pengguna.create') }}"><i class='ti ti-plus'></i> Tambah Pengguna</a>
                  </div>
                  </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                          <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($user as $data)
                            <tr>
                                <td>{{ $data->user_email }}</td>
                                <td>{{ $data->user_first_name }}</td>
                                <td>{{ $data->user_role_name }}</td>
                                <td><span class="badge badge-{{ $data->user_status == 'Aktif' ? 'success' : 'danger' }}">{{ $data->user_status }}</span></td>
                                <td>  
                                    <div class="d-inline-flex">
                                        <a href="{{ route('pengguna.edit', ['pengguna' => $data->id]) }}" class='btn btn-warning mr-2'>Edit</a>
                                        <form action="{{ route('pengguna.destroy', ['pengguna' => $data->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class='btn btn-danger'>Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @forelse($user as $data)
                            @empty
                            <tr>
                                <td colspan="6">Tidak ada data</td>
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
