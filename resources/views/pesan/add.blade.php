@extends('layouts.app')

@section("head_title", "Daftar kota")
@section("title")
<div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" id="breadcrumb">
                    <h4 class="page-title">Pesan</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item ">
                            Pesan
                        </li>
                        <li class="breedcrumb-item active">
                            Kirim Pesan
                        </li> 
                    </ol>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content') <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Left sidebar -->
                        <div class="email-leftbar card">
                            <a href="{{route('kirimpesan')}}" class="btn btn-danger btn-rounded btn-custom btn-block waves-effect waves-light">Buat Pesan</a>

                            <div class="mail-list m-t-20">
                                <a href="{{route('inbox')}}">Pesan Masuk <span class="ml-1">({{$total}})</span></a>
                                <a href="{{route('outbox')}}">Pesan Terkirim  <span class="ml-1">({{$outbox}})</span></a>
                                <a href="{{route('trash')}}">Sampah  <span class="ml-1">({{$sampah}})</span></a>
                            </div>
                        </div>
                        <!-- End Left sidebar -->


                        <!-- Right Sidebar -->
                        <div class="email-rightbar mb-3">

                            <div class="card">
                                <div class="card-body">

                                    <form action="{{ route('kirimpesan') }}" method="post" enctype='multipart/form-data'>
                                    @csrf
                                        
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-1 col-form-label">To</label>
                                            <div class="col-sm-11">
                                            <select name="penerima" id="input-name" class="form-control">
                                                @foreach($wp as $row)
                                                <option value="{{$row->wp_id}}" >{{__($row->email)}}</option>
                                                @endforeach
                                            </select>                            
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="pesan_subjek" class="form-control" placeholder="Subject">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" type="text" name='pesan_isi' id="example-text-input"></textarea>
                                        </div>

                                        <div class="btn-toolbar form-group mb-0">
                                            <div class="">
                                                <button class="btn btn-primary waves-effect waves-light"> <span>Kirim</span> <i class="fab fa-telegram-plane m-l-10"></i> </button>
                                            </div>
                                        </div>

                                    </form>

                                </div>

                            </div>


                        </div> <!-- end Col-9 -->

                    </div>

                </div><!-- End row -->

            </div> <!-- end container-fluid -->
@endsection