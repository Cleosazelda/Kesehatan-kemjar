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
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        </div>

        <!-- Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text">Data {{ $title }}</h6>
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
                <a href="{{ route('evidence.create') }}" class="btn btn-primary btn-sm mb-3"><i class="fas fa-fw fa-plus"></i> Add</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Evidence</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($evidence_data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                  <a href="{{ route('evidence.edit',$item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-edit"></i> Edit</a>
                                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalId{{ $item->id }}"><i class="fas fa-fw fa-trash"></i> Delete</button>
                                  <div class="modal fade" id="modalId{{ $item->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="modalTitleId">Delete</h5>
                                        </div>
                                        <div class="modal-body">
                                          Are you sure to delete {{ $title }} "{{ $item->name }}". If data deleted then data in rule deleted to.
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                          <form action="{{ route('evidence.destroy', $item->id) }}" method="post" class="d-niline">
                                          @csrf
                                          @method('delete')
                                          <button type="submit" class="btn btn-danger">Delete</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
@endsection
