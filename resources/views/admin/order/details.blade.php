@extends('admin.layouts.master');

@section('title')
@endsection

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">

                    <div class="p-5 shadow">
                        <h2 class="mb-3 text-center">Order Code: <span class="ms-1 text-muted">{{ $orderDetails[0]->order_code }}</span></h2>
                        <hr>
                        <div class="d-flex justify-contents-center align-items-center gap-1 mb-3">
                            <h3>Ordered By : <span class="text-success">{{ $orderDetails[0]->user_name }}</span></h3>
                            <div class="d-flex" style="width: 100px; height: 100px">
                                @if ($orderDetails[0]->user_image == null)
                                    <img src="{{ asset('image/default_user_profile.png') }}" alt="" width="100%" style="background: none; border-radius: 50%; margin-left: 2px">
                                @else
                                    <img src="{{ asset('storage/'.$orderDetails[0]->user_image) }}" alt="" width="100%">
                                @endif
                            </div>
                        </div>
                        <hr>

                        <h4 class="mb-3">At: <span class="text-primary ms-1">{{ $orderDetails[0]->created_at->format('j-F-Y') }}</span></h4>
                        <hr>

                        <h4>Final Cost(Shipping Cost Included): <span class="text-warning ms-1">{{$wholeTotal + 3000}}</span><span class="ms-1">Kyats</span></h4>
                    </div>
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product's Name</th>
                                <th>Cost per Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="spacer"></tr>

                            @foreach ($orderDetails as $item)
                                <tr class="tr-shadow">
                                    <td class="d-flex col-7">
                                        <img style="width: 100%" src="{{ asset('storage/'.$item->product_image) }}" alt="">
                                    </td>
                                    <td>{{$item->product_name}}</td>
                                    <td>{{ $item->product_price }}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{$item->total}}</td>
                                </tr>
                                <tr class="spacer"></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_source')
@endsection
