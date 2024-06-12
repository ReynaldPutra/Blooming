@extends('layout')
@section('title','Product Detail')


@section('style')
<link rel="stylesheet" href="{{ asset('/css/checkOutForm.css') }}"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container hero-content">
    <div class="text-center">
        <h1 class="mb-1 mt-5 fw-bold">CHECK OUT</h1>
    </div>

    <div class="mt-5 ">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="checkout-form mb-5">
                        @if($errors->any())
                                <div class="alert alert-danger" role="alert"></div>
                            {{$errors->first()}}
                        @endif
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif
                        <form method="POST" action="/checkout">
                            @csrf

                            <h3 class="mb-3">Sender</h3>
                            <div class="form-group mb-3">
                                <label for="email">Sender Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{Session::get('user')['email']}}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="senderName">Sender Name</label>
                                <input type="text" class="form-control me-3" id="senderName" name="senderName" placeholder="Sender Name" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="senderPhone">Sender Phone</label>
                                <input type="number" class="form-control me-3 mb-3" id="senderPhone" name="senderPhone" placeholder="Sender Phone" required >
                            </div>


                            <h3 class="mb-3">Delivery</h3>
                            <div class="form-group mb-3">
                                <label for="recipientName">Recipient Name</label>
                                    <input type="text" class="form-control me-3" id="recipientName" name="recipientName" placeholder="Recipient Name" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="recipientNumber">Recipient Phone</label>
                                <input type="number" class="form-control me-3 mb-3" id="recipientNumber" name="recipientNumber" placeholder="Recipient Number" required >
                            </div>

                            <div class="form-group mb-3">
                                <label for="deliveryOptions">Delivery Options</label>
                                <div class="d-flex">
                                    <input type="radio" class="me-2 form-check-input" id="car" name="deliveryOption" value="car" checked onclick="setDeliveryCost('car')">
                                    <label for="car" class="me-3 fs-6">Car (More Safety)</label>

                                    <input type="radio" class="me-2 form-check-input" id="motorcycle" name="deliveryOption" value="motorcycle" onclick="setDeliveryCost('motorcycle')">
                                    <label for="motorcycle" class="me-3 fs-6">Motorcycle</label>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="datepicker" class="form-label">Delivery Date</label>
                                <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Select date">
                            </div>

                            <div class="form-group mb-3">
                                <label for="deliveryTime">Delivery Time</label>
                                <select name="deliveryTime" id="deliveryTime" class="form-control">
                                    <option value="9am - 2pm">9am - 2pm</option>
                                    <option value="3pm - 5pm">3pm - 5pm</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="province">Province</label>
                                <input type="text" class="form-control me-3 mb-3" id="province" name="province" placeholder="Province" required>
                            </div>

                            <div class="form-group mb-3">
                            <label for="city">City</label>
                                <div class="d-flex mb-3">
                                    <input type="text" class="form-control me-3" id="city" name="city" placeholder="City" >
                                    <input type="number" class="form-control" id="postalCode" name="postalCode" placeholder="Postal Code" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="deliveryAddress">Delivery Address</label>
                                <textarea class="form-control" name="deliveryAddress" id="deliveryAddress"  placeholder="Delivery Address" cols="30" rows="5" required></textarea>
                            </div>

                            <h3 class="mb-3">Payment</h3>
                            <div class="form-group mb-3">
                                <ul class="accordion">
                                    <li>
                                        <input type="radio" name="paymentMethod" class="ms-3 mt-3 va form-check-input" id="va" value="Bank Transfer" checked>
                                        <label for="va">Bank Transfer BCA</label>
                                        <div class="detailPayment">
                                            <h5 class="mt-2 text-center">Make a transfer to our BCA account</h5>
                                            <h4  class=" text-center">PT Blooming Florist</h4>
                                            <h4  class=" text-center">BCA - 123 12345 123</h4>
                                        </div>
                                    </li>

                                    <li>
                                        <input type="radio" name="paymentMethod" class="ms-3 mt-3 qris form-check-input" id="qris" value="E-Wallet" >
                                        <label for="qris">Payment By QRIS</label>
                                        <div class="detailPayment">
                                            <div class="text-center">
                                                <h5 class="mt-2">Make a Payment to our QRIS</h5>
                                                <img width="250" src="/asset/QrCode.svg" alt="#" /></a>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>


                            <button type="submit" class="btn btn-primary">Complete Order</button>

                            <input type="hidden" name="cart_id" value="{{ $cart_items->id }}">
                            <input type="hidden" id="subTotalInput" name="subTotal">
                            <input type="hidden" id="deliveryPriceInput" name="deliveryPrice">
                            <input type="hidden" id="serviceCostInput" name="serviceCost">
                            <input type="hidden" id="totalPriceInput" name="totalPrice">

                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <table class="table table-striped cart-table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Item Image</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Price</th>
                            <th scope="col">Item qty</th>
                            <th scope="col">Total Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for ($i = 0; $i < count($cart_items->cartDetail()->get()); $i++)
                        <tr>
                            <th scope="row">{{$i+1}}</th>
                            <td>
                                @if (Storage::disk('public')->exists($cart_items->cartDetail()->get()[$i]->item()->first()->image))
                                <img src="{{Storage::url($cart_items->cartDetail()->get()[$i]->item()->first()->image)}}" alt="card-image" width="90" height="90">
                                @else
                                <img src="{{$cart_items->cartDetail()->get()[$i]->item()->first()->image}}" alt="card-image" width="90" height="90">
                                @endif
                            <td>{{$cart_items->cartDetail()->get()[$i]->item()->first()->name}}</td>
                            <td>Rp {{ number_format($cart_items->cartDetail()->get()[$i]->item()->first()->price,0,',','.')}}</td>
                            <td class="qty">
                                {{$cart_items->cartDetail()->get()[$i]->qty}}
                            </td>

                            <td class="total-price">Rp {{number_format($cart_items->cartDetail()->get()[$i]->qty*$cart_items->cartDetail()->get()[$i]->item()->first()->price,0,',','.')}}</td>
                          </tr>

                          @endfor
                        </tbody>
                      </table>
                      <div class="d-flex justify-content-between">
                          <h5>Sub Total</h5>
                          <h5><strong id="cart-sum" data-sum="{{ $cart_items->sum }}"> Rp {{number_format($cart_items->sum,0,',','.')}}</strong></h5>
                      </div>
                      <div class="d-flex justify-content-between">
                        <h5 id="deliveryType">Delivery by Car</h5>
                        <h5><strong id="deliveryCost"> Rp 40.000</strong></h5>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h5>Service 2%</h5>
                        <h5><strong id="serviceCost"> Rp 0</strong></h5>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h4>Total Price</h4>
                        <h4><strong id="totalPrice"> Rp 0</strong></h4>
                    </div>
                </div>
            </div>
    </div>
</div>

<div id="loadingModal" class="modal">
    <div class="modal-content">
        <div class="loader" id="loader"></div>
        <p id="modalMessage" class="modalMessage">Checking Payment...</p>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script async>
  // Initialize datepicker
  $(document).ready(function(){
    $('#datepicker').datepicker({
        format: 'dd MM yyyy',
        autoclose: true,
        startDate: '+0d',
        endDate: '+5m',
        todayBtn: "linked",
        clearBtn: true,
    });


    var deliveryPrice  = 40000;
    calculateServiceCost(deliveryPrice);
    });

    document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting immediately
    var modal = document.getElementById('loadingModal');
    var loader = document.getElementById('loader');
    var modalMessage = document.getElementById('modalMessage');
    modal.style.display = 'flex';

    // Simulate a payment check process with a timeout
    setTimeout(function() {
        // Hide the loader and show the success message
        loader.style.display = 'none';
        modalMessage.innerHTML  = '<div><i class="fas fa-check-circle check-icon" style="color: #63E6BE;"></i></div> Payment Success!';

        // Further delay to close the modal and submit the form
        setTimeout(function() {
            modal.style.display = 'none';
            event.target.submit();
        }, 2000); // Adjust the time as needed for the success message display
    }, 4000); // Adjust the time as needed
});

     function setDeliveryCost(option) {
        var deliveryCost = document.getElementById('deliveryCost');
        var deliveryType = document.getElementById('deliveryType');
        var deliveryPrice;
        if (option === 'car') {
            deliveryPrice = 40000;
            deliveryCost.innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(deliveryPrice);
            deliveryType.innerHTML = 'Delivery by Car';
        } else if (option === 'motorcycle') {
            deliveryPrice = 20000;
            deliveryCost.innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(deliveryPrice);
            deliveryType.innerHTML = 'Delivery by Motorcycle';
        }
        calculateServiceCost(deliveryPrice);
    }

    function calculateServiceCost(deliveryPrice) {
        var subTotalString = document.getElementById('cart-sum').getAttribute('data-sum');
        var subTotal = parseFloat(subTotalString);
        deliveryPrice = parseFloat(deliveryPrice);

        if (isNaN(subTotal) || isNaN(deliveryPrice)) {
        console.error('Invalid subTotal or deliveryPrice:', subTotalString, deliveryPrice);
        return;
    }
        var serviceCost = (subTotal + deliveryPrice) * 0.02;

        document.getElementById('serviceCost').innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(serviceCost);

        calculateTotalPrice(subTotal,deliveryPrice,serviceCost);
    }

    function calculateTotalPrice(subTotal,deliveryPrice,serviceCost) {
        var totalPrice = parseFloat(subTotal + deliveryPrice + serviceCost);
        if (isNaN(totalPrice) ) {
            console.error('Invalid totalPrice', totalPrice);
            return;
        }

    document.getElementById('totalPrice').innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalPrice);
    document.getElementById('subTotalInput').value = subTotal.toFixed(0);
        document.getElementById('deliveryPriceInput').value = deliveryPrice.toFixed(0);
        document.getElementById('serviceCostInput').value = serviceCost.toFixed(0);
        document.getElementById('totalPriceInput').value = totalPrice.toFixed(0);
    }




</script>
@endsection
