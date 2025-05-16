<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>
    {{-- <link rel="icon" type="public/img" sizes="16x16" href="{{ asset('assets/img/teeth.png')}}"> --}}
      <link rel="shortcut icon" href="{{asset('landing/asset/icons/teeth.png')}}" type="image/x-icon" />

    <link rel="stylesheet" href="{{asset('landing/asset/css/style.css')}}" />

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

</head>

<body class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="box-login o-hidden shadow">
            <div class="card-body"><!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none bg-login-image d-flex justify-content-center align-items-center">
                        <img src="{{asset('landing/asset/icons/teeth.png')}}" alt="TOMAT" class="hero w-100" style="filter: drop-shadow(10px 10px 20px #749BC2);" />
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Login</h1>
                            </div>
                            @if (session('status'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                            <form class="user" action="{{ route('login_process') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input name="email" type="email" class="form-control form-control-user"
                                        id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Masukkan Email">
                                </div>
                                <div class="form-group">
                                    <input name="password" type="password" class="form-control form-control-user"
                                        id="exampleInputPassword" placeholder="Masukkan Password">
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-user btn-block" style="background-color: #749BC2; border-color: #749BC2">
                                    Login
                                </button>                                
                                <div class="text-center">
                                    <a class="small" href="{{ route('add') }}" style="color: #4682A9">Buat Akun</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/js/demo/datatables-demo.js')}}"></script>
    
</body>

</html>

{{-- @extends('layouts.main')

@section('container')
<!-- Main Content -->
<div id="content">

    @include('layouts.topbar')
    

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-12">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    @if (session('status'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    <form class="user" action="{{ route('login_process') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group mb-5">
                                            <input name="password" type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid --> 

</div>
<!-- End of Main Content -->
@endsection --}}
