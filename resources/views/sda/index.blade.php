@extends('layouts.app')

@section("head_title", "Master Komponen Sumber Daya Alam")

@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
            <h4 class="page-title">Komponen Sumber Daya Alam</h4>
                     <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Kelola Parameter</a></li>
                                <li class="breadcrumb-item active">sda</li>
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
                <!-- <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                    <h4 class="mt-0 header-title">Berikut adalah Kriteria SDA</h4>
                    </div>
  
                    <div class="col-6">
                    <div class="card-actions ">
                        <a class='btn btn-primary float-right' href="{{ route('sda.create') }}"><i class='ti ti-plus'></i> Tambah Data</a>
                       
                    </div>
                    </div>
                  </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                  
                </div> -->
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
                                        <th>Nama</th>
                                        <th>Peringkat</th>
                                        <th>Bobot</th>
                                        <!-- <th>Aksi</th> -->
                                     </tr>
                                    </thead>


                                    <tbody>
                                     @foreach($sda as $data)
                                        <tr>
                                            <td>{{ $data->kriteria_nama }}</td>
                                            <td>{{ $data->kriteria_peringkat }}</td>
                                            <td>{{ $data->kriteria_bobot }}</td>
                                           <!--  <td>  
                                                <div class="d-inline-flex">
                                                    <a href="{{ route('sda.edit', ['sda' => $data->kriteria_id]) }}" class='btn btn-warning mr-2'>Edit</a>
                                                    <form action="{{ route('sda.destroy', ['sda' => $data->kriteria_id]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class='btn btn-danger' onclick="return confirm('Yakin Hapus?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td> -->
                                        </tr>
                                        @endforeach
                                        @forelse($sda as $data)
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
