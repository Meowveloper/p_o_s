@extends('admin.layouts.master')

@section('title')
    Update {{ $user->name }}
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
                            <h3 class="text-center title-2">Details of {{ $user->name }}</h3>
                        </div>
                        <hr>

                        <form action="{{ route('admin#userManagement#updateUser') }}" method="POST" enctype="multipart/form-data" id="userUpdateForm">
                            @csrf

                            <input type="hidden" name="userId" value="{{ $user->id }}" id="forInformation" data-user-name="{{ $user->name }}">
                            <div class="row">
                                <div class="col-4 offset-1">
                                    @if ($user->image == null)
                                        <img src="{{ asset('image/default_user_profile.png') }}" alt=""
                                            style="background: none; border-radius: 50%;" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/' . $user->image) }}" alt=""
                                            class="img-thumbnail">
                                    @endif

                                    <div class="mt-3">
                                        <label for="" class="control-label mb-1">Upload {{ $user->name }}'s Image</label>
                                        <input type="file" name="userImage" class="form-control @error('userImage') is-invalid @enderror" id="">
                                        @error('userImage')
                                            <span class="invalid-feedback"></span>
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
                                        <input id="cc-pament" name="userName" type="text"
                                            class="form-control @error('userName') is-invalid @enderror"
                                            aria-required="true" aria-invalid="false" placeholder="Enter User's Name..." value="{{ old('userName', $user->name) }}">

                                        @error('userName')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Email</label>
                                        <input name="userEmail" class="form-control" placeholder="Enter User's email" value="{{ old('userEmail', $user->email) }}"/>

                                        @error('userEmail')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Role</label>

                                        <select class="form-control" name="userRole">
                                            <option value="user" selected>User</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="userPhone" type="number"
                                            class="form-control @error('userPhone') is-invalid @enderror"
                                            aria-required="true" aria-invalid="false" placeholder="Enter User's phone..." value="{{ old('userPhone', $user->phone) }}">

                                        @error('userPhone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Address</label>
                                        <input id="cc-pament" name="userAddress" type="text"
                                            class="form-control @error('userAddress') is-invalid @enderror"
                                            aria-required="true" aria-invalid="false" value="{{ old('userAddress', $user->address) }}" placeholder="Enter User's address">

                                        @error('userAddress')
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

@section('script_source')
    <script>
        document.getElementById('userUpdateForm').addEventListener('submit', () => {
            alertMessage()
        });

        function alertMessage() {
            alert(`Are you sure you want to update the information of the User ${document.getElementById('forInformation').dataset.userName}?? It could happen conflicts and misunderstandings.`);
        }
    </script>
@endsection

