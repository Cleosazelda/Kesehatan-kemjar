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
                        <h6 class="m-0 font-weight-bold text">Setting Application</h6>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        @endif
                        <form action="{{ route('setting.update') }}" method="post">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $app_title->value) }}" id="title">
                                @error('title')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" type="text" class="form-control @error('description') is-invalid @enderror" id="description" rows="3">{{ old('description',$app_description->value) }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="evidence" class="form-label">evidence</label>
                                <input name="evidence" type="text" class="form-control @error('evidence') is-invalid @enderror" value="{{ old('evidence', $app_evidence->value) }}" id="evidence">
                                @error('evidence')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $message }}.
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="hypothesis" class="form-label">hypothesis</label>
                                <input name="hypothesis" type="text" class="form-control @error('hypothesis') is-invalid @enderror" value="{{ old('hypothesis', $app_hypothesis->value) }}" id="hypothesis">
                                @error('hypothesis')
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
