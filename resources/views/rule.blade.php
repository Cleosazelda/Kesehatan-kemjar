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

        <!-- Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text">{{ $title }} of hypothesis</h6>
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Hypothesis</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($hypothesis_data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                  <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalViewId{{ $item->id }}"><i class="fas fa-fw fa-eye"></i> View</button>
                                  <div class="modal fade" id="modalViewId{{ $item->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                          <form action="{{ route('rule.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="modalTitleId">{{ $item->name }}</h5>
                                              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              @foreach ($rule_data->where('hypothesis_id', $item->id) as $rule_item)
                                              <div class="row justify-content-center align-items-center g-2">
                                                <div class="col-lg-4 col-md-12"><label for="">{{ $loop->iteration }}. {{ $rule_item->evidence->name }}</label></div>
                                                <div class="col-lg-2 col-md-12"><label for=""><span id="labelWeightHypo{{ $item->id }}Rule{{ $rule_item->id }}">{{ $rule_item->weight }}</span></label></div>
                                                <div class="col-lg-6 col-md-12">
                                                  <input type="hidden" name="rule_id[]" value="{{ $rule_item->id }}">
                                                  <input type="range" name="weight[]" min=0.0 max=1.0 step=0.1 value={{ $rule_item->weight }} class="form-control" id="rangeWeightHypo{{ $item->id }}Rule{{ $rule_item->id }}">
                                                  <script>
                                                    var rangeWeightHypo{{ $item->id }}Rule{{ $rule_item->id }} = document.getElementById('rangeWeightHypo{{ $item->id }}Rule{{ $rule_item->id }}');
                                                    var labelWeightHypo{{ $item->id }}Rule{{ $rule_item->id }} = document.getElementById('labelWeightHypo{{ $item->id }}Rule{{ $rule_item->id }}');
                                                    labelWeightHypo{{ $item->id }}Rule{{ $rule_item->id }}.innerHTML = rangeWeightHypo{{ $item->id }}Rule{{ $rule_item->id }}.value;
                                                    rangeWeightHypo{{ $item->id }}Rule{{ $rule_item->id }}.oninput = function() {
                                                      labelWeightHypo{{ $item->id }}Rule{{ $rule_item->id }}.innerHTML = this.value;
                                                    }
                                                  </script>
                                                </div>
                                              </div>
                                              @endforeach
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-primary"> Save</button>
                                            </div>
                                          </form>
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
