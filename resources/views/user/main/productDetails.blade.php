@extends('user.layouts.master')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
    <input type="hidden" value="{{ Auth::user()->id }}" id="userId" disabled>
    <input type="hidden" value="{{ $product->id }}" id="productId" disabled>
    <div id="allData" data-user-id="{{ Auth::user()->id }}" data-product-id="{{ $product->id }}"></div>
    <div class="container-fluid pb-5">

        <div class="row px-xl-5">
            <a href="{{ route('user#goToHomePage') }}" class="col-lg-12 mb-2">
                <div class="btn btn-dark fs-2">
                    <i class="bi bi-arrow-left-square-fill me-1"></i> Back To Home
                </div>
            </a>
            <div class="col-lg-5 mb-30">
                {{-- <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('storage/'.$product->image) }}" alt="Image">
                        </div>
                    </div>
                </div> --}}
                <div class="d-flex w-100" style="height: 500px">
                    <img class="w-100 h-100" src="{{ asset('storage/' . $product->image) }}" alt="Image">
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $product->name }}</h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">{{ $product->view_count + 1 }} <i class="ms-1 bi bi-eye-fill"></i></small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $product->price }} Kyats</h3>
                    <p class="mb-4">{{ $product->description }}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>

                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1"
                                id="productCount">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary px-3" id="btnAddToCart"><i
                                class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also
                Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($allProducts as $item)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <div class="d-flex w-100" style="height: 300px">
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $item->image) }}"
                                        alt="">
                                </div>
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href="" title="Add To Cart">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>

                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('user#product#goToDetailsPage', $item->id) }}" title="See Details">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate"
                                    href="{{ route('user#product#goToDetailsPage', $item->id) }}">{{ $item->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $item->price }} Kyats</h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>{{ $item->view_count }} <i class="ms-1 bi bi-eye-fill"></i></small>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

            increase_view_count_of_the_product();

            handle_add_to_cart_button_event();

            //TODO increase view count
            function increase_view_count_of_the_product() {
                const allData = document.getElementById("allData");
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/increaseViewCount',
                    data: {
                        "userId" : allData.dataset.userId,
                        "productId" : allData.dataset.productId
                    },
                    dataType: 'json'
                })
            }/* increase view count ends */

            //TODO handle add to cart button event
            function handle_add_to_cart_button_event() {
                $('#btnAddToCart').click(function() {

                const exportData = {
                    'count': $('#productCount')[0].value,
                    'userId': $('#userId')[0].value,
                    'productId': $('#productId')[0].value
                }

                $.ajax({
                    type: 'get',
                    url: '/user/ajax/addToCart',
                    data: exportData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = '/user/homePage';
                        }
                    }
                });
            });
            }/* handle add to cart button event endssss */
        });
    </script>
@endsection
