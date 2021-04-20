@extends('layouts.app')

@section("head_title", "Harga Air Baku")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Harga Air Baku</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Harga Air Baku
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

                    <h4 class="mt-0 mb-4 header-title">Tambah Data</h4>
                    <form action="{{ route('hab.store') }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama Jenis</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="ext : Air Dalam" name='harga_jenis' id="example-text-input" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nominal</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="ext : 3000" name='harga_nominal' id="example-text-input" >
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
