@extends('admin.layouts.master');



@section('title')
    Order List
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
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    <div class="w-fit-content py-2 px-1 mb-3 shadow">
                        <h3>Filter By Status</h3>
                        <div class="d-flex justify-content-center align-content-center my-3 gap-1">
                            <button class="btnStatus btn btn-warning" data-status-id="0">Pending</button>
                            <button class="btnStatus btn btn-success" data-status-id="1">Success</button>
                            <button class="btnStatus btn btn-danger" data-status-id="2">Reject</button>
                            <button class="btnStatus btn btn-dark" data-status-id="">Clear Filteration</button>
                        </div>
                    </div>

                    <div class="mb-3 shadow-sm py-2 px-1">
                        <h3>Total Orders resulted : <span id="totalOrder" class="text-success">{{ count($orders) }}</span></h3>
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
                        @if (count($orders) != 0)
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>Customer's Name</th>
                                        <th>Order Code</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="spacer"></tr>

                                    @foreach ($orders as $item)
                                        <tr class="tr-shadow">
                                            <td class="col-2">{{ $item->user_id }}</td>
                                            <td>{{ $item->user_name }}</td>
                                            <td>
                                                <a href="{{route('admin#order#goToDetailsPage', $item->order_code)}}">
                                                    {{ $item->order_code }}
                                                </a>
                                            </td>
                                            <td>{{ $item->total_price }}</td>
                                            <td>
                                                <form action="" id="statusForm">
                                                    <input type="hidden" name="" value="{{ $item->id }}" class="changeStatusId">
                                                    <select name="" id=""
                                                        class="@if ($item->status == 0) text-warning @elseif($item->status == 1) text-success @elseif($item->status == 2) text-danger @endif fw-bold form-control changeStatusForm">
                                                        <option value="0" class="text-warning fw-bold"
                                                            @if ($item->status == 0) selected @endif>Pending
                                                        </option>
                                                        <option value="1" class="text-success fw-bold"
                                                            @if ($item->status == 1) selected @endif>Success
                                                        </option>
                                                        <option value="2" class="text-danger fw-bold"
                                                            @if ($item->status == 2) selected @endif>Reject
                                                        </option>
                                                    </select>
                                                </form>
                                            </td>

                                            <td>
                                                {{ $item->created_at->format('j-F-Y') }}
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="">
                                There are no products related to the search key.<br>Wil you do the honor?? Please add more
                                products..
                            </div>
                        @endif
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

@section('script_source')
    <script>
        $(document).ready(function() {

            the_whole_page();


            function the_whole_page() {

                const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                    'September',
                    'October', 'November', 'December'
                ];

                handling_status_filter_buttons();

                changing_status_in_the_database();

                //TODO handling status filter buttons
                function handling_status_filter_buttons() {

                    d('.btnStatus').forEach((item) => {
                        item.addEventListener('click', () => {
                            filterWithStatus(item.dataset.statusId);

                        })
                    });


                    function filterWithStatus(id) {

                        $.ajax({
                            type: 'get',
                            url: '/admin/order/filterByStatus',
                            data: {
                                statusId: id
                            },
                            dataType: 'json',
                            success: function(response) {

                                let html = '';

                                response.forEach((item) => {

                                    const createdAt = new Date(item.created_at);

                                    let statusMessage;
                                    if (item.status == 0) {
                                        statusMessage = `<select name="" id=""
                                                        class="fw-bold form-control changeStatusForm">
                                                        <option value="0" class="text-warning fw-bold" selected>Pending
                                                        </option>
                                                        <option value="1" class="text-success fw-bold">Success
                                                        </option>
                                                        <option value="2" class="text-danger fw-bold">Reject
                                                        </option>
                                                    </select>`;
                                    } else if (item.status == 1) {
                                        statusMessage = `<select name="" id=""
                                                        class="fw-bold form-control changeStatusForm">
                                                        <option value="0" class="text-warning fw-bold">Pending
                                                        </option>
                                                        <option value="1" class="text-success fw-bold" selected>Success
                                                        </option>
                                                        <option value="2" class="text-danger fw-bold">Reject
                                                        </option>
                                                    </select>`;
                                    } else if (item.status == 2) {
                                        statusMessage = `<select name="" id=""
                                                        class="fw-bold form-control changeStatusForm">
                                                        <option value="0" class="text-warning fw-bold">Pending
                                                        </option>
                                                        <option value="1" class="text-success fw-bold">Success
                                                        </option>
                                                        <option value="2" class="text-danger fw-bold" selected>Reject
                                                        </option>
                                                    </select>`;
                                    }



                                    html += `
                                        <tr class="tr-shadow">
                                            <td class="col-2">${ item.user_id }</td>
                                            <td>${ item.user_name }</td>
                                            <td>
                                                <a href="/admin/order/detailsPage/${item.order_code}">
                                                    ${ item.order_code }
                                                </a>
                                            </td>
                                            <td>${ item.total_price }</td>
                                            <td>
                                                <form action="" id="statusForm">
                                                    <input type="hidden" name="" value="${item.id}" class="changeStatusId">
                                                    ${statusMessage}
                                                </form>
                                            </td>

                                            <td>
                                                ${createdAt.getDate()}-${months[createdAt.getMonth()]}-${createdAt.getFullYear()}
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    `;
                                });
                                d('.table tbody')[0].innerHTML = `<tr class="spacer"></tr>`;
                                d('.table tbody')[0].innerHTML += html;
                                d('#totalOrder')[0].innerHTML = response.length;
                                changing_status_in_the_database();
                            }
                        });
                    }
                } /* handling_status_filter_buttons */
                //----------------------------------


                //TODO changing status in the data base
                function changing_status_in_the_database() {
                    d('.changeStatusForm').forEach((item, i) => {
                        item.addEventListener('change', () => {
                            console.log(item.value);


                            $.ajax({
                                type: 'get',
                                url: '/admin/order/changeStatusInTheDataBase',
                                data: {
                                    orderId : d('.changeStatusId')[i].value,
                                    statusId : item.value
                                },
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response);
                                    window.location.href = '/admin/order/listPage';
                                }

                            })
                        })
                    })
                } /* changing_status_in_the_database */
                //---------------------------------
            } /* the whole page */


            //---------------------------------------
            function d(element) {
                return document.querySelectorAll(element);
            }
        })
    </script>
@endsection

{{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum molestias inventore neque facere, a, ipsam vitae dicta libero provident laboriosam, reiciendis commodi quam aperiam nulla? Repudiandae quidem autem deserunt saepe. --}}
