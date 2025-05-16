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

        <!-- Content -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text">Expert form</h6>
            </div>
            <div class="card-body">
              <form action="{{ route('expert_result') }}" method="post">
                @csrf
                <div class="mb-3 col-lg-6 col-md-12">
                  <label for="name" class="form-label">Name</label>
                  <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"  value="{{Auth::user()->name}}">
                  @error('name')
                  <div class="invalid-feedback">
                      <i class="bx bx-radio-circle"></i>
                      {{ $message }}.
                  </div>
                  @enderror
                </div>
                <div class="mb-3 col-lg-6 col-md-12">
                  <label for="description" class="form-label">Description</label>
                  {{-- <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="floatingTextarea" rows="3" >{{ old('description') }}</textarea> --}}
                  <input name="description" type="text" class="form-control @error('description') is-invalid @enderror" id="description "  value="{{Auth::user()->role}}">
                  @error('description')
                  <div class="invalid-feedback">
                      <i class="bx bx-radio-circle"></i>
                      {{ $message }}.
                  </div>
                  @enderror
                </div>
                <div class="mb-3 col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Evidence</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($evidence as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                  <div class="form-check">
                                    <input class="form-check-input @error('description') is-invalid @enderror" type="checkbox" name="evidence_id[]" value="{{ $item->id }}" id="flexCheckDefault">
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody> 
                    </table>
                  </div>
                  @error('evidence_id[]')
                  <div class="invalid-feedback">
                      <i class="bx bx-radio-circle"></i>
                      {{ $message }}.
                  </div>
                  @enderror
                </div>
                <div class="mb-3 col-lg-12 col-md-12 text-right">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-arrow-right"></i> kirim</button>
                </div>
              </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
@endsection
