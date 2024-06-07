@extends('layout')

@section('title', 'Cart')

@section('style')
<link rel="stylesheet" href="{{ asset('/css/cart.css') }}"/>
@endsection

@section('content')
<div class="container hero-content">
  <h1 class="mt-5 mb-5 fw-bold text-center text-uppercase">My Cart</h1>
  @if($cartitems != null && count($cartitems->cartDetail) > 0)
    @if(session()->has('success'))
      <div class="alert alert-dark alert-dismissible fade show d-flex" role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="close bg-danger text-light border-1 border-danger ms-auto px-2 rounded" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    <table class="table table-striped cart-table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Item Image</th>
          <th scope="col">Item Name</th>
          <th scope="col">Item Price</th>
          <th scope="col">Item qty</th>
          <th scope="col">Detail Item</th>
          <th scope="col">Total Price</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($cartitems->cartDetail as $index => $cartDetail)
        <form method="post">
        @csrf
        <tr>
          <th scope="row">{{ $index + 1 }}</th>
          <td>
            @if (Storage::disk('public')->exists($cartDetail->item->image))
              <img src="{{ Storage::url($cartDetail->item->image) }}" alt="card-image" width="200" height="200">
            @else
              <img src="{{ $cartDetail->item->image }}" alt="card-image" width="200" height="200">
            @endif
          <td>{{ $cartDetail->item->name }}</td>
          <td>IDR {{ $cartDetail->item->price }}</td>
          <td class="qty">
              {{ $cartDetail->qty }}
          </td>

          <td>
            @if($cartDetail->detail_item)
           
                <strong>Size</strong> <br>
                <li>{{ $cartDetail->detail_item->size }} <br></li>

                <strong>Flower</strong> <br>
                @foreach($cartDetail->detail_item->flower as $flower)
                <li>{{ $flower }} <br></li>
                @endforeach 

                <strong>Filler</strong> <br>
                @foreach($cartDetail->detail_item->fillers as $filler)
                <li>{{ $filler }}<br></li>
                @endforeach

                <strong>Leaves</strong> <br>
                <li>{{ $cartDetail->detail_item->leaves }}<br></li>

                <strong>Paper</strong> <br>
                <li>{{ $cartDetail->detail_item->color }}<br></li>

                <strong>Ribbon</strong> <br>
                <li>{{ $cartDetail->detail_item->ribbon }}<br></li>
              
            @else
                <!-- Handle case when detail_item is null or invalid -->
            @endif
          </td>

          <td class="total-price">IDR {{ $cartDetail->qty * $cartDetail->item->price }}</td>
          <td>
              <input type="hidden" name="cart_id" value="{{ $cartDetail->cart_id }}">
              <input type="hidden" name="item_id" value="{{ $cartDetail->item_id }}">
              <div id="action">
              <a href="/updateCartqty/{{ $cartDetail->item->id }}"><button type="button" class="btn btn-primary btn-sm">Update</button></a>
              <button onclick="return confirm('Are You Sure To Delete This Cart?')" class="btn btn-danger btn-sm" formaction="/deleteCartItem" type="submit">Delete</button>
              </div>
          </td>
        </tr>
        </form>
        @endforeach
      </tbody>
    </table>

    <div class="d-flex">
      <h4>Grand Total: <span class="grand-total">IDR {{ $cartitems->sum }}</span></h4>
      <a href="/checkOutForm" class="ms-auto"><button type="button" class="btn btn-primary btn-sm p-2">Check Out</button></a>
    </div>
  @else
    <h3 class="text-center pb-5 mt-5 pt-5">Cart is empty! Let’s go shopping :)</h3>
  @endif
</div>
@endsection
