<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Buat Akun</title>
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
                                <h1 class="h4 text-gray-900 mb-4">Buat Akun</h1>
                            </div>
                                {{-- @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Berhasil!</strong> {{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif --}}
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <form class="user" action="{{ route('add_user') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input name="name" type="text" class="form-control form-control-user"
                                            id="exampleInputName" aria-describedby="emailHelp"
                                            placeholder="Masukkan Nama">
                                    </div>
                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Masukkan Email">
                                    </div>
                                    <div class="form-group">
                                        <input name="address" type="address" class="form-control form-control-user"
                                            id="exampleInputaddress" aria-describedby="emailHelp"
                                            placeholder="Masukkan Alamat">
                                    </div>   
                                    <div class="form-group">
                                        <input name="password" type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    
                                    <div class="form-group">
                                        <input name="repassword" type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Ulangi Password">
                                    </div>
                                    <div class="mb-3 d-none" bis_skin_checked="1">
                                        <label for="exampleInputPassword1" class="form-label">Role</label>
                                        <div class="form-check" bis_skin_checked="1">
                                            <input class="form-check-input" type="radio" name="role" id="role2" value="user" checked >
                                            <label class="form-check-label" for="role2">
                                                User
                                            </label>
                                        </div> 
                                        {{-- <div class="form-check" bis_skin_checked="1">
                                            <input class="form-check-input" type="radio" name="role" id="role2" value="user" checked >
                                            <label class="form-check-label" for="role2">
                                                User
                                            </label>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="form-group">
                                        <input name="avatar" type="file" accept="image/*" class="form-control-sm" id="avatar" accept="image/*"
                                            onchange="previewImage(event)" value="avatar-default.png">
                                        <div class="mt-3">
                                            <img id="avatarPreview" class="rounded-circle" src="{{ asset('assets/img/avatar-default.png') }}" alt="Avatar Preview"
                                                style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd;">
                                        </div>
                                    </div> --}}
                                    {{-- @if($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif --}}
                                <button type="submit" class="btn btn-primary btn-user btn-block" style="background-color: #749BC2; border-color: #749BC2">
                                    Submit
                                </button>
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
    <script src="{{asset('landing/asset/js/index.js')}}"></script>

</body>

</html>

{{-- @extends('layouts.main')

@section('container')
<!-- Main Content -->
<div id="content">

    @include('layouts.topbar')

    <!-- Begin Page Content -->
    <div class="container" style="border: 1px solid; ">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Data</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name">
                                @error('name')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email">
                                @error('email')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" id="password">
                                @error('password')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="repassword" class="form-label">Repassword</label>
                                <input name="repassword" type="password" class="form-control @error('repassword') is-invalid @enderror" value="{{ old('repassword') }}" id="repassword">
                                @error('repassword')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 d-none" bis_skin_checked="1">
                                <label for="exampleInputPassword1" class="form-label">Role</label>
                                <div class="form-check" bis_skin_checked="1">
                                    <input class="form-check-input" type="radio" name="role" id="role2" value="user" checked disabled>
                                    <label class="form-check-label" for="role2">
                                        User
                                    </label>
                                </div>                                
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
@endsection --}}
