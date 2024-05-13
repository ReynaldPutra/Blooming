@extends('layout')
@section('title','Transaction History')

@section('style')
<link rel="stylesheet" href="{{ asset('/css/transactionHistory.css') }}"/>
@endsection

@section('content')
    <div class="container hero-content">
        <h1 class="mb-1 mt-5 mb-5 fw-bold text-uppercase text-center">Transaction History</h1>
        @if($histories!=null && count($histories)>0)

    <div class="accordion mt-4" id="accordion">
        @foreach($histories as $history)
        <div class="card">
            <div class="card-header bg-light btn_deg" id="heading{{$loop->iteration}}">
            <h5 class="mb-0 d-flex align-items-center">
                <button class="btn btn-link btn-block   text_deg btn_deg" type="button" data-toggle="collapse" data-target="#collapse{{$loop->iteration}}" aria-expanded="true" aria-controls="collapse{{$loop->iteration}}">
                    {{trim(explode(" ",$history->created)[0])}}

                    @if($loop->iteration == 1)
                        <i class="fas fa-chevron-up text_deg  btn_deg ms-3"></i>
                    @else
                        <i class="fas fa-chevron-down text_deg  btn_deg ms-3"></i>
                    @endif
                </button>
                
            </h5>
            </div>
            <div id="collapse{{$loop->iteration}}" class="collapse @if($loop->iteration == 1) show @endif" aria-labelledby="heading{{$loop->iteration}}" data-parent="#accordion">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">Image</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Price</th>
                            <th scope="col">qty</th>
                            <th scope="col">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history->transactionDetail()->get() as $transaction_detail)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>
                                    @if (Storage::disk('public')->exists($transaction_detail->item()->first()->image))
                                        <img src="{{Storage::url($transaction_detail->item()->first()->image)}}" alt="card-image" width="80" height="80">
                                    @else
                                        <img src="{{$transaction_detail->item()->first()->image}}" alt="card-image" width="80" height="80">
                                    @endif

                                </td>
                                <td>{{$transaction_detail->item()->first()->name}}</td>
                                <td>{{$transaction_detail->item()->first()->price}}</td>
                                <td>
                                    {{$transaction_detail->qty}}
                                </td>
                                <td>IDR {{$transaction_detail->qty*$transaction_detail->item()->first()->price}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <div class="text-end ">
                            <p><strong>Grand Total : IDR {{$history->sum}}</strong> </p>
                        </div>
                    </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <h3 class="text-center pb-5 mt-5 pt-5">No transaction yet.</h3>
    @endif
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var buttons = document.querySelectorAll('.card-header button[data-toggle="collapse"]');
        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                var icon = this.querySelector('i');
                var allIcons = document.querySelectorAll('.card-header button i');
                var collapseID = this.getAttribute('data-target');
                var collapse = document.querySelector(collapseID);
                var isExpanded = collapse.classList.contains('show');

                allIcons.forEach(function (icon) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                });

                if (isExpanded) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });
        });
    });
</script>

@endsection

