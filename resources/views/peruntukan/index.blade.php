    @extends('layouts.app')

@section("head_title", "Master Komponen Peruntukan")

@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
            <h4 class="page-title">Komponen Peruntukan</h4>
                     <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Kelola Parameter</a></li>
                                <li class="breadcrumb-item active">Komponen Peruntukan</li>
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
                    <h4 class="mt-0 header-title">Berikut adalah data Komponen Peruntukan</h4>
                    </div>
  
                    <div class="col-6">
                    <div class="card-actions ">
                        <a class='btn btn-primary float-right' href="{{ route('peruntukan.create') }}"><i class='ti ti-plus'></i> Tambah Data</a>
                       
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
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                     <tr>
                                        <th>Kode</th>
                                        <th width="17%">Volume Pengambilan Peruntukan</th>
                                        <th width="20%">Deskripsi</th>
                                        <th>0 - 50 M<sup>3</sup></th>
                                        <th>51 - 500 M<sup>3</sup></th>
                                        <th>501 - 1000 M<sup>3</sup></th>
                                        <th>1001 - 2500 M<sup>3</sup></th>
                                        <th>> 2500 M<sup>3</sup></th>
                                       <!--  <th>Aksi</th> -->
                                     </tr>
                                    </thead>


                                    <tbody>
                                     @foreach($peruntukan as $data)
                                        <tr>
                                            <td>{{ $data->kelompok_id }}</td>
                                            <td>{{ $data->kelompok_nama }}</td>
                                            <td>{{ $data->kelompok_keterangan }}</td>
                                            <td>{{ $data->kelompok_limapuluh }}</td>
                                            <td>{{ $data->kelompok_limaratus }}</td>
                                            <td>{{ $data->kelompok_seribu }}</td>
                                            <td>{{ $data->kelompok_duaribulima }}</td>
                                            <td>{{ $data->kelompok_lebih }}</td>
                                            <!-- <td>  
                                                <div class="d-inline-flex">
                                                    <a href="{{ route('peruntukan.edit', ['peruntukan' => $data->kelompok_id]) }}" class='btn btn-warning mr-2'>Edit</a>
                                                    <form action="{{ route('peruntukan.destroy', ['peruntukan' => $data->kelompok_id]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class='btn btn-danger' onclick="return confirm('Yakin Hapus?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td> -->
                                        </tr>
                                        @endforeach
                                        @forelse($peruntukan as $data)
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
