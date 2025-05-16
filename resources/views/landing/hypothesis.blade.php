<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Penyakit</title>
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
                        <span>U-SMILE</span>
                    </a>
                </div>
                <div class="nav-menu">
                    <span><a href="{{route('index')}}" style="color: #749BC2;">Home</a> / Semua Penyakit</span>
                </div>
            </nav>
        </div>
        </div>
    </header>
    <main>
        <div class="container">
            <section style="padding-top: 100px">
              <h2 class="fw-bolder pb-4">Semua Penyakit</h2>
                @foreach ($hypothesis_data as $item)
                <div class="card border-0 mb-3 d-flex align-items-center" style="width: 100%;">
                  <div class=" g-0 d-flex flex-row align-items-center justify-content-between mx-5" style="width: 100%">
                    <div class="d-flex align-items-center">
                      <div class="img-diagnosis d-flex justify-content-center align-items-center border border-1 overflow-hidden">
                        {{-- <img src="storage/Hypothesis-Image/{{$item->hypothesis->images->first()->image_path}}" class="img-size rounded-start border img-fluid" style="height: 100%; width: 100%;"  alt="..."> --}}
                        @if ($item->images->isNotEmpty())
                            <img src="/storage/Hypothesis-Image/{{$item->images->first()->image_path}}" class="img-size rounded-start border img-fluid" style="height: 100%; width: 100%;" alt="Gambar Penyakit">
                            @else
                                <p>Gambar tidak tersedia.</p>
                          @endif
                      </div>
                      <div class="col d-flex align-items-center">
                        <div class="card-body">
                          <h5 class="hypothesis-name card-title fw-bolder">{{$item->name}}</h5>
                        </div>                    
                      </div>
                    </div>
                    <div class="col-md-1 d-flex justify-content-center justify-content-md-end gap-1 ">
                      <a href="{{ route('hypothesis_detail',  $item->id)}}" class="btn text-primary"><i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                  </div>
                </div>

                @endforeach
            </section>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>
</html>