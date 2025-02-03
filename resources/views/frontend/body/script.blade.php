



<script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}">
</script>
<script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
<!-- Template  JS -->
<script src="{{ asset('frontend/assets/js/main.js?v=5.3') }}"></script>
<script src="{{ asset('frontend/assets/js/shop.js?v=5.3') }}"></script>
<script src="{{ asset('frontend/assets/js/script.js') }}"></script>

<!-- start  sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- end sweetalert2 -->
 
<script src="{{ asset('frontend/assets/js/toastr.min.js') }}"></script>
<script>
 @if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
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



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    })

    // start product view with model
    function productView(id) {
        // alert(id); 
        $.ajax({
            type: 'GET',
            url: '/product/view/modal/' + id,
            dataType: 'json',
            success: function(data) {
                $('#pname').text(data.product.product_name);
                $('#psize').text(data.product.product_size);
                $('#pcolor').text(data.product.product_color);
                $('#pvendor_id').text(data.product.vendor_id);

                // Product Price 
                if (data.product.discount_price == null) {
                    $('#pprice').text('');
                    $('#oldprice').text('');
                    $('#pprice').text(data.product.selling_price);
                } else {
                    $('#pprice').text(data.product.discount_price);
                    $('#oldprice').text(data.product.selling_price);
                } // end else

                $('#oldprice').text(data.product.selling_price);
                $('#pbrand').text(data.product.brand.brand_name);
                $('#pcategory').text(data.product.category.category_name);
                $('#pcode').text(data.product.product_code);

                $('#product_id').val(id);
                $('#qty').val(1);

                $('#pimage').attr('src', '/' + data.product.product_thambnail);

                // Handle the response (e.g., update the product badge)
                if (data.product.discount_price === null) {
                    $("#dprice").html('<span class="new">New</span>');
                } else {
                    const discount = Math.round((data.product.selling_price - data.product.discount_price) / data.product.selling_price * 100);
                    $("#dprice").html(`<p class="save-price font-md color3 ml-15">${discount}% off</p>`);
                }

                if (data.product.product_qty > 0) {
                    $('#available').text('');
                    $('#stockout').text('');
                    $('#available').text('Available');
                } else {
                    $('#available').text('');
                    $('#stockout').text('');
                    $('#stockout').text('Stockout');
                }

                //size
                $('select[name="psize"]').empty();
                $.each(data.size, function(key, value) {
                    $('select[name="psize"]').append('<option value="' + value + '">' + value + '</option>');
                    if (data.size == '') {
                        $('#sizeArea').hide();
                    } else {
                        $('#sizeArea').show();
                    }
                })

                //color
                $('select[name="pcolor"]').empty();
                $.each(data.color, function(key, value) {
                    $('select[name="pcolor"]').append('<option value="' + value + '">' + value + '</option>');
                    if (data.color == '') {
                        $('#colorArea').hide();
                    } else {
                        $('#colorArea').show();
                    }
                })

            }
        });
    } // end product view with model

    // start add to cart product
    function addToCart() {
        var product_name = $('#pname').text();
        var id = $('#product_id').val();
        var vendor_id = $('#pvendor_id').text();
        var color = $('#pcolor option:selected').text();
        var size = $('#psize option:selected').text();
        var quantity = $('#qty').val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                color: color,
                size: size,
                quantity: quantity,
                product_name: product_name,
                vendor_id:vendor_id
            },
            url: "/cart/data/store/" + id,
            success: function(data) {
                miniCart();
                $('#closeModal').click();

                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })

                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                        type: 'success',
                        title: data.success,
                    })
                } else {

                    Toast.fire({
                        type: 'error',
                        title: data.error,
                    })
                }
                // End Message 
            }
        })
    }
    // end quick view add to cart product
    // Product Start Details Page Add To Cart 
    function addToCartProductDetails() {
        var product_name = $('#dpname').text();
        var id = $('#dproduct_id').val();
        var vendor = $('#vproduct_id').val();
        var color = $('#dcolor').val();
        var size = $('#dsize option:selected').text();
        var quantity = $('#dqty').val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                color: color,
                size: size,
                quantity: quantity,
                product_name: product_name,
                vendor:vendor,
            },
            url: "/dcart/data/store/" + id,
            success: function(data) {
                miniCart();

                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })

                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                        type: 'success',
                        title: data.success,
                    })
                } else {

                    Toast.fire({
                        type: 'error',
                        title: data.error,
                    })
                }
                // End Message 
            }
        })
    }
    // Product end Details Page Add To Cart  
</script>

<!-- start minicart -->
<script>

    function miniCart() {
        $.ajax({
            type: 'GET',
            url: '/product/mini/cart/',
            dataType: 'json',
            success: function(response) {
                $('#cartQty').text(response.cartQty);
                $('#cartQty1').text(response.cartQty);
                $('span[id="cartTotal"]').text(response.cartTotal);
                var miniCart = "";
                $.each(response.carts, function(key, value) {
                    miniCart += `<ul>
                                        
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html"><img alt="Nest" src="/${ value.options.image }" /></a>
                                            </div>
                                            <div class="shopping-cart-title" style="margin: -73px 74px 14px; width: 146px;">
                                                <h4><a href="shop-product-right.html">${ value.name }</a></h4>
                                                <h4><span>${ value.qty } × </span>৳${ value.price }</h4>
                                            </div>
                                            <div class="shopping-cart-delete" style="margin: -85px 1px 0px;">
                                                <a type="submit" id="${ value.rowId }" onclick="miniCartRemove(this.id)"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        
                                    </ul>`
                });
                $('#miniCart').html(miniCart);
                $('#miniCart1').html(miniCart);
            }
        })
    }
    miniCart();



    /// Mini Cart Remove Start 
    function miniCartRemove(rowId) {
        $.ajax({
            type: 'GET',
            url: '/minicart/product/remove/' + rowId,
            dataType: 'json',
            success: function(data) {
                miniCart();
                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: data.success,
                    })
                } else {

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }
                // End Message  
            }
        })
    }
    // Mini Cart Remove End 
</script>
<!-- end minicart -->

<!-- // Start wishlist -->
<script type="text/javascript">
    function addToWishLists(product_id) {
        wishlist();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/add-to-wishlist/" + product_id,
            success: function(data) {
                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: data.success,
                    })
                } else {

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }
                // End Message 
            }
        });
    }
</script>
<!-- // End wishlist -->

<!-- // Start wishlist data-->
<script type="text/javascript">
    <!-- // Start wishlist data
    -->
    function
    wishlist()
    {
    $.ajax({
    type:
    "GET",
    dataType:
    'json',
    url:
    "/display/wishlist/data/",
    success:
    function(response)
    {
    $('#wishQty').text(response.wishQty);
    $('#wishQty1').text(response.wishQty);
    var
    rows
    =
    "";
    $.each(response.wishlist,
    function(key,
    value)
    {
    rows
    +=
    `
<tr class="pt-30">
    <td class="custome-checkbox pl-30">

    </td>
    <td class="image product-thumbnail pt-40"><img src="/${value.product.product_thambnail}" alt="#" /></td>
    <td class="product-des product-name">
        <h6><a class="product-name mb-10" href="shop-product-right.html">${value.product.product_name} </a></h6>
        <div class="product-rate-cover">
            <div class="product-rate d-inline-block">
                <div class="product-rating" style="width: 90%"></div>
            </div>
            <span class="font-small ml-5 text-muted"> (4.0)</span>
        </div>
    </td>
    <td class="price" data-title="Price">
        ${value.product.discount_price == null
        ? `<h3 class="text-brand">৳${value.product.selling_price}</h3>`
        :`<h3 class="text-brand">৳${value.product.discount_price}</h3>`
        }

    </td>
    <td class="text-center detail-info" data-title="Stock">
        ${value.product.product_qty > 0
        ? `<span class="stock-status in-stock mb-0"> In Stock </span>`
        :`<span class="stock-status out-stock mb-0">Stock Out </span>`
        }

    </td>

    <td class="action text-center" data-title="Remove">
        <a type="submit" class="text-body" id="${value.id}" onclick="wishlistRemove(this.id)"><i class="fi-rs-trash"></i></a>
    </td>
</tr> `
});
$('#wishlist').html(rows);
}
});
}
wishlist();
// end wishlist data

// Wishlist Remove Start
function wishlistRemove(id) {
$.ajax({
type: "GET",
dataType: 'json',
url: "/wishlist/remove/" + id,
success: function(data) {
wishlist();
// Start Message
const Toast = Swal.mixin({
toast: true,
position: 'top-end',

showConfirmButton: false,
timer: 3000
})
if ($.isEmptyObject(data.error)) {

Toast.fire({
type: 'success',
icon: 'success',
title: data.success,
})
} else {

Toast.fire({
type: 'error',
icon: 'error',
title: data.error,
})
}
// End Message
}
})
}
// Wishlist Remove End
</script>
<!-- // End wishlist data-->


<!-- start mycart -->
<script>
    function myCart() {
        $.ajax({
            type: 'GET',
            url: '/get-mycart-product/',
            dataType: 'json',
            success: function(response) {
                $('#cartQty').text(response.cartQty);
                $('#cartQty1').text(response.cartQty);
                $('span[id="cartTotal"]').text(response.cartTotal);
                var rows = "";
                $.each(response.carts, function(key, value) {
                    rows += `<tr class="pt-30">
                            <td class="custome-checkbox pl-30">

                            </td>
                            <td class="image product-thumbnail pt-40"><img src="/${value.options.image}" alt="#"></td>
                            <td class="product-des product-name">
                                <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">${value.name}</a></h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width:90%">
                                        </div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                            </td>
                            <td class="price" data-title="Price">
                                <h4 class="text-body">৳${value.price} </h4>
                            </td>

                            <td class="price" data-title="Price">
                               ${value.options.color == null
                               ? `<span>.... </span>`
                               : `<h6 class="text-body">${value.options.color} </h6>`
                               }
                            </td>

                            <td class="price" data-title="Price">
                                ${value.options.size == null
                                ? `<span>.... </span>`
                                : `<h6 class="text-body">${value.options.size} </h6>`
                                }
                            </td>
                            <td class="text-center detail-info" data-title="Stock">
                                <div class="detail-extralink mr-15">
                                    <div class="detail-qty border radius">

                                        <a type="submit" class="qty-down"><i class="fi-rs-angle-small-down" id="${value.rowId}" onclick="cartDecrement(this.id)"></i></a>

                                        <input type="text" name="quantity" class="qty-val" value="${value.qty}" min="1">

                                        <a  type="submit" class="qty-up" id="${value.rowId}" onclick="cartIncrement(this.id)"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td class="price" data-title="Price">
                                <h4 class="text-brand">৳${value.subtotal} </h4>
                            </td>
                            <td class="action text-center" data-title="Remove"><a type="submit" class="text-body"  id="${value.rowId}" onclick="mycartRemove(this.id)"><i class="fi-rs-trash"></i></a></td>
                        </tr>`
                });
                $('#myCart').html(rows);
            }
        })
    }
    myCart();


    /// My Cart Remove Start 
    function mycartRemove(rowId) {
        $.ajax({
            type: 'GET',
            url: '/mycart-remove/' + rowId,
            dataType: 'json',
            success: function(data) {
                couponCalculation();
                miniCart();
                myCart();
                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: data.success,
                    })
                } else {

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }
                // End Message  
            }
        })
    }
    // My Cart Remove End 

    // start cartDecrement
    function cartDecrement(rowId) {
        $.ajax({
            type: 'GET',
            url: '/cartqty-decrement/' + rowId,
            dataType: 'json',
            success: function(data) {
                couponCalculation();
                miniCart();
                myCart();
            }
        })
    }
    // end cartDecrement

    // Cart INCREMENT 
    function cartIncrement(rowId) {
        $.ajax({
            type: 'GET',
            url: "/cartqty-increment/" + rowId,
            dataType: 'json',
            success: function(data) {
                couponCalculation();
                myCart();
                miniCart();
            }
        });
    }
    // Cart INCREMENT End
</script>
<!-- end myCart -->


<!-- start applyCoupon -->
<script>
    // <!-- start applyCoupon -->
    function applyCoupon() {
        var coupon_name = $('#coupon_name').val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                coupon_name: coupon_name,
            },
            url: '/apply-coupon',

            success: function(data) {
                couponCalculation();

                if (data.validity == true) {
                    $('#couponField').hide();
                }
                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: data.success,
                    })
                } else {

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }
                // End Message  
            }
        })
    }
    // <!-- end applyCoupon -->

    // start couponCalculation method
    function couponCalculation() {
        $.ajax({
            type: 'GET',
            url: "/coupon-calculation",
            dataType: 'json',
            success: function(data) {
                if (data.total) {
                    $('#couponCal').html(
                        `<tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">Subtotal</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h4 class="text-brand text-end">৳${data.total}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="cart_total_label">
                            <h6 class="text-muted">Grand Total</h6>
                        </td>
                        <td class="cart_total_amount">
                            <h4 class="text-brand text-end">৳${data.total}</h4>
                        </td>
                        </tr>`
                    );
                } else {
                    $('#couponCal').html(
                        `<tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">Subtotal</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h4 class="text-brand text-end">৳${data.subtotal}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="cart_total_label">
                            <h6 class="text-muted">Coupon </h6>
                        </td>
                        <td class="cart_total_amount">
                            <h4 class="text-brand text-end  text-uppercase">${data.coupon_name} <a type="submit" onclick="couponRemove()"><i class="fi-rs-trash"></i> </a></h4>
                        </td>
                        </tr>
                        <tr>
                            <td class="cart_total_label">
                            <h6 class="text-muted">Discount Amount</h6>
                        </td>
                        <td class="cart_total_amount">
                            <h4 class="text-brand text-end">৳${data.discount_amount}</h4>
                        </td>
                        </tr>
                        <tr>
                            <td class="cart_total_label">
                            <h6 class="text-muted">Grand Total</h6>
                        </td>
                        <td class="cart_total_amount">
                            <h4 class="text-brand text-end">৳${data.total_amount}</h4>
                        </td>
                        </tr>`
                    );
                }
            }
        });
    }
    couponCalculation();
    myCart();
    miniCart();
    // end couponCalculation method

    /// My coupon Remove Start 
    function couponRemove() {
        $.ajax({
            type: 'GET',
            url: '/coupon-remove/',
            dataType: 'json',
            success: function(data) {
                couponCalculation();
                $('#couponField').show();

                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                })
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: data.success,
                    })
                } else {

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }
                // End Message  
            }
        })
    }
    // My coupon Remove End
</script>
<!-- end applyCoupon -->