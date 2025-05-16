<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="{{asset('landing/asset/css/style.css')}}" />
  <link rel="shortcut icon" href="{{asset('landing/asset/icons/teeth.png')}}" type="image/x-icon" />
  <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <script src="https://kit.fontawesome.com/d6601cbc46.js" crossorigin="anonymous"></script>
</head>
<body>
  <header class="rounded-bottom"> 
    <div class="container">
      <nav>
        <div class="icon">
          <a href="{{route('index')}}"><img src="{{asset('landing/asset/icons/teeth.png')}}" alt="" />
            <span >U-SMILE</span></a>
        </div>
        <ul class="nav-menu">
          <li class="menu"><a href="#beranda">Beranda</a></li>
          <li class="menu"><a href="#diagnosa">Diagnosa</a></li>
          <li class="menu"><a href="#nama_penyakit">Nama Penyakit</a></li>
          {{-- @if (auth()->user()->role == 'admin')
          <li><a href="{{route('dashboard')}}">Dashboard</a></li>
          @endif
          <li><a href="{{ route('login')}}" class="login">Login</a></li> --}}
          @if (auth()->check())
                    <li class="menu"><a href="#riwayat">Riwayat</a></li>

          <!-- Jika pengguna login dan perannya admin, tampilkan link Dashboard -->
            
            <div class="dropdown">
              <button type="button" class="btn btn-secondary rounded-circle" data-bs-toggle="dropdown">
                {{ substr(auth()->user()->name, 0, 1) }}
              </button>
              <ul class="dropdown-menu">
                @if (auth()->user()->role == 'admin')
                  <li>            
                    <a class="dropdown-item" target="_blank" href="{{ route('dashboard') }}">                    
                      <i class="fa-solid fa-desktop fa-sm fa-fw mr-2 text-gray-400"></i> Dashboard</a>
                  </li>
                @endif
                <li><a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a></li>
              </ul>
            </div>  
          @else
              <!-- Jika pengguna belum login, tampilkan tombol Login -->
              <li><a href="{{ route('login') }}" class="login">Login</a></li>
          @endif
    
        </ul>
      </nav>
    </div>
    </div>
  </header>
  <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout')}}">Logout</a>
                </div>
            </div>
        </div>
    </div>
  <main>
    <div class="container">
      <div class="row">
        <section class="hero gap-3 d-flex align-items-center" id="beranda" style="min-height: 100vh">
          <img src="{{asset('landing/asset/icons/teeth.png')}}" alt="TOMAT" class="w-50" />
          <div class="banner">
            <h1 class="fw-bolder">SISTEM PAKAR DIAGNOSA PENYAKIT GIGI</h1>
            <p style="text-indent: 30px">
              Sistem pakar adalah sistem komputer yang dirancang untuk menyelesaikan masalah atau memberikan solusi yang rumit dengan cara mengaplikasikan pengetahuan dari seorang ahli dalam bidang tertentu. Sistem pakar memanfaatkan berbagai macam metode untuk menghasilkan solusi yang tepat dan efektif. Salah satu metode yang sering digunakan dalam sistem pakar adalah metode Teorema Bayes.
            </p>
            <a href="#diagnosa" class="button text-decoration-none p-2 rounded-pill fw-medium mt-3 d-inline-block">Mulai Diagnosa</a>

          </div>
        </section>
        <section class=" d-flex flex-column align-items-center justify-content-center"
          id="diagnosa">
          <h2 class="text-center p-2 fw-bolder" style="border-bottom: 5px solid #749BC2;">Diagnosa</h2>
          <div class="section-diagnosa p-3 mt-5 border border-3 rounded-4">
            <p>
              Sistem ini menggunakan metode Teorema Bayes untuk mendiagnosis penyakit. Proses dimulai dengan memilih gejala, 
              kemudian sistem memproses gejala yang dipilih, setelah selesai diproses sistem akan menampilkan hasil diagnosis 
              penyakit. Hasil diagnosis akan disimpan dalam sistem. Pengguna dapat melihat kembali hasil diagnosis pada menu 
              riwayat.
              </p>
            <a href="{{ route('diagnosa')}}" class="button text-center d-block rounded-pill py-2">Mulai Diagnosa</a>
          </div>
        </section>
        <section class=" d-flex flex-column align-items-center justify-content-center"  id="nama_penyakit">
          <h2 class="text-center p-2 fw-bold" style="border-bottom: 5px solid #749BC2;">Nama Penyakit</h2>

          <div class="daftar-penyakit p-3 mt-5 mb-4 gap-3 row justify-content-center">
            @foreach($hypothesis_data as $item)
            <a href="{{ route('hypothesis_detail',  $item->id)}}" class="penyakit card border-3 rounded-5 align-items-center p-3 text-decoration-none">
              <div class="img-cover">
              @if ($item->images->isNotEmpty())
                  <img src="{{ asset('storage/Hypothesis-Image/' . $item->images->first()->image_path) }}" height="300px" class="me-3 rounded" alt="Gambar Penyakit">
              @else
                  <p>Gambar tidak tersedia.</p>
              @endif
                {{-- <img src="" class="card-img" alt="Gambar Penyakit"> --}}
              </div>
              <div class="card-body d-flex justify-content-center align-items-center">
                <h5 class="card-title text-center fw-semibold text-capitalize fw-bolder">{{$item->name}}</h5>
              </div>
            </a>
            @endforeach
          </div>
          <div class=" d-flex align-items-center justify-content-center mb-5" style="width: 100%">
            <a href="{{route('hypothesis_page')}}" class="btn fw-semibold border rounded-pill text-light" style="background-color: #749BC2">Lihat Semua <i class="fa-solid fa-chevron-right  "></i></a>
          </div>
        </section>
        @if (auth()->check())
        <section class="d-flex flex-column align-items-center justify-content-center" style="min-height: 50vh; padding-top: 100px;"
          id="riwayat">
          <h2 class="title p-2 text-center fw-bold mb-5" style="border-bottom: 5px solid #749BC2; margin-left: 10px;">Riwayat</h2>
          <!-- <div class="table-responsive"> -->          
          <table id="dataTable" class="p-3 gap-3 table table-bordered mb-4"  width="100%" cellspacing="0">
            {{-- <tbody class="pt-2"> --}}
              @foreach ($diagnosis_data as $item)              
              <a href="{{ route('history_detail',  $item->id)}}" class="card border-0 mb-3 d-flex flex-row align-items-center" style="width: 100%;">
                <div class="g-0 d-flex flex-row align-items-center justify-content-between mx-5" style="width: 90%;">
                  <div class="d-flex align-items-center" style="width: 80%">
                    <div class="img-diagnosis d-flex justify-content-center align-items-center border border-1 overflow-hidden">
                      <img src="storage/Hypothesis-Image/{{$item->hypothesis->images->first()->image_path}}" class="img-size rounded-start border img-fluid" style="height: 100%; width: 100%;"  alt="...">
                    </div>
                    <div class="col border-0 d-flex align-items-center">
                      <div class="card-body ">
                        <h5 class="hypothesis-name card-title fw-bolder">{{$item->hypothesis->name}}</h5>
                        <small class="span card-text d-block">{{$item->value}}%</small>
                        <span class="span card-text">{{$item->created_at->format('d/m/Y')}}</span>
                      </div>                    
                    </div>
                  </div>

                  <div class="col-md-1 d-flex justify-content-center justify-content-md-end gap-1 ">
                    <button type="button" class="btn text-secondary" data-bs-toggle="modal" data-bs-target="#modalId{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
                    <a href="{{ route('history_detail',  $item->id)}}" class="btn text-primary fs-5"><i class="fa-solid fa-chevron-right"></i></a>
                  </div>
                </div>
              </a>
              <div class="modal fade" 
                  id="modalId{{ $item->id }}" 
                  tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalTitleId">Delete</h5>
                        </div>
                        <div class="modal-body">
                          Are you sure to delete 
                          {{ $title }} "{{ $item->name }}"
                          . If data deleted then data in rule
                          deleted to.
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form 
                          action="{{ route('destroy_history', $item->id) }}" 
                          method="post" class="d-niline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
              @endforeach            
            </tbody> 
          </table>
          <div class=" d-flex align-items-center justify-content-center mb-5" style="width: 100%">
            <a href="{{route('history_page')}}" class="btn fw-semibold border rounded-pill text-light" style="background-color: #749BC2">Lihat Semua <i class="fa-solid fa-chevron-right  "></i></a>
          </div>
        </section>
        @endif        
          </div>
      </div>
    </div>
  </main>
  <footer>
    <span style="color: white;">- 2025 -</span>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
    {{-- <!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script> --}}

</body>

</html>