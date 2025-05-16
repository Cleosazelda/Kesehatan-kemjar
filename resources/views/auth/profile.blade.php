@extends('layouts.main')

@section('container')
<!-- Main Content -->
<div id="content">

    @include('layouts.topbar')

    <!-- Begin Page Content -->
    <div class="container-fluid">

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
                        <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update', auth()->user()->id) }}" method="post">
                        @csrf
                        @method('put')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" id="name">
                                @error('name')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', auth()->user()->address) }}" id="address">
                                @error('address')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" id="email">
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
@endsection
