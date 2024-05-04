@extends('layout')
@section('title',$title)

@section('style')
<link rel="stylesheet" href="{{ asset('/css/products.css') }}"/>
@endsection

@section('content')
<div class="container hero-content">
  <div class="head text-center ">
  
    <h1 class="mb-1 mt-5 fw-bold">OUR FLOWERS</h1>
    <p class="mb-3">All Product Is Available </p>
    <form action="/showProduct" type="get" class="searchbar mx-auto mb-4">
      <div class="input-group justify-content-center">
        <input type="text" class="form-control" name="search" value = "{{request('search')}}" placeholder="Search product..." aria-label="Search product..." aria-describedby="button-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">Search</button>
        </div>
      </div>
    </form>
    <div class="filter_button">
      <a href="#" data-bs-toggle="modal" data-bs-target="#filter" class="text-uppercase"> Filter</a>
    </div>
  </div>




<!-- Modal -->
<div class="modal fade" id="filter" tabindex="-1" aria-labelledby="filter" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="filter">FILTER</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="filterBy">
          <h5 class="text-uppercase">Category</h5>
            @if($selectedCategory === "All")
                <p><a href="/showProduct" class="category_selected"><strong>• All Flowers</strong></a></p>
            @else
                <p><a href="/showProduct" class="category_filter">All Flowers</a></p>
            @endif
          
          @foreach($category as $c)
          <label class="d-block">
            @if($c->category === $selectedCategory)
            <p><a href="/showProduct/{{ urlencode($c->category) }}" class="category_selected"><strong>• {{ $c->category }}</strong></a></p>
              @else
            <p><a href="/showProduct/{{ urlencode($c->category) }}" class="category_filter">{{ $c->category }}</a></p>
            @endif
          </label>
          @endforeach
        </div>
    
        <div class="filterBy">
          <h5 class="text-uppercase">Price</h5>
          @if($order === 'none')
            <p><a href="/showProduct/{{ $selectedCategory }}/High" class="category_filter">High to Low</a></p>
            <p><a href="/showProduct/{{ $selectedCategory }}/Low" class="category_filter">Low to High</a></p>
          @elseif($order === 'ASC')
            <p><a href="/showProduct/{{ $selectedCategory }}/High" class="category_filter">High to Low</a></p>
            <p><a href="/showProduct/{{ $selectedCategory }}/Low" class="category_selected"><strong>• Low to High</strong></a></p>
          @elseif($order === 'DESC')
            <p><a href="/showProduct/{{ $selectedCategory }}/High" class="category_selected"><strong>• High to Low</strong></a></p>
            <p><a href="/showProduct/{{ $selectedCategory }}/Low" class="category_filter">Low to High</a></p>
          @endif
        </div>
      </div>

    </div>
  </div>
</div>

<div class="show_product">
  <div class="filter_product">
    <div class="filterBy">
      <h5 class="text-uppercase">Category</h5>
        @if($selectedCategory === "All")
            <p><a href="/showProduct" class="category_selected"><strong>• All Flowers</strong></a></p>
        @else
            <p><a href="/showProduct" class="category_filter">All Flowers</a></p>
        @endif
      
      @foreach($category as $c)
      <label class="d-block">
        @if($c->category === $selectedCategory)
        <p><a href="/showProduct/{{ urlencode($c->category) }}" class="category_selected"><strong>• {{ $c->category }}</strong></a></p>
          @else
        <p><a href="/showProduct/{{ urlencode($c->category) }}" class="category_filter">{{ $c->category }}</a></p>
        @endif
      </label>
      @endforeach
    </div>

    <div class="filterBy">
      <h5 class="text-uppercase">Price</h5>
      @if($order === 'none')
        <p><a href="/showProduct/{{ $selectedCategory }}/High" class="category_filter">High to Low</a></p>
        <p><a href="/showProduct/{{ $selectedCategory }}/Low" class="category_filter">Low to High</a></p>
      @elseif($order === 'ASC')
        <p><a href="/showProduct/{{ $selectedCategory }}/High" class="category_filter">High to Low</a></p>
        <p><a href="/showProduct/{{ $selectedCategory }}/Low" class="category_selected"><strong>• Low to High</strong></a></p>
      @elseif($order === 'DESC')
        <p><a href="/showProduct/{{ $selectedCategory }}/High" class="category_selected"><strong>• High to Low</strong></a></p>
        <p><a href="/showProduct/{{ $selectedCategory }}/Low" class="category_filter">Low to High</a></p>
      @endif
    </div>
  </div>
  
  @if($products->count())
  <div class="product_catalog mb-5">
  
    <div class="product_category">
  
      <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 py-3">
        @foreach ($products as $p)
        <div class="col mx-auto " >
          <a href="/products/{{$p->id}}">
            <div class="card">
              @if (Storage::disk('public')->exists($p->image))
                <img src="{{Storage::url($p->image)}}" alt="card-image" class="card-img-top img_product">
              @else
                <img src="{{$p->image}}" alt="card-image" class="card-img-top img_product">
              @endif
              
              <div class="card-body">
                <h5 class="card-title">{{ $p->name }}</h5>
                <p class="card-text">Rp {{$p->price}} </p>
              </div>
            </div>
          </a>
        </div>
        @endforeach

        @php
          $empty_columns = 4 - (count($products) % 4);
        @endphp
        @for ($i = 0; $i < $empty_columns; $i++)
          <div class="col empty_col">

          </div>
        @endfor

      </div>   
    </div>
    <div class="mx-auto page d-flex justify-content-center">
      {{ $products->links() }}
    </div>
  </div>
</div>

@else
<div class="trash">
  <img src="https://www.bagbazaars.com/assets/img/no-product-found.png" alt="">
</div>
@endif
</div>
@endsection

