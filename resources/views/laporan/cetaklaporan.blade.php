@extends('layouts.app')

@section("head_title", "Laporan")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Titik Sumur</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                           Kelola Penggunaan > Tagihan
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
        
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
            </div>
            @endif

            <div class="card m-b-20">
               <div class="card-body"> <!-- 
                        <div class="float-right ">
                        <form class="form-inline" action="{{ route('cetak.laporan') }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        <input class="form-control" type="text" placeholder="Bulan : 9" name='bulan' id="example-text-input" required>
                        &nbsp;
                        <input class="form-control" type="text" placeholder="Tahun : 2020" name='tahun' id="example-text-input" required>
                        &nbsp;
                        <button type="submit" class='btn btn-primary '>Print  &nbsp; <i class ="fas fa-print" > </i></button>
                       
                        </form> 
                        </div> -->
                    <div class="table-responsive">
                        </br>
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                          <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Perusahaan</th>
                                <th>Alamat</th>
                                <th>Wajib Pajak</th>
                                <th>Bulan</th>
                                <th>Volume (M<sup>3</sup>)</th>
                                <th>Pajak</th>
                                <th>NPA</th>
                                <th>Dibuat Pada</th>
                            </tr>
                           </thead>
                           <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach($qry as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->op_nama }}</td>
                                <td>{{ $data->op_alamat }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->bulan."/".$data->tahun }}</td>
                                <td>{{ $data->pemakaian }}</td>
                                <td>@currency($data->biaya_bayar)</td>
                                <td>@currency($data->tarif)</td>
                                <td>{{ date('d M Y', strtotime($data->created_at)) }}</td>
                                
                            </tr>
                            @endforeach
                            @forelse($qry as $data)
                            @empty
                            <tr class='text-center'>
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