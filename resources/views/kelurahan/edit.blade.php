@extends('layouts.app')

@section("head_title", "Daftar kelurahan")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">kelurahan</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Menampilkan seluruh data kelurahan
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

                    <h4 class="mt-0 mb-4 header-title">Edit kelurahan</h4>
                    <form action="{{ route('kelurahan.update', ['kelurahan' => $kelurahan->kelurahan_id]) }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="" name='kelurahan_nama' id="example-text-input" value="{{ $kelurahan->kelurahan_nama }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama </label>
                            <div class="col-sm-10">
                            <select name="kecamatan_id" id="input-name" class="form-control">
                            
                                @foreach($cek as $rows)
                                <option value="{{$rows->kecamatan_id}}" >{{__($rows->kecamatan_nama)}}</option>
                                @endforeach  
                                @foreach($kecamatan as $row)
                                <option value="{{$row->kecamatan_id}}" >{{__($row->kecamatan_nama)}}</option>
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
