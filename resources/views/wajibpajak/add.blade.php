@extends('layouts.app')

@section("head_title", "Registrasi Wajib Pajak")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Registrasi</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Registrasi Wajib Pajak
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

                    <h4 class="mt-0 mb-4 header-title">Form Registrasi</h4>
                    <form action="{{ route('wajibpajak.store') }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Daftar</label>
                            <div class="col-sm-10">
                            <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="tanggal_daftar" id="datepicker-autoclose" required>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="ext : Hibatul Wafi Putra" name='nama' id="example-text-input" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">No NPWPD</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Format : 00.00.0.00000000.00.00" name='npwpd' id="example-text-input" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" type="text" name='alamat' id="example-text-input" required>
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                        
                        <div class="col-sm-4"></div>
                            <div class="alert alert-success col-sm-6">
                            <center> <i class="ti-info"></i> Email dan password untuk Wajib Pajak melakukan login ke dalam sistem , masukan alamat email yang valid</center>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Email / Username</label>
                            <div class="col-sm-10">
                            <input class="form-control" type="email" placeholder="Email Untuk Login" name='email' id="example-text-input" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">No Telp</label>
                            <div class="col-sm-10">
                            <input class="form-control" type="number" placeholder="0858 xxxx xxxx" name='notelp' id="example-text-input" required>
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
