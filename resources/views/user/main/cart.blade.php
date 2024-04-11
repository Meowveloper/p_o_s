@extends('user.layouts.master')

@section('title')
    {{ Auth::user()->name }}'s Cart
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <input type="hidden" name="" value="{{ Auth::user()->id }}" id="user_id">
                    <tbody class="align-middle">
                        @foreach ($cart as $item)
                            {{-- TODO hidden tags --}}
                            <input type="hidden" name="" value="{{ $item->product_id }}" class="product_id">
                            <input type="hidden" value="{{ $item->id }}" class="cartIdForEachRow">

                            {{-- ---------------- --}}
                            <tr class="cart_row">
                                <td class="align-middle">
                                    <div class="d-flex" style="height: 150px">
                                        <img src="{{ asset('storage/' . $item->product_image) }}" alt=""
                                            style="width: 100%;">
                                    </div>
                                </td>
                                <td class="align-middle">
                                    {{ $item->product_name }}
                                </td>
                                <td class="align-middle"><span class="span_price">{{ $item->product_price }}</span> Kyats
                                </td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary border-0 text-center input_qty"
                                            value="{{ $item->qty }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="total_forEach_cart_item">{{ $item->product_price * $item->qty }}</span>
                                    Kyats
                                </td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-danger btn_remove_from_cart">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotal">{{ $cartTotalPrice }} Kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">3000 Kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalTotal">@if ($cartTotalPrice == 0) 0 @else {{$cartTotalPrice + 3000}} @endif Kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="btnCheckOut">Proceed To
                            Checkout</button>

                        <button class="btn btn-block btn-success font-weight-bold my-3 py-3" id="btnClearCart">
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scriptSource')
    <script>
        $(document).ready(function() {


            everything_in_pure_JavaScript();



            function everything_in_pure_JavaScript() {
                function d(element) {
                    return document.querySelectorAll(element);
                }

                handling_plus_and_minus_buttons();
                handling_remove_buttons();
                handling_clear_cart_button();

                //=========================================

                //TODO handling_plus_and_minus_buttons
                function handling_plus_and_minus_buttons() {
                    d('.btn-plus').forEach((item, i) => {
                        totalPriceControlForEachCartItem(item, i);
                    });
                    d('.btn-minus').forEach((item, i) => {
                        totalPriceControlForEachCartItem(item, i);
                    });

                    function totalPriceControlForEachCartItem(item, i) {
                        item.onclick = () => {
                            d('.total_forEach_cart_item')[i].innerHTML =
                                `${Number(d('.span_price')[i].innerHTML) * Number(d('.input_qty')[i].value)} `;

                            calculating_total_price_of_all_cart_items();
                        }
                    }
                }
                //============================================end function


                //TODO handling remove buttons
                function handling_remove_buttons() {
                    d('.btn_remove_from_cart').forEach((item, i) => {
                        item.onclick = () => {
                            const cartIdForEachRow = d('.cartIdForEachRow')[i].value;
                            d('.btn-plus')[i].remove();
                            d('.btn-minus')[i].remove();
                            d('.cart_row')[i].remove();
                            d('.product_id')[i].remove();
                            everything_in_pure_JavaScript();
                            calculating_total_price_of_all_cart_items();

                            $.ajax({
                                type: 'get',
                                url: '/user/ajax/removeAProductFromCart',
                                data: {id : cartIdForEachRow},
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status) {
                                        window.location.href =
                                            '/user/homePage'
                                    }
                                }
                            });
                        }
                    });
                }
                //-----------------------------------------end function



                //TODO calculating_total_price_of_all_cart_items
                function calculating_total_price_of_all_cart_items() {
                    let total = 0;
                    d('.total_forEach_cart_item').forEach((item, i) => {
                        total += Number(item.innerHTML);

                    });
                    d('#subTotal')[0].innerHTML = `${total} Kyats`;
                    d('#finalTotal')[0].innerHTML = `${total === 0 ? 0 : total + 3000} Kyats`;
                }


                //TODO handling the Check Out Button
                d('#btnCheckOut')[0].onclick = function() {
                    everything_in_pure_JavaScript();

                    let checkOutInfos = [];


                    class OneCheckOut {
                        constructor(user_id, product_id, qty, total, orderCode) {
                            this.user_id = user_id;
                            this.product_id = product_id;
                            this.qty = qty;
                            this.total = Number(total);
                            this.order_code = orderCode;
                        }
                    }

                    const forOrderCode = new Date().getTime();

                    d('.product_id').forEach((item, i) => {
                        const oneItem = new OneCheckOut(
                            d('#user_id')[0].value,
                            item.value,
                            d('.input_qty')[i].value,
                            d('.total_forEach_cart_item')[i].innerHTML,
                            forOrderCode
                        );
                        checkOutInfos.push(oneItem);
                    });

                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/checkOut',
                        data: Object.assign({}, checkOutInfos),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                window.location.href = '/user/homePage'
                            }
                        }
                    });


                }

                //TODO handling the clear cart button
                function handling_clear_cart_button() {
                    d('#btnClearCart')[0].addEventListener('click', () => {


                        d('.cart_row').forEach((item) => {
                            item.remove();
                        });
                        everything_in_pure_JavaScript();

                        calculating_total_price_of_all_cart_items();

                        $.ajax({
                            type: 'get',
                            url: '/user/ajax/clearCart',
                            dataType: 'json',
                        })
                    })
                }

            }


        });
    </script>
@endsection
