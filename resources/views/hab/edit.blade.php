@extends('layouts.app')

@section("head_title", "Daftar HAB")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Harga Air Baku</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Menampilkan seluruh data HAB
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

                    <h4 class="mt-0 mb-4 header-title">Edit Data</h4>
                    <form action="{{ route('hab.update', ['hab' => $hab->harga_id]) }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Jenis </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="" name='harga_jenis' id="example-text-input" value="{{ $hab->harga_jenis }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nominal </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="" name='harga_nominal' id="example-text-input" value="{{ $hab->harga_nominal }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" id="role" class="form-control">
                                    <option value="1" {{ $hab->harga_status == '1' ? "selected" : "" }}>Aktif</option>
                                    <option value="0" {{ $hab->harga_status == '0' ? "selected" : "" }}>Tidak Aktif</option>
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
