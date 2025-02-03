@extends('vendor.vendor_dashboard')
@section('vendor')
<script src="{{ asset('adminbackend/assets/js/jquery.min.js') }}"></script>
<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Vendor Edit Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Vendor Edit Product</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body p-4">
            <h5 class="card-title">Vendor Edit Product</h5>
            <hr />
            <div class="form-body mt-4">
                <form id="myForm" method="post" action="{{ route('vendor.update.product') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="border border-3 p-4 rounded">


                                <input type="hidden" name="id" value="{{ $products->id }}">
                                <div class="mb-3 form-group">
                                    <label for="inputProductTitle" class="form-label">Product Name</label>
                                    <input type="text" name="product_name" class="form-control" id="inputProductTitle" value="{{ $products->product_name }}">
                                </div>

                                <div class="mb-3">
                                    <label for="inputProductTitle" class="form-label">Product Tags</label>
                                    <input type="text" name="product_tags" class="form-control visually-hidden" data-role="tagsinput" value="{{ $products->product_tags }}">
                                </div>

                                <div class="mb-3">
                                    <label for="inputProductTitle" class="form-label">Product Size</label>
                                    <input type="text" name="product_size" class="form-control visually-hidden" data-role="tagsinput" value="{{ $products->product_size }}">
                                </div>

                                <div class="mb-3">
                                    <label for="inputProductTitle" class="form-label">Product Color</label>
                                    <input type="text" name="product_color" class="form-control visually-hidden" data-role="tagsinput" value="{{ $products->product_color }}">
                                </div>



                                <div class="mb-3 form-group">
                                    <label for="inputProductDescription" class="form-label">Short Description</label>
                                    <textarea name="short_descp" class="form-control" id="inputProductDescription" rows="3">{{ $products->short_descp }}</textarea>
                                </div>

                                <div class="mb-3 form-group">
                                    <label for="inputProductDescription" class="form-label">Long Description</label>
                                    <textarea id="mytextarea" name="long_descp">{!! $products->long_descp !!}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="border border-3 p-4 rounded">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label for="inputPrice" class="form-label">Product Price</label>
                                        <input type="text" name="selling_price" class="form-control" id="inputPrice" value="{{ $products->selling_price }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCompareatprice" class="form-label">Discount Price</label>
                                        <input type="text" name="discount_price" class="form-control" id="inputCompareatprice" value="{{ $products->discount_price }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="inputCostPerPrice" class="form-label">Product Code</label>
                                        <input type="text" name="product_code" class="form-control" id="inputCostPerPrice" value="{{ $products->product_code }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="inputStarPoints" class="form-label">Product Qty</label>
                                        <input type="text" name="product_qty" class="form-control" id="inputStarPoints" value="{{ $products->product_qty }}">
                                    </div>

                                    <div class="col-12 form-group">
                                        <label for="inputProductType" class="form-label">Product Brand</label>
                                        <select class="form-select" name="brand_id" id="inputProductType">
                                            <option value=""></option>
                                            @foreach($brands as $brand)
                                            <option value="{{ $brand->id  }}" {{ $brand->id == $products->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 form-group">
                                        <label for="inputVendor" class="form-label">Product Category</label>
                                        <select class="form-select" name="category_id" id="inputVendor">
                                            <option value=""></option>
                                            @foreach($categories as $cat)
                                            <option value="{{ $cat->id  }}" {{ $cat->id == $products->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 form-group">
                                        <label for="inputCollection" class="form-label">Product SubCategory</label>
                                        <select class="form-select" name="subcategory_id" id="inputCollection">
                                            @foreach($subcategory as $subcat)
                                            <option value="{{ $subcat->id  }}" {{ $subcat->id == $products->subcategory_id ? 'selected' : '' }}>{{ $subcat->subcategory_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>



                                    <div class="col-md-6">
                                        <input class="form-check-input" name="hot_deals" type="checkbox" value="1" id="flexCheckDefault" {{ $products->hot_deals === 1 ? 'checked' : ''}}>
                                        <label for="inputCompareatprice" class="form-label">Hot Deals</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" name="featured" type="checkbox" value="1" id="flexCheckDefault" {{ $products->featured === 1 ? 'checked' : ''}}>
                                        <label for="inputCostPerPrice" class="form-label">Features</label>
                                    </div>

                                    <div class="col-md-6">
                                        <input class="form-check-input" name="special_offer" type="checkbox" value="1" id="flexCheckDefault" {{ $products->special_offer === 1 ? 'checked' : ''}}>
                                        <label for="inputCompareatprice" class="form-label">Special Offers</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" name="special_deals" type="checkbox" value="1" id="flexCheckDefault" {{ $products->special_deals === 1 ? 'checked' : ''}}>
                                        <label for="inputCostPerPrice" class="form-label">Special Deals</label>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <input type="submit" class="btn btn-primary px-4" value="Save Product" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </form>
            </div>
        </div>
    </div>

</div>

<div class="page-content">
    <div class="card">
        <div class="card-body p-4">
            <h5 class="card-title">Update Main Image Thumbnail</h5>
            <hr />
            <div class="form-body mt-4">
                <form id="myForm" method="post" action="{{ route('vendor.update.mainThumb.product') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $products->id }}">
                    <input type="hidden" name="old_img" value="{{ $products->product_thambnail }}">
                    <div class="row">
                        <div class="mb-3 form-group">
                            <label for="inputProductTitle" class="form-label">Choose The Main Thambnail</label>
                            <input name="product_thambnail" class="form-control" type="file" onChange="mainThamUrl(this)">
                        </div>
                        <div class="mb-3">
                            <img id="mainThmb" src="{{ asset($products->product_thambnail) }}" alt="Admin" width="80px" height="80px">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-grid">
                            <input type="submit" class="btn btn-primary px-4" value="Update Image" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="page-content">

    <div class="card">
        <div class="card-body">
            <table class="table mb-0 table-striped">
                <h6 class="mb-0 text-uppercase">Update Multi Image </h6>
                <hr>
                <thead>
                    <tr>
                        <th scope="col">#Sl</th>
                        <th scope="col">Image</th>
                        <th scope="col">Change Image </th>
                        <th scope="col">Delete </th>
                    </tr>
                </thead>
                <tbody>
                    <form id="myForm" method="post" action="{{ route('vendor.update.product.MultiImage') }}" enctype="multipart/form-data">
                        @csrf
                        @foreach($multiImages as $key => $img)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td><img src="{{ asset($img->photo_name) }}" height="70px" width="80px" alt=""></td>
                            <td><input type="file" class="form-group" name="multi_img[{{ $img->id }}]"></td>

                            <td>
                                <input type="submit" class="btn btn-primary px-4" value="Update Image" />
                                <a class="btn btn-danger" href="{{ route('vendor.delete.product.MultiImage',$img->id) }}" id="delete">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </form>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function mainThamUrl(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#mainThmb').attr('src', e.target.result).width(80).height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('#multiImg').on('change', function() { //on file input change
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                var data = $(this)[0].files; //this file data

                $.each(data, function(index, file) { //loop though each file
                    if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function(file) { //trigger function on successful read
                            return function(e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result).width(100)
                                    .height(80); //create image element 
                                $('#preview_img').append(img); //append image to output element
                            };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });

            } else {
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="category_id"]').on('change', function() {
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: "{{ url('/subcategory/ajax') }}/" + category_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="subcategory_id"]').html('');
                        var d = $('select[name="subcategory_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="subcategory_id"]').append('<option value="' + value.id + '">' + value.subcategory_name + '</option>');
                        });
                    },
                });
            } else {
                alert('danger');
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#myForm').validate({
            rules: {
                product_name: {
                    required: true,
                },
                short_descp: {
                    required: true,
                },
                long_descp: {
                    required: true,
                },
                product_thambnail: {
                    required: true,
                },
                selling_price: {
                    required: true,
                },
                product_code: {
                    required: true,
                },
                product_qty: {
                    required: true,
                },
                brand_id: {
                    required: true,
                },
                category_id: {
                    required: true,
                },
                subcategory_id: {
                    required: true,
                },
            },
            messages: {
                product_name: {
                    required: 'Please Enter Product Name',
                },
                short_descp: {
                    required: 'Please Enter Short Description',
                },
                long_descp: {
                    required: 'Please Enter Long Description',
                },
                product_thambnail: {
                    required: 'Please Enter Main Thambnail',
                },
                selling_price: {
                    required: 'Please Enter Product Price',
                },
                product_code: {
                    required: 'Please Enter Product Code',
                },
                product_qty: {
                    required: 'Please Enter Product Qty',
                },
                brand_id: {
                    required: 'Please Enter Product Brand',
                },
                category_id: {
                    required: 'Please Enter Product Category',
                },
                subcategory_id: {
                    required: 'Please Enter Product SubCategory',
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>
@endsection