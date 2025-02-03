@extends('frontend.master_dashboard')
@section('main')

@section("title")
Checkout Page
@endsection

<script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Checkout
        </div>
    </div>
</div>
<form method="post" action="{{ route('checkout.store') }}">
    @csrf
    <div class="container mb-80 mt-50">
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h3 class="heading-2 mb-10">Checkout</h3>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">There are products in your cart</h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">

                <div class="row">
                    <h4 class="mb-30">Billing Details</h4>



                    <div class="row">
                        <div class="form-group col-lg-6">
                            <input type="text" required="" name="shipping_name" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="email" required="" name="shipping_email" value="{{ Auth::user()->email }}">
                        </div>
                    </div>



                    <div class="row shipping_calculator">
                        <div class="form-group col-lg-6">
                            <div class="custom_select">
                                <select class="form-control select-active" name="division_id">
                                    <option value="">Select Division...</option>
                                    @foreach($divisions as $item)
                                    <option value="{{ $item->id }}">{{ $item->division_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <input required="" type="text" name="shipping_phone" value="{{ Auth::user()->phone }}" placeholder="Phone*">
                        </div>
                    </div>

                    <div class="row shipping_calculator">
                        <div class="form-group col-lg-6">
                            <div class="custom_select">
                                <select name="district_id" class="form-control select-active">

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <input required="" type="text" name="post_code" placeholder="Post Code *">
                        </div>
                    </div>


                    <div class="row shipping_calculator">
                        <div class="form-group col-lg-6">
                            <div class="custom_select">
                                <select name="state_id" class="form-control select-active">

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <input required="" type="text" name="shipping_address" placeholder="Address *" value="{{ Auth::user()->address }}" placeholder="Address *">
                        </div>
                    </div>





                    <div class="form-group mb-30">
                        <textarea rows="5" placeholder="Additional information" name="notes"></textarea>
                    </div>




                </div>
            </div>


            <div class="col-lg-5">


                <div class="border p-40 cart-totals ml-30 mb-50">
                    <div class="d-flex align-items-end justify-content-between mb-30">
                        <h4>Your Order</h4>
                        <h6 class="">Subtotal</h6>
                    </div>
                    <div class="divider-2 mb-30"></div>
                    <div class="table-responsive order_table checkout">
                        <table class="table no-border">
                            <tbody>
                                @foreach($carts as $item)
                                <tr>
                                    <td class="image product-thumbnail"><img src="{{ asset($item->options->image) }}" alt="#" style="width:50px; height: 50px;"></td>
                                    <td>
                                        <h6 class="w-160 mb-5"><a class="text-heading">{{ $item->name }}</a></h6></span>
                                        <div class="product-rate-cover">

                                            <strong>Color : {{ $item->options->color }}</strong>,
                                            <strong>Size : {{ $item->options->size  }}</strong>

                                        </div>
                                    </td>
                                    <td>
                                        <h6 class=" pl-20 pr-20">x {{ $item->qty  }}</h6>
                                    </td>
                                    <td>
                                        <h4 class="text-brand">৳{{ $item->price }}</h4>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>




                        <table class="table no-border">
                            <tbody>
                                @if(Session::has('coupon'))
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">৳{{ $cartTotal }}</h4>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="">Coupn Name</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h6 class="text-brand text-end text-uppercase">{{ session()->get('coupon')['coupon_name'] }} ( {{ session()->get('coupon')['coupon_discount'] }}% )</h6>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="">Coupon Discount</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">৳{{ session()->get('coupon')['discount_amount'] }}</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <h6 class="mb-15">Shipping</h6>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <div class="custome-radio">
                                            <input class="form-check-input" required="" type="radio" name="shipping" value="dhaka" id="exampleRadios9" checked="">
                                            <label class="form-check-label text-bold" for="exampleRadios9" data-bs-toggle="collapse" data-target="#dhaka" aria-controls="dhaka">Inside Dhaka City: 60৳</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <div class="custome-radio">
                                            <input class="form-check-input" required="" type="radio" name="shipping" value="outside" id="exampleRadios10">
                                            <label class="form-check-label" for="exampleRadios10" data-bs-toggle="collapse" data-target="#outside" aria-controls="outside">Outside Dhaka City: 110৳</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <div>
                                            <span  style="display: none;">Shipping Cost: </span>
                                            <span id="shipping-costs" style="display: none;">60</span>
                                            <input type="hidden" name="shipping_cost" id="shipping-cost-input" value="60">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="">Grand Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">
                                            <span id="grand_total_amount"></span>
                                        </h4>
                                    </td>
                                </tr>


                                @else
                                <tr>
                                    <h6 class="mb-15">Shipping</h6>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <div class="custome-radio">
                                            <input class="form-check-input" required="" type="radio" name="shipping" value="dhaka" id="exampleRadios9" checked="">
                                            <label class="form-check-label text-bold" for="exampleRadios9" data-bs-toggle="collapse"
                                                data-target="#dhaka" aria-controls="dhaka">Inside Dhaka City: 60৳</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <div class="custome-radio">
                                            <input class="form-check-input" required="" type="radio" name="shipping" value="outside" id="exampleRadios10">
                                            <label class="form-check-label" for="exampleRadios10" data-bs-toggle="collapse" data-target="#outside"
                                                aria-controls="outside">Outside Dhaka City: 110৳</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <div>
                                            <span  style="display: none;">Shipping Cost: </span>
                                            <span id="shipping-cost" style="display: none;">60</span>
                                            <input type="hidden" name="shipping_cost" id="shipping-cost-input" value="60">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="">Grand Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end" id="grand-total">৳{{ $cartTotal + 60 }}</h4>
                                    </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>





                    </div>
                </div>

                <div class="payment ml-30">
                    <h4 class="mb-30">Payment</h4>

                    <div class="payment_option">

                        <div class="custome-radio">
                            <input class="form-check-input" required="" type="radio" name="payment_option" value="bkash" id="bkashRadio" checked="">
                            <label class="form-check-label" for="bkashRadio" data-bs-toggle="collapse" data-target="#bkash" aria-controls="bkash">Bkash</label>
                        </div>
                        @php
                        $setting = App\Models\SiteSetting::find(1);
                        @endphp
                        <!-- Bkash Transaction Section -->
                        <div id="bkash" class="transaction-section" style="display: none;margin-bottom: 15px;">
                            <h6 class="mb-5">Bkash Personal: {{ $setting->bkash_number }} </h6>
                            <input type="text" placeholder="Transaction ID*" name="transaction_id">
                        </div>

                        <div class="custome-radio">
                            <input class="form-check-input" required="" type="radio" name="payment_option" value="rocket" id="rocketRadio">
                            <label class="form-check-label" for="rocketRadio" data-bs-toggle="collapse" data-target="#rocket" aria-controls="rocket">Rocket</label>
                        </div>

                        <!-- Rocket Transaction Section -->
                        <div id="rocket" class="transaction-section" style="display: none;margin-bottom: 15px;">
                            <h6 class="mb-5">Rocket Personal: {{ $setting->rocket_number }}</h6>
                            <input type="text" placeholder="Transaction ID*" name="transaction_id">
                        </div>

                        <div class="custome-radio">
                            <input class="form-check-input" required="" type="radio" name="payment_option" value="cash" id="exampleRadios4" checked="">
                            <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse" data-target="#checkPayment" aria-controls="checkPayment">Cash on delivery</label>
                        </div>

                    </div>
                    <div class="payment-logo d-flex">
                        <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-paypal.svg') }}" alt="">
                        <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-visa.svg') }}" alt="">
                        <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-master.svg') }}" alt="">
                        <img src="{{ asset('frontend/assets/imgs/theme/icons/payment-zapper.svg') }}" alt="">
                    </div>
                    <button type="submit" class="btn btn-fill-out btn-block mt-30">Place an Order<i class="fi-rs-sign-out ml-15"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="{{ asset('frontend/assets/js/toastr.min.js') }}"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"
    switch (type) {
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    @endif
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="division_id"]').on('change', function() {
            var division_id = $(this).val();
            if (division_id) {
                $.ajax({
                    url: "{{ url('/district-get/ajax') }}/" + division_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="state_id"]').html('');
                        var d = $('select[name="district_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="district_id"]').append('<option value="' + value.id + '">' + value.district_name + '</option>');
                        });
                    },
                });
            } else {
                alert('danger');
            }
        });
    });
    // Show State Data 
    $(document).ready(function() {
        $('select[name="district_id"]').on('change', function() {
            var district_id = $(this).val();
            if (district_id) {
                $.ajax({
                    url: "{{ url('/state-get/ajax') }}/" + district_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="state_id"]').html('');
                        var d = $('select[name="state_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="state_id"]').append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });
                    },
                });
            } else {
                alert('danger');
            }
        });
    });
</script>

<script>
    const cartTotal = parseFloat('{{ $cartTotal }}'); // Ensure this is a number

    const shippingCosts = {
        dhaka: 60,
        outside: 110
    };

    const updateGrandTotal = (shippingCost) => {
        const grandTotal = cartTotal + shippingCost;
        document.getElementById('grand-total').innerText = `৳${grandTotal}`;
    };

    // Initialize the grand total on page load
    updateGrandTotal(shippingCosts.dhaka);

    document.querySelectorAll('input[name="shipping"]').forEach(function(elem) {
        elem.addEventListener('change', function() {
            const shippingCost = shippingCosts[this.value];
            document.getElementById('shipping-cost').innerText = shippingCost;
            updateGrandTotal(shippingCost);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bkashRadio = document.getElementById('bkashRadio');
        const rocketRadio = document.getElementById('rocketRadio');
        const bkashSection = document.getElementById('bkash');
        const rocketSection = document.getElementById('rocket');

        // Function to toggle sections based on selected payment option
        function togglePaymentSections() {
            if (bkashRadio.checked) {
                bkashSection.style.display = 'block'; 
                rocketSection.style.display = 'none'; 
            } else if (rocketRadio.checked) {
                bkashSection.style.display = 'none'; 
                rocketSection.style.display = 'block';
            }
        }

        // Add event listeners
        bkashRadio.addEventListener('change', togglePaymentSections);
        rocketRadio.addEventListener('change', togglePaymentSections);

        togglePaymentSections();
    });


    document.querySelectorAll('input[name="shipping"]').forEach((radio) => {
        radio.addEventListener('change', function() {
            var shippingCost = 60; // Default shipping cost (inside Dhaka)

            if (document.getElementById('exampleRadios10').checked) {
                shippingCost = 110; // Outside Dhaka
            }

            // Update the shipping cost in the hidden input field
            document.getElementById('shipping-cost-input').value = shippingCost;
        });
    });
</script>

<!-- sesstion for coupon -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the initial cart total and coupon total values (ensure these are numbers)
        const cartTotal = parseFloat('{{ $cartTotal }}'); // Ensure this is a number
        const couponTotal = parseFloat('{{ session()->has('coupon') ? session()->get('coupon')['total_amount'] : 0 }}'); // Coupon total
        let shippingCost = 60; // Default shipping cost (Inside Dhaka)

        console.log('Cart Total:', cartTotal); // Debugging
        console.log('Coupon Total:', couponTotal); // Debugging

        // Shipping cost options
        const shippingCostOptions = {
            dhaka: 60,
            outside: 110,
        };

        // Function to update the grand total
        function updateGrandTotals() {
            const grandTotal = couponTotal;
            console.log('Updated Grand Total:', grandTotal);

            // Update the displayed grand total
            document.getElementById('grand_total_amount').innerText = `৳${grandTotal}`;
            document.getElementById('shipping-cost').innerText = `৳${shippingCost}`;
            document.getElementById('shipping-cost-input').value = shippingCost; 
        }

        // Initialize the grand total on page load
        updateGrandTotals();

        // // Event listener for when the user selects a different shipping option
        // document.querySelectorAll('input[name="shipping"]').forEach(function(elem) {
        //     elem.addEventListener('change', function() {
        //         // Get the selected shipping option's cost
        //         shippingCost = shippingCostOptions[this.value] || 60;

        //         console.log('Selected Shipping:', this.value);
        //         console.log('Updated Shipping Cost:', shippingCost);

        //         // Update the displayed shipping cost and recalculate the grand total
        //         document.getElementById('shipping-cost').innerText = `৳${shippingCost}`;
        //         document.getElementById('shipping-cost-input').value = shippingCost;

        //         // Recalculate and update the grand total
        //         updateGrandTotals();
        //     });
        // });
    });
</script>

@endsection