@extends('admin.layouts.master');

@section('title')
    Admin Accounts List
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">

                    <div class="d-flex justify-content-between align-content-center my-3">
                        <div>
                            <h4>Search Key : <span class="text-danger ms-2 text-uppercase">{{ request('key') }}</span></h4>
                        </div>
                        <form class="w-25 d-flex justify-content-center align-items-lg-stretch gap-1"
                            action="{{ route('admin#goToAdminAccountsListPage') }}" method="GET">
                            <input type="text" name="key" class="form-control h-100" placeholder="Search.."
                                value="{{ request('key') }}">
                            <button type="submit" class="btn btn-dark">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="mb-3 shadow-sm py-2 px-1">
                        <h3>Total Admin Accounts resulted : <span class="text-success ms-2">{{ $admins->total() }}</span>
                        </h3>
                    </div>

                    {{-- @if (session('categoryCreated'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('categoryCreated') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> --}}
                    @if (session('anAdminAcountDeleted'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('anAdminAcountDeleted') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (count($admins) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>Profile Picture</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Date Registered</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="spacer"></tr>

                                    @foreach ($admins as $item)
                                        <tr class="tr-shadow">
                                            <td class="col-2">
                                                @if ($item->image == null)
                                                    <img src="{{ asset('image/default_user_profile.png') }}" alt=""
                                                        class="img-thubnail shadow-sm" />
                                                @else
                                                    <img src="{{ asset('storage/' . $item->image) }}"
                                                        alt="{{ $item->name }}" class="img-thubnail shadow-sm" />
                                                @endif
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->gender }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    {{-- <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="View">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button> --}}


                                                    @if ($item->id == Auth::user()->id)
                                                    @else
                                                        <a href="{{ route('admin#goToChangeRolePage', $item->id) }}" class="me-2">
                                                            <button class="item" data-toggle="tooltip"
                                                                data-placement="top" title="Change Role">
                                                                <i class="bi bi-person-fill-gear"></i>
                                                            </button>
                                                        </a>

                                                        <a href="{{ route('admin#deleteAnAdminAccount', $item->id) }}">
                                                            <button class="item" data-toggle="tooltip"
                                                                data-placement="top" title="Delete">
                                                                <i class="zmdi zmdi-delete"></i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $admins->links() }}
                            </div>
                        </div>
                    @else
                        <h3 class="text-secondary text-center mt-5">There is no admin accounts registered. Will you do the
                            honor??</h3>
                    @endif

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
    </div>
@endsection
