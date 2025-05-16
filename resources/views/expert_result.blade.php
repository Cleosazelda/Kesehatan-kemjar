@extends('layouts.main')

@section('container')
<!-- Main Content -->
<div id="content">

    @include('layouts.topbar')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            {{-- <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1> --}}
        </div>

        <!-- Content -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Expert Result</h6>
            </div>
            <div class="card-body" id="report" >
              <h2>Hasil Diagnosis</h2>
              <table class="table">
                <tr>
                  <td>Expert Value</td>
                  <td>:</td>
                  <td>
                    <ul>
                      @foreach($selectedEvidencesData as $evidence)
                      <li>{{ $evidence -> name }}</li>
                      @endforeach
                    </ul>
                  </td>
                </tr>
                @if(isset($bestHypothesisData))
                <tr>
                  <td>Nama Penyakit</td>
                  <td>: </td>
                  <td>{{ $bestHypothesisData->name }}</td>
                </tr>
                <tr>
                  <td>Total Bayes</td>
                  <td>: </td>
                  <td> {{ $maxTotalBayes }}%</td>
                </tr>
                <tr>
                  <td>Deskripsi Tingkat Kepastian</td>
                  <td>: </td>
                  <td> {{ $certainty }}</td>
                </tr>
                <tr>
                  <td>Solusi</td>
                  <td>: </td>
                  <td>{{ $bestHypothesisData->solution }}</td>
                </tr>
                <tr>
                  <td>Deskripsi Penyakit</td>
                  <td>: </td>
                  <td> {{ $bestHypothesisData->description }}</td>
                </tr>
                <tr>
                  <td>Gambar Penyakit</td>
                  <td>: </td>
                  <td>
                    <div class="card" style="width: 18rem;">
                      <img class="card-img-top" src="/storage/Hypothesis-Image/{{ $bestHypothesisData->image }}" alt="Gambar Penyakit">
                    </div>
                  </td>
                </tr>
                @else
                    <div>Data tidak ditemukan.</div>
                @endif
              </table>
                {{-- <tr>
                  <td>Name</td>
                  <td>:</td>
                  <td>{{ $data_name }}</td>
                </tr>
                <tr>
                  <td>Description</td>
                  <td>:</td>
                  <td>{{ $data_description }}</td>
                </tr>
                <tr>
                  <td valign = 'top'>Evidence Selected</td>
                  <td valign = 'top'>:</td>
                  <td>
                    <ul>
                      @foreach ($data_evidence as $data_evidence_item)
                      <li>{{ $data_evidence_item['name'] }}</li>
                      @endforeach
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td>Diagnosis</td>
                  <td>:</td>
                  <td>{{ $data_diagnosis }}</td>
                </tr> --}}
                {{-- <tr>
                  <td>Max Weight</td>
                  <td>:</td>
                  <td>
                    <strong>{{ $maxHypothesis }}:</strong> {{ $maxValue }}
                  </td>
                </tr> --}}

                {{-- @if(isset($bestHypothesisData))
                    <div>
                        <strong>Nama Penyakit:</strong> {{ $bestHypothesisData->name }}
                        <br>
                        <strong>:</strong> {{ $maxTotalBayes }}%
                        <br>
                        <strong>Deskripsi Tingkat Kepastian:</strong> {{ $certainty }}
                        <br>
                        <strong>Solusi:</strong> {{ $bestHypothesisData->solution }}
                        <br>
                        <strong>Deskripsi Penyakit:</strong> {{ $bestHypothesisData->description }}
                        <br>
                        <strong>Gambar Penyakit:</strong>
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="/storage/Hypothesis-Image/{{ $bestHypothesisData->image }}" alt="Gambar Penyakit">
                        </div>
                    </div>
                @else
                    <div>Data tidak ditemukan.</div>
                @endif --}}
                
                  {{-- <h2>Best Hypothesis</h2>
                    @if(isset($bestHypothesis))
                        <div>
                            <strong>{{ $bestHypothesisData -> name }}:</strong> {{ $maxTotalBayes }}%
                        </div>
                    @else
                        <div>No evidence selected or no matching rules found.</div>
                    @endif
                    <div>
                      <strong>Total Bayes terbesar adalah penyakit {{ $bestHypothesisData -> name }}:</strong> {{ number_format($maxTotalBayes, 2) }}
                      <br>
                      <strong>cara menangani penyakit : {{ $bestHypothesisData -> solution}}</strong>
                      <br>
                      <strong>deskripsi penyakit : {{ $bestHypothesisData -> description}}</strong>
                      <br>
                      <strong>gambar penyakit : {{ $bestHypothesisData -> image}}</strong>
                      <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="/storage/Hypothesis-Image/{{$bestHypothesisData->image}}" alt="Gambar Penyakit">
                      </div>
                    </div>                  
                  <tr> --}}
                
               {{-- <h1>Diagnosis Result</h1>
                @foreach($results as $hypothesis => $totalWeight)
                    <div>
                        <strong>{{ $hypothesis }}:</strong> {{ $totalWeight }}
                    </div>
                    <ul>
                      @foreach($selectedEvidences as $evidenceId)
                          <li>
                              Evidence ID {{ $evidenceId }} Probability: 
                              {{ number_format($probabilityHypothesis[$hypothesis][$evidenceId],4) }}
                          </li>
                      @endforeach
                    </ul>
                    <div>
                      <strong>Total Probabilities for {{ $hypothesis }}:</strong> {{number_format( $totalProbabilities[$hypothesis],4) }}
                    </div>
                    <ul>
                      @foreach($selectedEvidences as $evidenceId)
                          <li>
                              Evidence ID {{ $evidenceId }} Bayes: 
                              {{ number_format($bayesValues[$hypothesis][$evidenceId],4) }}
                          </li>
                      @endforeach
                    </ul>
                  <div>
                    <strong>Total Bayes for {{ $hypothesis }}:</strong> {{number_format( $totalBayes[$hypothesis],4) }}
                  </div>
                @endforeach--}}
              <hr> 
              <h1>Diagnosis Result</h1>
              
                @foreach($totalBayes as $hypothesisId => $totalBayesValue)
                @php
                      $hypothesis = $hypothesesData[$hypothesisId];
                  @endphp
                <h3>{{ $hypothesis->name }}</h3>
                <table class="table">
                    <thead>
                      <tr>
                        <th>Persentase Penyakit</th>
                        <th>Deskripsi Tingkat Kepastian</th>
                        <th>Total Bayes</th>
                      </tr>
                    </thead> 
                    <tbody>
                      <tr>
                        <td>{{ number_format($totalBayesValue) }}%</td>
                        <td>{{ $certaintyDescriptions[$hypothesisId] }}</td>
                        <td>{{ number_format($totalBayesValue, 2) }}</td>
                      </tr>                      
                    </table> 
                
                @endforeach
              
              {{-- @foreach($totalBayes as $hypothesisId => $totalBayesValue)
                  @php
                      $hypothesis = $hypothesesData[$hypothesisId];
                  @endphp
                  <div>
                      <strong>{{ $hypothesis->name }}:</strong> {{$totalBayesValue }}%
                      <br>
                      <strong>Deskripsi Tingkat Kepastian:</strong> {{ $certaintyDescriptions[$hypothesisId] }}
                  </div>
                  <ul>
                      @foreach($selectedEvidences as $evidenceId)
                          <li>
                              Evidence ID {{ $evidenceId }} Probability: 
                              {{ number_format($probabilityHypothesis[$hypothesisId][$evidenceId], 4) }}
                          </li>
                      @endforeach
                  </ul>
                  <div>
                      <strong>Total Probabilities for {{ $hypothesis->name }}:</strong> {{ number_format($totalProbabilities[$hypothesisId], 2) }}
                  </div>
                  <ul>
                      @foreach($selectedEvidences as $evidenceId)
                          <li>
                              Evidence ID {{ $evidenceId }} Bayes: 
                              {{ number_format($bayesValues[$hypothesisId][$evidenceId], 4) }}
                          </li>
                      @endforeach
                  </ul>
                  <div>
                      <strong>Total Bayes for {{ $hypothesis->name }}:</strong> {{ number_format($totalBayesValue, 4) }}
                  </div>
              @endforeach --}}

              {{-- @foreach ($data as $item)
              <h4>{{ $item['name'] }}</h4> --}}
              {{-- <h6>Weight : {{ $item['weight'] }}</h6> --}}
              {{-- <div class="table-responsive">
                <table class=" table-bordered" width="100%" cellspacing="0"> --}}
                  {{-- <thead>
                    <tr>
                      <th>No</th>
                      <th>Code</th>
                      <th>Evidence</th>
                      <th>Weight</th>
                    </tr>
                  </thead> --}}
                  {{-- <tbody> --}}
                    {{-- @foreach ($item['evidence_data'] as $evidence_item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $evidence_item['code'] }}</td>
                      <td>{{ $evidence_item['name'] }}</td>
                      <td>{{ $evidence_item['weight'] }}</td>
                    </tr>
                    @endforeach --}}
                    {{-- <tr>
                      <td colspan="3">Tew = Total multiplication of hypotehsis and all eviednce weights</td>
                      <td>{{ number_format($item['tot_evi_weight'],4)  }}</td>
                    </tr>
                    <tr>
                      <td colspan="3">Total multiplication of all hypothesis result (Tew)</td>
                      <td>{{ number_format($item['tot_hypo_weight'],4) }}</td>
                    </tr> --}}
                    {{-- <tr>
                      <td colspan="3">Expert Result</td>
                      <td><strong>{{ number_format($item['diagnosis_result'],4) }}</strong> </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <hr>
              @endforeach --}}
            </div>
            <div class="card-footer">
              <div class="col-12 text-right"><button type="button" class="btn btn-primary" onclick="printReport()"><i class="fa fa-print"></i> Print</a></button></div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<script>
    function printReport() {
        const printContents = document.getElementById('report').innerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<!-- End of Main Content -->
@endsection
