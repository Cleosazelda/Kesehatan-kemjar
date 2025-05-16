<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Diagnosa</title>
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
            <span>U-SMILE</span></a>
          </a>
        </div>
        <div class="nav-menu">
          <span><a href="{{route('index')}}" style="color: #749BC2;">Home</a> / Diagnosa</span>
        </div>
      </nav>
    </div>
    </div>
  </header>
  <main>
    <div class="container">
      <section style="padding-top: 100px">
        <h2 class="mb-5 text-capitalize fw-bolder">Pilih Gejala</h2>   
        <form action="{{ route('result') }}" method="post">
            @csrf
                <div class="mb-5 col-lg-6 col-md-12 d-none">
                  {{-- <label for="name" class="form-label">Name</label> --}}
                  <input readonly name="name" type="text" class="form-control border-0 bg-white p-0 @error('name') is-invalid @enderror" id="name"  value="{{Auth::user()->name}}">
                  @error('name')
                  <div class="invalid-feedback">
                      <i class="bx bx-radio-circle"></i>
                      {{ $message }}.
                  </div>
                  @enderror
                </div>
                <div class="col-lg-6 col-md-12 d-none">
                  {{-- <label for="description" class="form-label">Description</label> --}}
                  {{-- <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="floatingTextarea" rows="3" >{{ old('description') }}</textarea> --}}
                  <input readonly name="description" type="text" class="form-control border-0 bg-white p-0 @error('description') is-invalid @enderror" id="description "  value="{{Auth::user()->role}}">
                  @error('description')
                  <div class="invalid-feedback">
                      <i class="bx bx-radio-circle"></i>
                      {{ $message }}.
                  </div>
                  @enderror
                </div>
            <table class="table table-borderless mt-4" style="width: 100%;">
                @foreach ($evidence as $item)
                    <tr style="vertical-align: middle;">
                    {{-- <td><img src="asset/img/20240527_161533.jpg" style="height: 200px;" alt=""></td> --}}
                    <td style="text-align: justify ;">{{$item->name}}</td>
                    <td>
                        <div class="custom-checkbox">
                        <input type="checkbox" class="myCheckbox @error('description') is-invalid @enderror" name="evidence_id[]" value="{{ $item->id }}" id="flexCheckDefault">
                        <label></label>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
          <div class="mb-3 col-lg-12 col-md-12 text-right">
            <button type="submit" class="submit"><i class="fas fa-arrow-right"></i> Kirim</button>
          </div>
        </form>
      </section>
    </div>
  </main>
  <footer>
    <span style="color: white;">- 2025 -</span>
  </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</html>