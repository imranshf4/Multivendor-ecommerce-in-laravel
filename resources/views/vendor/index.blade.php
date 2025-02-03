@extends('vendor.vendor_dashboard')
@section('vendor')

@php
$id = Auth::user()->id;
$vendorId = App\Models\User::find($id);
$statu = $vendorId->status;

$data = date('d F Y');
$today = App\Models\OrderItem::where('vendor_id', $id)
    ->selectRaw('SUM(price * qty) as total')
    ->value('total');;

@endphp



<div class="page-content">
    @if($statu === 'active')
    <h4>Vendor Account is <span class="text-success">Active</span></h4>
    @else
    <h4>Vendor Account is <span class="text-danger">InActive</span></h4>
    <p class="text-danger"><b>Please wait admin will check and approved your account! </b></p>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 bg-gradient-deepblue">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 text-white">৳{{ $today }}</h5>
                        <div class="ms-auto">
                            <i class='bx bx-cart fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">Total Sales</p>
                        <p class="mb-0 ms-auto">+4.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--end row-->

    @php

    $orders = App\Models\OrderItem::with('order')->where('vendor_id', $id)->orderBy('id', 'DESC')->limit(10)->get();

    @endphp
    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="mb-0">Orders Summary</h5>
                </div>
                <div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Invoice</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item['order']['order_date'] }}</td>
                            <td>{{ $item['order']['invoice_no'] }}</td>
                            <td>৳{{ $item['order']['amount'] }}</td>
                            <td>{{ $item['order']['payment_method'] }}</td>
                            <td>
                                <div class="badge rounded-pill bg-light-info text-info w-100">{{ $item['order']['status'] }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection