@extends('layouts.app')

@section("head_title", "Master Wajib Pajak")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Wajib Pajak</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Menampilkan seluruh data Wajib Pajak yang terdaftar pada Sipairman (Sistem Infomasi Pajak Air Permukaan)
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
                    <h4 class="mt-0 header-title">Tabel Daftar Wajib Pajak</h4>
                    </div>
                    <div class="col-6">
                    <div class="card-actions ">
                        <a class='btn btn-primary float-right' href="{{ route('wajibpajak.create') }}"><i class='ti ti-plus'></i> Tambah Wajib Pajak</a>
                    </div>
                    </div>
                  </div>
                  <p><p>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif 
                    @if(session('false'))
                        <div class="alert alert-danger">
                            {{session('false')}}
                        </div>
                    @endif 
                                   
                    <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>NPWPD</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Tanggal Daftar</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            </tbody>
                            @php
                            $no=1;
                            @endphp
                            @foreach($wp as $wps)
                            <tr>
                                <td>{{ $no++}}</td>
                                <td>{{ $wps->npwpd }}</td>
                                <td>{{ $wps->nama }}</td>
                                <td>{{ $wps->alamat }}</td>
                                <td>{{ $wps->tanggal_daftar }}</td>
                                <td>{{ $wps->keterangan }}</td>
                                <td>  
                                    <div class="d-inline-flex">
                                        <a href="{{ route('wajibpajak.edit', ['wajibpajak' => $wps->wp_id]) }}"  class='btn btn-warning mr-2'>Manage</a>
                                       <!--  <form action="{{ route('wajibpajak.destroy', ['wajibpajak' => $wps->wp_id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class='btn btn-danger' onclick="return confirm('Yakin Hapus?')">Delete</button>
                                        </form> -->
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @forelse($wp as $wps)
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
