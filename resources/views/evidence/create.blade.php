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
                        <form action="{{ route('evidence.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input name="code" type="text" class="form-control" id="code" readonly value="{{ $get_auto_code }}">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Evidence</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name">
                                @error('name')
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
