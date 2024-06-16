@extends('layout')
@section('title','Product Detail')


@section('style')
<link rel="stylesheet" href="{{ asset('/css/productDetail.css') }}"/>
@endsection

@section('content')
@if($product)
<div class="container">
  <h1 class="mb-1 mt-5 mb-4 fw-bold text-center">FLOWER DETAIL</h1>
  <div class="row row-cols-1 row-cols-md-2  g-4 py-3">
    <div class="col mx-auto img-col" >
      <div class="img-box">
        @if (File::exists(public_path($product->image)))
          <img src="{{ asset($product->image) }}" alt="product-image">
        @else
          <img src="{{$product->image}}" alt="product-image">
        @endif
      </div>
    </div>

    <div class="col mx-auto detail-col" >
    <div class="details">
        <div class="info">
            <div class="title">
              <h3>{{$product->name}}</h3>
            </div>
            <div class="more">
              <h5>Category</h5>
              <h6>{{$product->category}}</h6>
              <h5>Price</h5>
              <h6>Rp {{number_format($product->price,0,',','.')}}</h6>
              <h5>Description</h5>
              <h6>{{$product->description}}</h6>
            </div>

          @if(!(Session::get('user')))
          <a href="/login">
            <div class="btn btn-primary">
              Login to Buy
            </div>
          </a>
          @endif

          @if(Session::get('user') && Session::get('user')['role']==='customer')
          <div class="form_qty">


            <form action="/addcart" method="post" class="qty-form ">
              @csrf

                <input type="hidden" name="id" value="{{$product->id}}">
                <div class="form-group" style="display: flex; justify-content: center; align-content: center">
                    <label for="qty" class="me-3">Quantity:  </label>
                    <input class="form-control mb-2 @error('qty') is-invalid  @enderror" type="number" name="qty"  value="{{old('qty')}}" oninput="validity.valid||(value='');">
                  </div>
                  <button class="btn btn-primary" type="submit">Add to Cart</button>
              @error('qty')

                <small class="error-message">
                  {{$message}}
                </small>
              @enderror
              @if(session()->has('success'))
                <div class="alert alert-success mt-4">
                    {{ session()->get('success') }}
                </div>
            @endif

            </form>
             </div>
            </div>
            @endif
    </div>
    </div>
  </div>




</div>
@else
<div class="h1">
  Product Not Found!
</div>
@endif

@endsection

@section('script')
<script>
  document.querySelector('input[name="qty"]').addEventListener('input', function () {
    if (this.value !== '' && this.value < 1) {
      this.value = 1;
    }
  });
</script>
@endsection