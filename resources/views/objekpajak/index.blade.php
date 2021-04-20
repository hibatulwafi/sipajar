@extends('layouts.app')

@section("head_title", "Master Objek Pajak")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Titik Sumur</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                           Kelola Wajib Pajak > Titik Sumur
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
                    <a class='btn btn-primary float-left' href="{{ route('objekpajak.create') }}"><i class='ti ti-plus'></i> Tambah Data</a>
                   <br> &nbsp; <br>
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
                                <th>ID</th>
                                <th>Nama Objek</th>
                                <th>Wajib Pajak</th>
                                <th>Jenis</th>
                                <th>Alamat</th>
                                <th>Dibuat Pada</th>
                                <th>Terakhir Update</th>
                                <th>Aksi</th>
                            </tr>
                           </thead>
                           <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach($op as $ops)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $ops->op_nama }}</td>
                                <td>{{ $ops->nama }}</td>
                                <td>{{ $ops->kriteria_nama }}</td>
                                <td>{{ $ops->op_alamat }}</td>
                                <td>{{ date('d M Y, H.i.s A', strtotime($ops->created_at))  }}</td>
                                <td>{{ date('d M Y, H.i.s A', strtotime($ops->updated_at))  }}</td>
                                <td>  
                                    <div class="d-inline-flex">
                                        <a href="{{ route('objekpajak.detail', ['objekpajak' => $ops->op_id]) }}"  class='btn btn-success mr-2'>Detail</a>
                                        <a href="{{ route('objekpajak.edit', ['objekpajak' => $ops->op_id]) }}"  class='btn btn-warning mr-2'>Edit</a>
                                        <form action="{{ route('objekpajak.destroy', ['objekpajak' => $ops->op_id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class='btn btn-danger' onclick="return confirm('Yakin Hapus?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @forelse($op as $ops)
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