@extends('admin.layouts.master');

@section('title')
    Category List
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Category List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('category#goToCategoryCreatePage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add category
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-content-center my-3">
                        <div>
                            <h4>Search Key : <span class="text-danger">{{ request('key') }}</span></h4>
                        </div>
                        <form class="w-25 d-flex justify-content-center align-items-lg-stretch gap-1"
                            action="{{ route('category#goToCategoryListPage') }}" method="GET">
                            <input type="text" name="key" class="form-control h-100" placeholder="Search.."
                                value="{{ request('key') }}">
                            <button type="submit" class="btn btn-dark">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="mb-3 shadow-sm py-2 px-1">
                        <h3>Total categories resulted : <span class="text-success">{{ $categories->total() }}</span></h3>
                    </div>

                    @if (session('categoryCreated'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('categoryCreated') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif (session('categoryDeleted'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('categoryDeleted') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (count($categories) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>Category ID</th>
                                        <th>Name</th>
                                        <th>Date created</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="spacer"></tr>

                                    @foreach ($categories as $item)
                                        <tr class="tr-shadow">
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    {{-- <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="View">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button> --}}
                                                    <a href="{{ route('category#goToCategoryEditPage', $item->id) }}" class="me-2">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>

                                                    <a href="{{ route('category#deleteCategory', $item->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $categories->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <h3 class="text-secondary text-center mt-5">There is no category added. Will you do the honor??</h3>
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
