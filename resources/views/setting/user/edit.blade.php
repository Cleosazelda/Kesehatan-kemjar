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
                        <h6 class="m-0 font-weight-bold text-primary">Add Data</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update', $get_user->id) }}" method="post">
                        @csrf
                        @method('put')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $get_user->name) }}" id="name">
                                @error('name')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $get_user->address) }}" id="address">
                                @error('address')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $get_user->email) }}" id="email">
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
                            <div class="mb-3" bis_skin_checked="1">
                                <label for="exampleInputPassword1" class="form-label">Role</label>
                                <div class="form-check" bis_skin_checked="1">
                                    <input class="form-check-input" type="radio" name="role" id="role2" value="user"
                                    @if ($get_user->role == 'user')
                                    checked
                                    @endif 
                                    >
                                    <label class="form-check-label" for="role2">
                                        User
                                    </label>
                                </div>
                                <div class="form-check" bis_skin_checked="1">
                                    <input class="form-check-input" type="radio" name="role" id="role1" value="admin"
                                    @if ($get_user->role == 'admin')
                                    checked
                                    @endif 
                                    >
                                    <label class="form-check-label" for="role1">
                                        Admin
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
@endsection
