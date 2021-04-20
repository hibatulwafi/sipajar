@extends('layouts.app')

@section("head_title", "Daftar kecamatan")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">kecamatan</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Menampilkan seluruh data kecamatan
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

                    <h4 class="mt-0 mb-4 header-title">Tambah kecamatan</h4>
                    <form action="{{ route('kecamatan.store') }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama kecamatan</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="ext : Gunung Puyuh" name='kecamatan_nama' id="example-text-input" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Kota</label>
                            <div class="col-sm-10">
                            <select name="kota_id" id="input-name" class="form-control">
                                @foreach($combo as $row)
                                <option value="{{$row->kota_id}}" >{{__($row->kota_nama)}}</option>
                                @endforeach
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
