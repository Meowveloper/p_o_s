@extends('admin.layouts.master')

@section('title')
    Change {{ $account->name }}'s Role
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
                            <button onclick="history.back()" class="btn btn-dark text-white my-2" type="submit">
                                <---
                            </button>
                            <div class="card-title">
                                <h3 class="text-center title-2">Change {{ $account->name }}'s Role</h3>
                            </div>
                            <hr>

                            <form action="{{ route('admin#changeARole', $account->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf


                                <div class="row">
                                    <div class="col-4 offset-1">
                                        @if ($account->image == null)
                                            <img src="{{ asset('image/default_user_profile.png') }}" alt=""
                                                class="img-thubnail shadow-sm">
                                        @else
                                            <img src="{{ asset('storage/' . $account->image) }}"
                                                class="img-thubnail shadow-sm" />
                                        @endif

                                        <div class="mt-3">
                                            <button class="btn btn-dark text-white col-12" type="submit">
                                                <i class="bi bi-check2 me-1"></i>Change Role
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input disabled id="cc-pament" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Name..."
                                                value="{{ old('name', $account->name) }}">

                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Role</label>
                                            <select name="role" id=""
                                                class="form-control @error('role') is-invalid @enderror">
                                                <option value="admin" @if ($account->role == 'admin') selected @endif>
                                                    Admin</option>
                                                <option value="user" @if ($account->role == 'user') selected @endif>
                                                    User</option>
                                            </select>

                                            @error('role')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>



                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Email</label>
                                            <input disabled id="cc-pament" name="email" type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Email..."
                                                value="{{ old('email', $account->email) }}">

                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Phone</label>
                                            <input disabled id="cc-pament" name="phone" type="number"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Phone..."
                                                value="{{ old('phone', $account->phone) }}">

                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Gender</label>

                                            <select disabled class="form-control" name="gender" id="">
                                                <option value="male" @if ($account->gender == 'male') selected @endif>
                                                    Male</option>
                                                <option value="female" @if ($account->gender == 'female') selected @endif>
                                                    Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Address</label>
                                            <textarea disabled name="address" class="form-control" cols="30" rows="10">{{ old('address', $account->address) }}</textarea>

                                            @error('address')
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
