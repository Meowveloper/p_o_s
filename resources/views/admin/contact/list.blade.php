@extends('admin.layouts.master')

@section('title')
    Contact Messages
@endsection

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Contact Message List</h2>

                        </div>
                    </div>
                </div>



                <div class="mb-3 shadow-sm py-2 px-1">
                    <h3>Total Messages resulted : <span id="totalOrder" class="text-success">{{ count($contacts) }}</span></h3>
                </div>




                <div class="table-responsive table-responsive-data2">


                    @if (count($contacts) != 0)
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Customer's Name</th>
                                    <th>Customer's Email</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="spacer"></tr>

                                @foreach ($contacts as $item)
                                    <tr class="tr-shadow">
                                        <td class="col-2">
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->email }}
                                        </td>
                                        <td>
                                            {{ $item->message }}
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
                            There are no messages yet!!
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

@endsection
