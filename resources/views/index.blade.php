@extends('layouts.main')

@section('container')
<!-- Main Content -->
<div id="content">

    @include('layouts.topbar')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Expert System Teorema Bayes for {{ $app_title->value }}</h1>
        </div>

        <!-- Content -->
        <div class="card shadow mb-4">
            <div class="card-body">
              <p class="text-justify">
                {{ $app_desc->value }}
              </p>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
@endsection
