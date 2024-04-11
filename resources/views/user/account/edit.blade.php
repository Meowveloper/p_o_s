@extends('user.layouts.master')

@section('title')
    Edit Your Profile
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
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Your Account's Profile</h3>
                            </div>
                            <hr>

                            <form action="{{ route('user#account#editAccount', Auth::user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf


                                <div class="row">
                                    <div class="col-4 offset-1">
                                        <div class="d-flex">
                                            @if (Auth::user()->image == null)
                                                <img src="{{ asset('image/default_user_profile.png') }}" alt=""
                                                    class="img-thubnail shadow-sm w-100">
                                            @else
                                                <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                                    alt="{{ Auth::user()->name }}" class="img-thubnail shadow-sm w-100" />
                                            @endif
                                        </div>

                                        <div class="mt-3">
                                            <label for="" class="control-label mb-1">Upload your Image</label>
                                            <input type="file" name="image"
                                                class="form-control @error('image') is-invalid @enderror" id="">
                                            @error('image')
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
                                            <input id="cc-pament" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Name..."
                                                value="{{ old('name', Auth::user()->name) }}">

                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>



                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Email..."
                                                value="{{ old('email', Auth::user()->email) }}">

                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" type="number"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Phone..."
                                                value="{{ old('phone', Auth::user()->phone) }}">

                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Gender</label>

                                            <select class="form-control" name="gender" id="">
                                                <option value="male" @if (Auth::user()->gender == 'male') selected @endif>
                                                    Male</option>
                                                <option value="female" @if (Auth::user()->gender == 'female') selected @endif>
                                                    Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Address</label>
                                            <textarea name="address" class="form-control" cols="30" rows="10">{{ old('address', Auth::user()->address) }}</textarea>

                                            @error('address')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Role</label>
                                            <input id="cc-pament" name="role" type="text"
                                                class="form-control @error('role') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" disabled
                                                value="{{ old('role', Auth::user()->role) }}">

                                            @error('role')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
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
