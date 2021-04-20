@extends('layouts.app')

@section("head_title", "Master Harga Air Baku")

@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
            <h4 class="page-title">Harga Air Baku</h4>
                     <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Kelola Parameter</a></li>
                                <li class="breadcrumb-item active">HAB</li>
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
                    <h4 class="mt-0 header-title">List Harga Air Baku</h4>
                    </div>
  
                    <div class="col-6">
                    <div class="card-actions ">
                        <a class='btn btn-primary float-right' href="{{ route('hab.create') }}"><i class='ti ti-plus'></i> Tambah Data</a>
                       
                    </div>
                    </div>
                  </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                  
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row">
                    <div class="col-12">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                     <tr>
                                        <th>Jenis</th>
                                        <th>Harga Per<sup>3</sup></th>
                                      <!--   <th>Status</th> -->
                                        <!-- <th>Aksi</th> -->
                                     </tr>
                                    </thead>


                                    <tbody>
                                     @foreach($hab as $data)
                                        <tr>
                                            <td>{{ $data->harga_jenis }}</td>
                                            <td>{{ $data->harga_nominal }}</td>
                                           <!--  <td> @if($data->harga_status == 1)
                                                <span class="badge badge-success"> Aktif </span>
                                                @elseif($data->harga_status == 0)
                                                <span class="badge badge-success">Non Aktif </span>
                                                @endif
                                            </td> -->
                                          <!--   <td>  
                                                <div class="d-inline-flex">
                                                    <a href="{{ route('hab.edit', ['hab' => $data->harga_id]) }}" class='btn btn-warning mr-2'>Edit</a>
                                                    <form action="{{ route('hab.destroy', ['hab' => $data->harga_id]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class='btn btn-danger' onclick="return confirm('Yakin Hapus?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td> -->
                                        </tr>
                                        @endforeach
                                        @forelse($hab as $data)
                                        @empty
                                        <tr class='text-center'>
                                            <td colspan="6">Tidak ada data</td>
                                        </tr>
                                     @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
</div> <!-- end container-fluid -->
@endsection
