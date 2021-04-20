<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>@yield('head_title') - {{ env('APP_NAME') }}</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="{{ asset('/images/applogo.png')}}">

        <link rel="stylesheet" href="{{ asset('/plugins/morris/morris.css')}}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('/css/style.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('/css/peta.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" >
        
        <script src="{{ asset('js/custom.js') }}"></script>
        <script language="JavaScript" type="text/javascript" src="{{ asset('js/simulasi.js') }}">
        </script>
        <!-- DataTables -->
        <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/plugins/ion-rangeslider/ion.rangeSlider.skinModern.css')}}" rel="stylesheet" type="text/css"/>

       <!-- buat map -->
       
        <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
        <script src="{{ url('https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js') }}"></script>
        <link href="{{ url('https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css') }}" rel="stylesheet" />
       <!-- Sweet Alert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

        @stack('styles')
    </head>

    <body>
         <!-- buat map -->
        <script src="{{ url('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js') }}"></script>
        <link
        rel="stylesheet"
        href="{{ url('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css') }}"
        type="text/css"
        />
        <!-- Promise polyfill script required to use Mapbox GL Geocoder in IE 11 -->
        <script src="{{ url('https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js') }}"></script>
        <script src="{{ url('https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js') }}"></script>
        <style>
	#map { width: 98%; }
</style>
        <div id="app">

        <!-- Navigation Bar-->
            <header id="topnav">
                <div class="topbar-main">
                    <div class="container-fluid">

                        <!-- Logo container-->
                        <div class="logo">
                            
                            <a href="index.html" class="logo">
                                <img src="{{ asset('/images/logo-sm.png')}}" alt="" class="logo-small">
                                <img src="{{ asset('/images/logo npa 2.png')}}" alt="" class="logo-large">
                            </a>

                        </div>
                        <!-- End Logo container-->


                        <div class="menu-extras topbar-custom">

                            <ul class="float-right list-unstyled mb-0 ">
                                
                              
                                <li class="dropdown notification-list">
                                    <div class="dropdown notification-list nav-pro-img">
                                        <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <img src="images/ava3.png" alt="user" class="rounded-circle">
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                            <!-- item-->
                                            <form method="POST" action="{{route('logout')}}">
                                                @csrf
                                                <button type="submit" class="d-none" id='logout'></button>
                                                <a class="dropdown-item text-danger" onclick="$('#logout').click()"><i class="mdi mdi-power text-danger"></i> Logout</a>
                                            </form>
                                        </div>                                                                    
                                    </div>
                                </li>
                                <li class="menu-item">
                                    <!-- Mobile menu toggle-->
                                    <a class="navbar-toggle nav-link" id="mobileToggle">
                                        <div class="lines">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </a>
                                    <!-- End mobile menu toggle-->
                                </li>    
                            </ul>
                        </div>
                        <!-- end menu-extras -->

                        <div class="clearfix"></div>

                    </div> <!-- end container -->
                </div>
                <!-- end topbar-main -->

                @yield('title')

                <!-- MENU Start -->
                <div class="navbar-custom">
                    <div class="container-fluid">
                        <div id="navigation">
                            <!-- Navigation Menu-->
                            <ul class="navigation-menu">

                                <li class="has-submenu">
                                    <a href="{{ url('/home') }}">
                                        <i class="ti-dashboard"></i>
                                        <span>Home</span>
                                    </a>
                                </li>            
                                @if(Auth::guard('login')->user()->user_role_id == 1)
                                <li class="has-submenu">
                                    <a href="{{ route('pengguna.index') }}"><i class="ti-user"></i>Admin</a>
                                </li>
                                <li class="has-submenu">
                                <a href="#"><i class="ti-menu-alt"></i>Kelola Parameter</a>
                                <ul class="submenu">
                                    <li class="has-submenu">
                                        <a href="#">Area</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('kota.index') }}">Kota</a></li>
                                            <li><a href="{{ route('kecamatan.index') }}">Kecamatan</a></li>
                                            <li><a href="{{ route('kelurahan.index') }}">Kelurahan</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li>
                                        <a href="{{ route('hab.index') }}">Harga Air Baku</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('sda.index') }}">Komponen SDA</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('peruntukan.index') }}">Komponen Peruntukan</a>
                                    </li>
                                </ul>
                                </li>
                                @endif

                                <li class="has-submenu">
                                    <a href="#"><i class="far fa-id-card"></i>Kelola Wajib Pajak</a>
                                    <ul class="submenu">
                                    <li>
                                        <a href="{{ route('wajibpajak.index') }}">Wajib Pajak</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('objekpajak.index') }}">Titik Sumur</a>
                                    </li>
                                    <!--  
                                    <li>
                                        <a href="{{ route('peruntukan.index') }}">Aktivasi Akun</a>
                                    </li>
                                    -->
                                   
                                    <li>
                                        <a href="{{ route('wajibpajak.create') }}">Registrasi Wajib Pajak</a>
                                    </li> 
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="#"><i class="fas fa-calculator"></i>Kelola Penggunaan</a>
                                    <ul class="submenu">
                                    <li>
                                        <a href="{{ route('laporan.nonmeter') }}">Generate</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('laporan.belumlapor') }}">Belum Melaporkan</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('laporan.index') }}">Laporan Masuk</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('tagihan.index') }}">Tagihan Pajak</a>
                                    </li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                <a href="#"><i class="ti-email"></i>Pesan</a>
                                <ul class="submenu">
                                    <li><a href="{{route('inbox')}}">Pesan Masuk</a></li>
                                    <li><a href="{{route('outbox')}}">Pesan Keluar</a></li>
                                    <li><a href="{{route('kirimpesan')}}">Kirim Pesan</a></li>
                                </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="{{ route('cetak.laporan') }}"><i class="fas fa-book"></i>Laporan </a>
                                </li>
                                
                                <li class="has-submenu">
                                    <a href="{{ route('simulasi') }}"><i class="fa fa-superscript"></i>Simulasi </a>
                                </li>


                            </ul>
                            <!-- End navigation menu -->
                        </div> <!-- end navigation -->
                    </div> <!-- end container-fluid -->
                </div> <!-- end navbar-custom -->
            </header>
            <!-- End Navigation Bar-->

            <div class="wrapper">
                @yield('content')
            </div>
            <!-- end wrapper -->

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            © 2020 Pajak Air Permukaan <span class="d-none d-sm-inline-block"> - Crafted with -  by Hw</span>.
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- End Footer -->

        <!-- jQuery  -->
        <script src="{{asset('/js/jquery.min.js') }}"></script>
        <script src="{{asset('/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{asset('/js/jquery.slimscroll.js') }}"></script>
        <script src="{{asset('/js/waves.min.js') }}"></script>
        <script src="{{asset('/js/lokasi.js') }}"></script>

        <script src="{{asset('/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
        @stack('scripts')

        <!-- App js -->
        <script src="{{ asset(mix('/js/app.js')) }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
          <!-- Required datatable js -->
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/datatables/jszip.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

        <!-- Datatable init js -->
        <script src="{{ asset('assets/pages/datatables.init.js')}}"></script>

        @yield('map')
        @yield('script')
        
    </body>
</html>