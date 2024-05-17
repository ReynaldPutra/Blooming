

@extends('layout')

@section('style')
<link rel="stylesheet" href="{{ asset('/css/home.css') }}"/>
@endsection

@section('title','Home')

@section('content')
    <section>
        <div class="container hero-content">
            <div id="home-carousel" class="carousel slide mt-5">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#home-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#home-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#home-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active c-item">
                    <img src="https://img.freepik.com/free-photo/beautiful-flowers-field_23-2150788819.jpg?size=626&ext=jpg&ga=GA1.1.553209589.1714176000&semt=ais" class="d-block w-100 c-image" alt="...">
                    <div class="carousel-caption caption-content ">
                        <p class="fs-5 text-uppercase">Warmth. Nostalgia. Togetherness. Give the gift of an experience</p>
                        <h1 class="display-1 fw-bolder text-capitalize">A Taste of Home</h1>
                        <a href="/showProduct"><button class="btn btn-primary px-5 py-2 fs-5 mt-4 btn-deg">Shop Now</button></a>
                    </div>
                </div>
                  <div class="carousel-item c-item">
                    <img src="https://img.freepik.com/free-photo/beautiful-flowers-field_23-2150788819.jpg?size=626&ext=jpg&ga=GA1.1.553209589.1714176000&semt=ais" class="d-block w-100 c-image" alt="...">
                    <div class="carousel-caption caption-content ">
                        <p class="fs-5 text-uppercase">Warmth. Nostalgia. Togetherness. Give the gift of an experience</p>
                        <h1 class="display-1 fw-bolder text-capitalize">A Taste of Home</h1>
                        <a href="/showProduct"><button class="btn btn-primary px-5 py-2 fs-5 mt-4 btn-deg">Shop Now</button></a>
                    </div>
                </div>
                  <div class="carousel-item c-item">
                    <img src="https://img.freepik.com/free-photo/beautiful-flowers-field_23-2150788819.jpg?size=626&ext=jpg&ga=GA1.1.553209589.1714176000&semt=ais" class="d-block w-100 c-image" alt="...">
                    <div class="carousel-caption caption-content ">
                        <p class="fs-5 text-uppercase">Warmth. Nostalgia. Togetherness. Give the gift of an experience</p>
                        <h1 class="display-1 fw-bolder text-capitalize">A Taste of Home</h1>
                        <a href="/showProduct"><button class="btn btn-primary px-5 py-2 fs-5 mt-4 btn-deg">Shop Now</button></a>
                    </div>
                </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#home-carousel" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#home-carousel" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>

              <div class="product_catalog mb-5">

                <div class="product_category">
                  <div class="category_title">
                
                    <h2 class="text-uppercase">{{ $data_recycle->get(0)->category }}</h2>
                    <a href="/showProduct/{{ $data_recycle->get(0)->category }}" class="ms-auto">View All</a>
                  </div>

                  <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 py-3">
                    @foreach ($data_recycle as $data_recycle)
                    <div class="col mx-auto" >
                      <a href="/products/{{$data_recycle->id}}">
                        <div class="card ">
                          @if (File::exists(public_path($data_recycle->image)))
                            <img src="{{ asset($data_recycle->image) }}" class="card-img-top img_product" alt="...">
                          @else
                            <img src="{{ $data_recycle->image }}" class="card-img-top img_product" alt="...">
                          @endif
                          <div class="card-body">
                            <h5 class="card-title">{{ $data_recycle->name }}</h5>
                            <p class="card-text">Rp {{$data_recycle->price}} </p>
                          </div>
                        </div>
                      </a>
                    </div>
                    @endforeach

                  </div>
                </div>


                <div class="product_category">
                  <div class="category_title">
                    <h2 class="text-uppercase">{{ $data_second->get(0)->category }}</h2>
                    <a href="/showProduct/{{ $data_second->get(0)->category }}" class="ms-auto">View All</a>
                  </div>
                  <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 py-3">
                   
                    @foreach ($data_second as $data_second)
                    <div class="col mx-auto" >
                      <a href="/products/{{$data_second->id}}">
                        <div class="card ">
                          @if (File::exists(public_path($data_second->image)))
                            <img src="{{ asset($data_second->image) }}" class="card-img-top img_product" alt="...">
                          @else
                            <img src="{{ $data_second->image }}" class="card-img-top img_product" alt="...">
                          @endif
                          <div class="card-body">
                            <h5 class="card-title">{{ $data_second->name }}</h5>
                            <p class="card-text">Rp {{$data_second->price}} </p>
                          </div>
                        </div>
                      </a>
                    </div>
                    @endforeach

                  </div>
                </div>
        </div>
    </section>
@endsection
