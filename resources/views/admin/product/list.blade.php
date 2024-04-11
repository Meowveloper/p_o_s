@extends('admin.layouts.master');

@php
    use App\Models\Category;
@endphp

@section('title')
    Pizza List
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
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('product#goToCreatePage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add products(Pizza)
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
                            action="{{ route('product#goToListPage') }}" method="GET" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="key" class="form-control h-100" placeholder="Search.."
                                value="{{ request('key') }}">
                            <button type="submit" class="btn btn-dark">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="mb-3 shadow-sm py-2 px-1">
                        <h3>Total Products resulted : <span class="text-success">{{ $products->total() }}</span></h3>
                    </div>




                    <div class="table-responsive table-responsive-data2">

                        @if (session('categoryCreated'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('categoryCreated') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @elseif (session('productDeleteSuccess'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session('productDeleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (count($products) != 0)
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>View counts</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="spacer"></tr>

                                    @foreach ($products as $item)
                                        <tr class="tr-shadow">
                                            <td class="col-2"><img src="{{ asset('storage/' . $item->image) }}"
                                                    class="img-thumbnail shadow-sm" alt=""></td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->category_name }}</td>
                                            <td>{{ $item->view_count }}<i class="ms-1 bi bi-eye-fill"></i></td>

                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="{{ route('product#goToDetailsPage', $item->id) }}" class="me-2">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="View">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
                                                    </a>

                                                    <a href="{{ route('product#goToEditPage', $item->id) }}" class="me-2">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>

                                                    <a href="{{ route('product#deleteProduct', $item->id) }}">
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
                        @else
                            <div class="">
                                There are no products related to the search key.<br>Wil you do the honor?? Please add more products..
                            </div>
                        @endif


                        <div class="mt-3">
                            {{ $products->links() }}
                        </div>
                    </div>


                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
    </div>
@endsection

{{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum molestias inventore neque facere, a, ipsam vitae dicta libero provident laboriosam, reiciendis commodi quam aperiam nulla? Repudiandae quidem autem deserunt saepe. --}}
