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

                    <h4 class="mt-0 mb-4 header-title">Ubah Pengguna</h4>
                    <form action="{{ route('pengguna.update', ['pengguna' => $user->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama Depan</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Masukkan nama" name='nama_depan' id="example-text-input" value="{{ $user->user_first_name }}">
                            </div>
                        </div><div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama Belakang</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Masukkan nama" name='nama_belakang' id="example-text-input" value="{{ $user->user_last_name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Masukkan nama" name='email' id="example-text-input" value="{{ $user->user_email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="password" name='password' name='password' placeholder="Isi jika ingin diubah" id="example-text-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                                <select name="role" id="role" class="form-control">
                                    @foreach($roles as $role)
                                    <option value="{{ $role->user_role_id }}" {{$user->user_role_id == $role->user_role_id ? 'selected' : ''}}>{{ $role->user_role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" id="role" class="form-control">
                                    <option value="Aktif" {{ $user->user_status == 'Aktif' ? "selected" : "" }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ $user->user_status == 'Tidak Aktif' ? "selected" : "" }}>Tidak Aktif</option>
                                </select>
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
