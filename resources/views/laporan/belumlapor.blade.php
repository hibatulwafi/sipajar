@extends('layouts.app')

@section("head_title", "Laporan")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Kelola Penggunaan</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                           Kelola Penggunaan > Belum Lapor
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                          <thead>
                            <tr> 
                                <th>No</th>
                                <th>Titik Sumur</th>
                                <th>Wajib Pajak</th>
                                <th>Nama Pompa</th>
                                <th>Kapasitas Min</th>
                                <th>Kapasitas Maks</th>
                            </tr>
                           </thead>
                           <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach($qry as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->op_nama }} . {{ $data->op_id }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->mesin_merk }}</td>
                                <td>{{ $data->kapasitas_minimal }}</td>
                                <td>{{ $data->kapasitas_maksimal  }}</td>
                               
                            </tr>
                            @endforeach
                            @forelse($qry as $data)
                            @empty
                            <tr class='text-center'>
                                <td colspan="7">Sudah Lapor Semua</td>
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