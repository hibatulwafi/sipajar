@extends('layouts.app')

@section("head_title", "Daftar wajibpajak")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">wajibpajak</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Menampilkan seluruh data wajibpajak
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
                         <h4 class="header-title float-right "> Terdaftar Sejak : {{ date('d M Y', strtotime($wajibpajak->tanggal_daftar)) }} </h4>

                    <div class="row">
                        <div class="col-6">  
                        <h4 class="header-title">Edit Wajib Pajak </h4>
                        </div>
                    </div>

                    <form action="{{ route('wajibpajak.update', ['wajibpajak' => $wajibpajak->wp_id]) }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nama </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="" name='nama' id="example-text-input" value="{{ $wajibpajak->nama }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">NPWPD </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="" name='npwpd' id="example-text-input" value="{{ $wajibpajak->npwpd }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                            <select name="status_wp" id="input-name" class="form-control">
                                <option value="1" >Aktif</option>
                                <option value="0" >Non Aktifkan</option>
                            </select>                       
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" type="text" name='alamat' id="example-text-input">{{ __(($wajibpajak->alamat)) }}</textarea>
                            </div>
                        </div>

                        <button type="submit"  onclick="confirm" class='btn btn-primary float-right remove-user'>Submit</button>
                    </form>    

                         <form action="{{ route('wajibpajak.resetpassword', ['wajibpajak' => $wajibpajak->wp_id]) }}" method="get">
                             @csrf
                             <button type="submit" class='btn btn-danger' onclick="return confirm('Yakin Reset Password {{ $wajibpajak->nama }}?')">Reset Password</button>
                         </form>                
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- end container-fluid -->
@endsection


@section('script')
      
@endsection
