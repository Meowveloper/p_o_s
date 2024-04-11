@extends('admin.layouts.master')

@section('title')
    Edit {{ $product->name }}
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="" onclick="history.back()" style="cursor: pointer" title="Back">
                                <i class="bi bi-arrow-left-circle-fill fs-1"></i>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit The Product</h3>
                            </div>
                            <hr>

                            <form action="{{ route('product#editProduct') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="productId" value="{{ $product->id }}">
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        <img src="{{ asset('storage/'.$product->image) }}" alt=""
                                                class="img-thubnail shadow-sm">

                                        <div class="mt-3">
                                            <label for="" class="control-label mb-1">Upload your Image</label>
                                            <input type="file" name="productImage" class="form-control @error('productImage') is-invalid @enderror" id="">
                                            @error('productImage')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-dark text-white col-12" type="submit">
                                                <i class="bi bi-check2 me-1"></i>Update
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="productName" type="text"
                                                class="form-control @error('productName') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Product Name..." value="{{ old('productName', $product->name) }}">

                                            @error('productName')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>



                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Description</label>
                                            <textarea name="productDescription" class="form-control" cols="30" rows="10" placeholder="Enter Product Description">{{ old('productDescription', $product->description) }}</textarea>

                                            @error('productDescription')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Category</label>

                                            <select class="form-control" name="productCategory">
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}" @if ($product->category_id == $item->id) selected @endif>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Price</label>
                                            <input id="cc-pament" name="productPrice" type="number"
                                                class="form-control @error('productPrice') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Product Price..." value="{{ old('productPrice', $product->price) }}">

                                            @error('productPrice')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Waiting Time</label>
                                            <input id="cc-pament" name="productWaitingTime" type="number"
                                                class="form-control @error('productWaitingTime') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" value="{{ old('productWaitingTime', $product->waiting_time) }}" placeholder="Enter Product Waiting Time">

                                            @error('productWaitingTime')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">View Counts</label>
                                            <input id="cc-pament" name="viewCount" type="number"
                                                class="form-control"
                                                aria-required="true" aria-invalid="false" disabled value="{{ old('viewCount', $product->view_count) }}" disabled>

                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Created At</label>
                                            <input id="cc-pament" name="createdAt" type="number"
                                                class="form-control"
                                                aria-required="true" aria-invalid="false" disabled value="{{ old('createdAt', $product->created_at->format('j-F-Y')) }}" disabled>

                                        </div>
                                    </div>
                                </div>


                            </form>

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
