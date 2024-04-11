@extends('user.layouts.master');

@section('title')
    Your Profile
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">

                    @if (session('userAccountUpdateSuccess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('userAccountUpdateSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Info</h3>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-3 offset-2 d-flex">
                                    @if (Auth::user()->image == null)
                                        <img src="{{ asset('image/default_user_profile.png') }}" alt=""
                                            class="img-thubnail shadow-sm w-100">
                                    @else
                                        <img src="{{ asset('storage/'.Auth::user()->image) }}"
                                            alt="{{ Auth::user()->name }}" class="img-thubnail shadow-sm w-100"/>
                                    @endif
                                </div>
                                <div class="col-5 offset-1">
                                    <h4 class="my-3">
                                        <i class="bi bi-person-fill me-2"></i>
                                        {{ Auth::user()->name }}
                                    </h4>
                                    <h4 class="my-3">

                                        <i class="bi bi-envelope-at-fill me-2"></i>
                                        {{ Auth::user()->email }}
                                    </h4>
                                    <h4 class="my-3">
                                        <i class="bi bi-phone-fill me-2"></i>

                                        {{ Auth::user()->phone }}
                                    </h4>
                                    <h4 class="my-3">
                                        <i class="bi bi-house-door-fill me-2"></i>

                                        {{ Auth::user()->address }}
                                    </h4>

                                    <h4 class="my-3">
                                        <i class="bi bi-gender-trans me-2"></i>

                                        {{ Auth::user()->gender }}
                                    </h4>

                                    <h4>
                                        Joined at : {{ Auth::user()->created_at->format('j/F/Y') }}
                                    </h4>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4 offset-2 mt-3">
                                    <a href="{{ route('user#account#goToEditPage') }}">
                                        <button class="btn btn-dark text-white">
                                            <i class="bi bi-pencil-square me-2"></i>Edit Profile
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
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
    </div>
@endsection
