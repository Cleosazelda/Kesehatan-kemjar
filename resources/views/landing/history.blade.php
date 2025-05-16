<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat</title>
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
                        <span>U-Smile</span>
                    </a>
                </div>
                <div class="nav-menu">
                    <span><a href="{{route('index')}}" style="color: #749BC2;">Home</a> / Riwayat</span>
                </div>
            </nav>
        </div>
        </div>
    </header>
    <main>
        <div class="container">
            <section style="padding-top: 100px; padding-bottom: 100px;">
            <h2 style="padding-bottom: 20px;" class="fw-bold">Semua Riwayat</h2>
            <table id="dataTable" class="p-3 gap-3 table table-borderless mb-4"  width="100%" cellspacing="0">
              @foreach ($diagnosis_data as $item)
              <div class="card mb-3 d-flex align-items-center border-0" style="width: 100%;">
                <div class=" g-0 d-flex flex-row align-items-center justify-content-between mx-5" style="width: 100%">
                  <div class="d-flex align-items-center">
                    <div class="img-diagnosis d-flex justify-content-center align-items-center border border-1 overflow-hidden">
                      <img src="storage/Hypothesis-Image/{{$item->hypothesis->images->first()->image_path}}" class="img-size rounded-start border img-fluid" style="height: 100%; width: 100%;"  alt="...">
                    </div>
                    <div class="col ">
                      <div class="card-body">
                        <h5 class="hypothesis-name card-title fw-bolder">{{$item->hypothesis->name}}</h5>
                        <span class="span card-text d-block">{{$item->value}}%</span>
                        <span class="span card-text">{{$item->created_at->format('d/m/Y')}}</span>
                      </div>                    
                    </div>
                  </div>
                  <div class="col-md-1 d-flex justify-content-center justify-content-md-end gap-1 ">
                    <button type="button" class="btn text-danger" data-bs-toggle="modal" data-bs-target="#modalId{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
                    <a href="{{ route('history_detail',  $item->id)}}" class="btn text-primary fs-5"><i class="fa-solid fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
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
                          "{{ $item->name }}"
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
            </table>

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