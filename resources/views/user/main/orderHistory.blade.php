@extends('user.layouts.master')

@section('title')
    {{ Auth::user()->name }}'s Order History
@endsection

@section('content')
    <div class="container-fluid" style="min-height: 500px">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Purchased Date</th>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($history as $item)
                            {{-- ---------------- --}}
                            <tr class="cart_row">
                                <td class="align-middle">
                                    {{ $item->created_at->format('j-F-Y') }}
                                </td>
                                <td class="align-middle">
                                    {{ $item->order_code }}
                                </td>
                                <td class="align-middle">
                                    {{ $item->total_price }} Kyats
                                </td>
                                <td class="align-middle">

                                        @if ($item->status == 0)
                                            <span class="text-warning fw-bold"><i class="fw-bold bi bi-clock-history me-1"></i>Pending...</span>
                                        @elseif ($item->status == 1)
                                            <span class="text-success fw-bold"><i class="fw-bold bi bi-check-all me-1"></i>Success...</span>
                                        @elseif ($item->status == 2)
                                            <span class="text-danger fw-bold"><i class="fw-bold bi bi-exclamation-triangle-fill me-1"></i>Canceled or Rejected</span>
                                        @endif

                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="mt-3">{{ $history->links() }}</div>
            </div>

        </div>
    </div>
@endsection


@section('scriptSource')
@endsection
