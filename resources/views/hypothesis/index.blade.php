@extends('layouts.main')

@section('container')
<!-- Main Content -->
<div id="content">

    @include('layouts.topbar')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            {{-- Menggunakan {{ }} untuk output escaping, mencegah XSS --}}
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
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
                <a href="{{ route('hypothesis.create') }}" class="btn btn-primary btn-sm mb-3"><i class="fas fa-fw fa-plus"></i> Add</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Hypothesis</th>
                                <th>Image</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hypothesis_data as $item)
                            <tr>
                                {{-- Menggunakan {{ }} untuk output escaping --}}
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if ($item->images->isNotEmpty())
                                        {{-- 
                                          PERUBAHAN KEAMANAN:
                                          - Menggunakan asset() helper untuk membuat URL yang benar ke symbolic link 'storage'.
                                          - Path disesuaikan dengan yang ada di Controller: 'storage/hypothesis-images/'.
                                          - Alt text di-escape untuk mencegah XSS jika nama file mengandung karakter berbahaya.
                                        --}}
                                        <img src="{{ asset('storage/hypothesis-images/' . $item->images->first()->image_path) }}" height="150px" class="me-3 rounded" alt="Gambar untuk {{ $item->name }}">
                                    @else
                                        <p class="text-muted">Gambar tidak tersedia.</p>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('hypothesis.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-edit"></i> Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalId{{ $item->id }}"><i class="fas fa-fw fa-trash"></i> Delete</button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalId{{ $item->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId">Delete Confirmation</h5>
                                                </div>
                                                <div class="modal-body">
                                                    {{-- Menggunakan {{ }} untuk output escaping --}}
                                                    Are you sure to delete {{ $title }} "{{ $item->name }}"? Deleting this will also remove related rule data.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    {{-- Form ini sudah aman menggunakan @csrf dan @method('delete') --}}
                                                    <form action="{{ route('hypothesis.destroy', $item->id) }}" method="post" class="d-inline">
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