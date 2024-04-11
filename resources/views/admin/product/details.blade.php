@extends('admin.layouts.master');

@section('title')
    {{ $product->name }}
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">

                    @if (session('adminAccountUpdateSuccess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('adminAccountUpdateSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-body">

                            <div class="" onclick="history.back()" style="cursor: pointer" title="Back">
                                <i class="bi bi-arrow-left-circle-fill fs-1"></i>
                            </div>

                            <div class="card-title">
                                <h3 class="text-center title-2">Product Info</h3>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-3 offset-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="">
                                </div>
                                <div class="col-5 offset-1">
                                    <h4 class="my-3">
                                        <i class="bi bi-chat-text-fill me-2"></i>
                                        {{ $product->name }}
                                    </h4>
                                    <h4 class="my-3">

                                        <i class="bi bi-cash-coin me-2"></i>
                                        {{ $product->price }} Kyats
                                    </h4>
                                    <h4 class="my-3">
                                        <i class="bi bi-alarm-fill me-2"></i>

                                        {{ $product->waiting_time }} Minutes Waiting Time
                                    </h4>
                                    <h4 class="my-3">
                                        <i class="bi bi-eye-fill me-2"></i>

                                        {{ $product->view_count }} View Conunts
                                    </h4>

                                    <h4 class="my-3">
                                        <i class="bi bi-database me-2"></i>

                                        Category : {{ $product->category_name }}
                                    </h4>

                                    <div class="my-3">
                                        <h4 class="mb-1">
                                            <i class="bi bi-info-square-fill me-2"></i>

                                            Description
                                        </h4>
                                        <p class="text-muted">
                                            {{ $product->description }}
                                        </p>
                                    </div>

                                    <h4>
                                        First Introduced At : {{ $product->created_at->format('j/F/Y') }}
                                    </h4>

                                    <div class="row">
                                        <div class="mt-3">
                                            <a href="{{ route('product#goToEditPage', $product->id) }}" class="d-block">
                                                <button class="btn btn-dark text-white">
                                                    <i class="bi bi-pencil-square me-2"></i>Edit The Product
                                                </button>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
    </div>
@endsection
