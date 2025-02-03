@extends('dashboard')
@section('user')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> User Account
        </div>
    </div>
</div>
<div class="page-content pt-50 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-auto">
                <div class="row">

                    <!-- // Start Col md 3 menu -->
                    @include('frontend.body.user_dashboard_sidebar_menu')
                    <!-- // End Col md 3 menu -->




                    <div class="col-md-9">
                        <div class="tab-content account dashboard-content pl-50">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Coupon Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Sl</th>
                                                        <th>Coupon Name </th>
                                                        <th>Coupon Discount </th>
                                                        <th>Coupon Validity </th>
                                                        <th>Coupon Status </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($coupon as $key => $item)
                                                    <tr>
                                                        <td> {{ $key+1 }} </td>
                                                        <td class="text-uppercase"> {{ $item->coupon_name }}</td>
                                                        <td> {{ $item->coupon_discount }}% </td>
                                                        <td> {{ Carbon\Carbon::parse($item->coupon_validity)->format('D, d F Y') }} </td>


                                                        <td>
                                                            @if($item->coupon_validity >= Carbon\Carbon::now()->format('Y-m-d'))
                                                            <span class="badge rounded-pill bg-success">Valid</span>
                                                            @else
                                                            <span class="badge rounded-pill bg-danger">Invalid</span>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                    @endforeach


                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Sl</th>
                                                        <th>Coupon Name </th>
                                                        <th>Coupon Discount </th>
                                                        <th>Coupon Validity </th>
                                                        <th>Coupon Status </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>



@endsection