@extends('user.layouts.master');

@section('title')
    Change Password
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Change Your Password</h3>
                            </div>
                            <hr>
                            <form action="{{ route('user#changePassword') }}" method="post" novalidate="novalidate">
                                @csrf

                                @if (session('success'))
                                    <div class="text-success shadow-sm mb-3 p-2">
                                        <i class="bi bi-check2-all"></i>
                                        <strong>
                                            {{ session('success') }}
                                        </strong>
                                    </div>
                                @endif

                                @if (session('notMatch'))
                                    <div class="text-danger shadow-sm mb-3 p-2">
                                        <i class="bi bi-exclamation-square"></i>
                                        <strong>
                                            {{ session('notMatch') }}
                                        </strong>
                                    </div>
                                @endif


                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Old Password</label>
                                    <input id="cc-pament" name="oldPassword" type="password"
                                        class="form-control @error('oldPassword')
                                        is-invalid
                                    @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Old Password...">

                                    @error('oldPassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">New Password</label>
                                    <input id="cc-pament" name="newPassword" type="password"
                                        class="form-control @error('newPassword')
                                        is-invalid
                                    @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="New Password...">

                                    @error('newPassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Confirm Password</label>
                                    <input id="cc-pament" name="confirmPassword" type="password"
                                        class="form-control @error('confirmPassword')
                                        is-invalid
                                    @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Confirm Password...">

                                    @error('confirmPassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-dark btn-block">
                                        <span id="payment-button-amount">Change Password</span>
                                    </button>
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
