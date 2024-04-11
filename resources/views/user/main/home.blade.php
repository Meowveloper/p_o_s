@extends('user.layouts.master')

@section('title')
    Home
@endsection

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                        Categories</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="d-flex align-items-center justify-content-between mb-3">

                            <h3>Categories</h3>
                            <span class="p-1 border font-weight-normal"> {{ count($categories) }} </span>
                        </div>
                        <hr style="height: 2px; background-color: black;">
                        @foreach ($categories as $c)
                            <div class="d-flex align-items-center justify-content-between mb-3">

                                <a href="{{ route('user#filter#byCategories', $c->id) }}">
                                    <label
                                        class="@if ($filteredId == $c->id) bg-success text-white shdow-sm p-1 @else text-dark @endif"
                                        for="price-1">{{ $c->name }}</label>
                                </a>
                                {{-- <span class="badge border font-weight-normal">150</span> --}}
                            </div>
                        @endforeach

                        <a href="{{ route('user#goToHomePage') }}" class="btn btn-dark">
                            Clear Filteration
                        </a>


                    </form>
                </div>
                <!-- Price End -->
                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>


                                <a href="{{ route('user#cart#goToCartPage') }}" title="Your Cart">
                                    <button class="btn btn-sm btn-light ml-2"><i
                                            class="bi bi-cart-fill me-1"></i>{{ count($cart) }}</button>
                                </a>
                                <a href="{{ route('user#order#goToHistoryPage') }}" title="Order History">
                                    <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars me-1"></i> Order History <span class="ms-1 bg-dark text-white p-1 rounded">{{ count($history) }}</span></button>
                                </a>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" id="asc">Ascending</a>
                                        <a class="dropdown-item" href="#" id="desc">Descending</a>
                                        {{-- <a class="dropdown-item" href="#">Best Rating</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="productsContainer">
                        @if (count($products) != 0)
                            @foreach ($products as $item)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4 shadow">
                                        <div class="product-img position-relative overflow-hidden">
                                            <div class="d-flex" style="width: 100%; height:250px">
                                                <img class="img-fluid w-100" src="{{ asset('storage/' . $item->image) }}"
                                                    alt="">
                                            </div>
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""
                                                    title="Add To Cart">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </a>

                                                <a class="btn btn-outline-dark btn-square"
                                                    href="{{ route('user#product#goToDetailsPage', $item->id) }}"
                                                    title="See Details">
                                                    <i class="bi bi-info-circle-fill"></i>
                                                </a>

                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate"
                                                href="{{ route('user#product#goToDetailsPage', $item->id) }}">{{ $item->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $item->price }} kyats</h5>
                                                {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3>There is no available products of your preferation yet. Try out other products of ours..
                            </h3>
                        @endif

                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

            $('#asc').click(() => {
                sorting('asc');
            });
            $('#desc').click(() => {
                sorting('desc');
            });

            function sorting(sortingOption) {
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/productList',
                    data: '',
                    dataType: 'json',
                    success: function(response) {
                        if (sortingOption == 'asc') {
                            response.sort(function(a, b) {
                                return new Date(a.created_at) - new Date(b.created_at);
                            })
                        } else if (sortingOption == 'desc') {
                            response.sort(function(a, b) {
                                return new Date(b.created_at) - new Date(a.created_at);
                            });
                        }
                        let list = '';

                        response.forEach((item, i) => {
                            list += `
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4 shadow">
                                <div class="product-img position-relative overflow-hidden">
                                    <div class="d-flex" style="width: 100%; height:250px">
                                        <img class="img-fluid w-100" src="{{ asset('storage/${item.image}') }}"
                                            alt="">
                                    </div>
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href="">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                        <a class="btn btn-outline-dark btn-square" href="">
                                            <i class="bi bi-info-circle-fill"></i>
                                        </a>

                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="">${item.name}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>${item.price} kyats</h5>
                                        {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        });

                        $('#productsContainer')[0].innerHTML = list;

                    }
                });

            }

        });
    </script>
@endsection
