<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\ActiveUserController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ReturnController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\VendorOrderController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Payment\CashController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\AllUserController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\CompareController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('frontend.index');
// })->name('/');

//frontend IndexController product details all store
Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetails']);
Route::get('/vendor/details/{id}', [IndexController::class, 'vendorDetails'])->name('vendor.details');
Route::get('/all/vendor/', [IndexController::class, 'AllVendor'])->name('all.vendor');
Route::get('/', [IndexController::class, 'Index'])->name('/');
Route::get('/product/category/{id}/{slug}', [IndexController::class, 'CatWiseProduct']);
Route::get('/product/subcategory/{id}/{slug}', [IndexController::class, 'SubCatWiseProduct']);

//All contact route
Route::get('/contact/us/', [IndexController::class, 'ContactUs'])->name('contact.us');
Route::post('/contact/store/', [IndexController::class, 'ContactStore'])->name('contact.store');
Route::get('/pending/contact/', [IndexController::class, 'PendingContact'])->name('pending.contact');
Route::get('/accepted/contact/{id}', [IndexController::class, 'AcceptedContact'])->name('accepted.contact');
Route::get('/accepted/contact/', [IndexController::class, 'AllAcceptedContact'])->name('all.accepted.contact');
Route::get('/delete/contact/{id}', [IndexController::class, 'DeleteContact'])->name('delete.contact');
 // Cash All Route 
 Route::controller(CashController::class)->group(function () {
    Route::get('/cash/order/id', 'CashOrderById')->name('cash.order.by.id');
});
// product view modal with ajax
Route::get('/product/view/modal/{id}/', [IndexController::class, 'ProductViewAjax']);

// product CartController add to cart store
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);

// Details product CartController add to cart store
Route::post('/dcart/data/store/{id}', [CartController::class, 'DetailsAddToCart']);

// product CartController minicart
Route::get('/product/mini/cart/', [CartController::class, 'ProductMiniCart']);

// product CartController minicart
Route::get('/minicart/product/remove/{rowID}', [CartController::class, 'MiniCartRemove']);

// add to wishlist product
Route::post('/add-to-wishlist/{product_id}/', [WishlistController::class, 'AddToWishlist']);

/// Frontend Coupon Option
Route::post('/apply-coupon', [CartController::class, 'ApplyCoupon']);
Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);

// Checkout Page Route 
Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');

// Cart All Route 
Route::controller(CartController::class)->group(function () {
    Route::get('/mycart', 'MyCart')->name('mycart');
    Route::get('/get-mycart-product/', 'GetMyCartProduct');
    Route::get('/mycart-remove/{rowId}', 'MyCartRemove');
    Route::get('/cartqty-decrement/{rowId}', 'cartQtyDecrement');
    Route::get('/cartqty-increment/{rowId}', 'CartQtyIncrement');
});

// Search All Route 
Route::controller(IndexController::class)->group(function () {
    Route::post('/search', 'ProductSearch')->name('product.search');
});

// Frontend Blog Post All Route 
Route::controller(ReviewController::class)->group(function () {

    Route::post('/store/review', 'StoreReview')->name('store.review');
});

//user all route
Route::middleware(['auth', 'role:user'])->group(function () {
    //wishlist All Route 
    Route::controller(WishlistController::class)->group(function () {
        Route::get('/wishlist/', 'AllWishlist')->name('wishlist');
        Route::get('/display/wishlist/data/', 'GetWishlistProduct');
        Route::get('/wishlist/remove/{id}', 'WishlistRemove');
    });


    // Checkout All Route 
    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/district-get/ajax/{division_id}', 'DistrictGetAjax');
        Route::get('/state-get/ajax/{district_id}', 'StateGetAjax');
        Route::post('/checkout/store', 'CheckoutStore')->name('checkout.store');
    });

    // Cash All Route 
    Route::controller(CashController::class)->group(function () {
        Route::post('/cash/order', 'CashOrder')->name('cash.order');
    });

    // User Dashboard All Route 
    Route::controller(AllUserController::class)->group(function () {
        Route::get('/user/account/page', 'UserAccount')->name('user.account.page');
        Route::get('/user/change/password', 'UserChangePassword')->name('user.change.password');

        Route::get('/user/order/page', 'UserOrderPage')->name('user.order.page');

        Route::get('/user/order_details/{order_id}', 'UserOrderDetails');
        Route::get('/user/invoice_download/{order_id}', 'UserOrderInvoice');

        Route::post('/return/order/{order_id}', 'ReturnOrder')->name('return.order');

        Route::get('/return/order/page', 'ReturnOrderPage')->name('return.order.page');

        // Order Tracking 
        Route::get('/user/track/order', 'UserTrackOrder')->name('user.track.order');
        Route::get('/all/voucher/', 'AllVoucher')->name('all.voucher');
        Route::post('/order/tracking', 'OrderTracking')->name('order.tracking');
    });
});
//user all route end

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');
});

//Admin dashbord
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashbord');
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('update.password');
});

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);
Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');

//Vendor dashbord
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashbord');
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/update/password', [VendorController::class, 'VendorUpdatePassword'])->name('update.password');

    //vendorProcuct section
    Route::controller(VendorProductController::class)->group(function () {
        Route::get('/vendor/all/product', 'VendorAllProduct')->name('vendor.all.product');
        Route::get('/vendor/add/product', 'VendorAddProcuct')->name('vendor.add.product');
        Route::get('/vendor/subcategory/ajax/{category_id}', 'VendorGetSubCategory');
        Route::post('/vendor/store/product', 'VendorStoreProcuct')->name('vendor.store.product');
        Route::get('/vendor/edit/product/{id}', 'VendorEditProduct')->name('vendor.edit.product');
        Route::get('/vendor/delete/product/{id}', 'VendorDeleteProcuct')->name('vendor.delete.product');
        Route::get('/vendor/inactive/product/{id}', 'VendorInactiveProduct')->name('vendor.inactive.product');
        Route::get('/vendor/active/product/{id}', 'VendorActiveProduct')->name('vendor.active.product');
        Route::post('/vendor/update/product', 'VendorUpdateProduct')->name('vendor.update.product');
        Route::post('/vendor/update/Image/product', 'VendorUpdateProductImage')->name('vendor.update.mainThumb.product');
        Route::post('/vendor/update/product/MultiImage', 'VendorUpdateProductMultitImage')->name('vendor.update.product.MultiImage');
        Route::get('/vendor/delete/product/MultiImage/{id}', 'VendorDeleteProductMultitImage')->name('vendor.delete.product.MultiImage');
    });

    // Vendor Order All Route 
    Route::controller(VendorOrderController::class)->group(function () {
        Route::get('/vendor/order', 'VendorOrder')->name('vendor.order');
        Route::get('/vendor/return/order', 'VendorReturnOrder')->name('vendor.return.order');
        Route::get('/vendor/complete/return/order' , 'VendorCompleteReturnOrder')->name('vendor.complete.return.order');
        Route::get('/vendor/order/details/{order_id}' , 'VendorOrderDetails')->name('vendor.order.details');
    });

    // Vendor Reviw All Route 
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/vendor/all/review' , 'VendorAllReview')->name('vendor.all.review');
    });
});

// Admin middleware and controller
Route::middleware(['auth', 'role:admin'])->group(function () {
    //Brand section
    Route::controller(BrandController::class)->group(function () {
        Route::get('/all/brand', 'AllBrand')->name('all.brand');
        Route::get('/add/brand', 'AddBrand')->name('add.brand');
        Route::post('/store/brand', 'StoreBrand')->name('store.brand');
        Route::get('/edit/brand/{id}', 'EditBrand')->name('edit.brand');
        Route::post('/update/brand', 'UpdateBrand')->name('update.brand');
        Route::get('/delete/brand/{id}', 'DeleteBrand')->name('delete.brand');
    });

    //Category section
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/category', 'StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/category', 'UpdateCategory')->name('update.category');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');
    });

    //SubCategory section
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory');
        Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory');
        Route::post('/store/subcategory', 'StoreSubCategory')->name('store.subcategory');
        Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
        Route::post('/update/subcategory', 'UpdateSubCategory')->name('update.subcategory');
        Route::get('/delete/subcategory/{id}', 'DeleteSubCategory')->name('delete.subcategory');
        Route::get('/subcategory/ajax/{category_id}', 'GetSubCategory');
    });

    //Active and Inactive Vendor section
    Route::controller(AdminController::class)->group(function () {
        Route::get('/active/vendor', 'ActiveVendor')->name('active.vendor');
        Route::get('/inactive/vendor', 'InactiveVendor')->name('inactive.vendor');
        Route::get('/inactive/vendor/details/{id}', 'InactiveVendorDetails')->name('inactive.vendor.details');
        Route::post('/active/vendor/approved', 'ActiveVendorApproved')->name('active.vendor.approved');

        Route::get('/active/vendor/details/{id}', 'ActiveVendorDetails')->name('active.vendor.details');
        Route::post('/inactive/vendor/approved', 'InactiveVendorApproved')->name('inactive.vendor.approved');
    });

    //Procuct all route
    Route::controller(ProductController::class)->group(function () {
        Route::get('/all/product', 'AllProduct')->name('all.product');
        Route::get('/add/product', 'AddProcuct')->name('add.product');
        Route::post('/store/product', 'StoreProcuct')->name('store.product');
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
        Route::get('/delete/product/{id}', 'DeleteProcuct')->name('delete.product');
        Route::get('/inactive/product/{id}', 'InactiveProduct')->name('inactive.product');
        Route::get('/active/product/{id}', 'ActiveProduct')->name('active.product');
        Route::post('/update/product', 'UpdateProduct')->name('update.product');
        Route::post('/update/Image/product', 'UpdateProductImage')->name('update.mainThumb.product');
        Route::post('/update/product/MultiImage', 'UpdateProductMultitImage')->name('update.product.MultiImage');
        Route::get('/delete/product/MultiImage/{id}', 'DeleteProductMultitImage')->name('delete.product.MultiImage');

        // for product stock
        Route::get('/product/stock', 'ProductStock')->name('product.stock');
    });

    //slider section
    Route::controller(SliderController::class)->group(function () {
        Route::get('/all/slider', 'AllSlider')->name('all.slider');
        Route::get('/add/slider', 'AddSlider')->name('add.slider');
        Route::post('/store/slider', 'StoreSlider')->name('store.slider');
        Route::get('/edit/slider/{id}', 'EditSlider')->name('edit.slider');
        Route::post('/update/slider', 'UpdateSlider')->name('update.slider');
        Route::get('/delete/slider/{id}', 'DeleteSlider')->name('delete.slider');
    });

    //  All Route 
    Route::controller(CouponController::class)->group(function () {
        Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
        Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
        Route::post('/store/coupon', 'StoreCoupon')->name('store.coupon');
        Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
        Route::post('/update/coupon', 'UpdateCoupon')->name('update.coupon');
        Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');
    });

    // Shipping Division All Route 
    Route::controller(ShippingAreaController::class)->group(function () {
        Route::get('/all/division', 'AllDivision')->name('all.division');
        Route::get('/add/division', 'AddDivision')->name('add.division');
        Route::post('/store/division', 'StoreDivision')->name('store.division');
        Route::get('/edit/division/{id}', 'EditDivision')->name('edit.division');
        Route::post('/update/division', 'UpdateDivision')->name('update.division');
        Route::get('/delete/division/{id}', 'DeleteDivision')->name('delete.division');
    });

    // Shipping District All Route 
    Route::controller(ShippingAreaController::class)->group(function () {
        Route::get('/all/district', 'AllDistrict')->name('all.district');
        Route::get('/add/district', 'AddDistrict')->name('add.district');
        Route::post('/store/district', 'StoreDistrict')->name('store.district');
        Route::get('/edit/district/{id}', 'EditDistrict')->name('edit.district');
        Route::post('/update/district', 'UpdateDistrict')->name('update.district');
        Route::get('/delete/district/{id}', 'DeleteDistrict')->name('delete.district');
    });

    // Shipping State All Route 
    Route::controller(ShippingAreaController::class)->group(function () {
        Route::get('/all/state', 'AllState')->name('all.state');
        Route::get('/add/state', 'AddState')->name('add.state');
        Route::post('/store/state', 'StoreState')->name('store.state');
        Route::get('/edit/state/{id}', 'EditState')->name('edit.state');
        Route::post('/update/state', 'UpdateState')->name('update.state');
        Route::get('/delete/state/{id}', 'DeleteState')->name('delete.state');
        Route::get('/district/ajax/{division_id}', 'GetDistrict');
    });

    // Admin Order All Route 
    Route::controller(OrderController::class)->group(function () {
        Route::get('/pending/order', 'PendingOrder')->name('pending.order');
        Route::get('/admin/order/details/{order_id}', 'AdminOrderDetails')->name('admin.order.details');
        Route::get('/admin/confirmed/order', 'AdminConfirmedOrder')->name('admin.confirmed.order');
        Route::get('/admin/processing/order', 'AdminProcessingOrder')->name('admin.processing.order');
        Route::get('/admin/delivered/order', 'AdminDeliveredOrder')->name('admin.delivered.order');

        Route::get('/pending/confirm/{order_id}', 'PendingToConfirm')->name('pending-confirm');
        Route::get('/confirm/processing/{order_id}', 'ConfirmToProcess')->name('confirm-processing');
        Route::get('/processing/delivered/{order_id}', 'ProcessToDelivered')->name('processing-delivered');
        Route::get('/admin/invoice/download/{order_id}', 'AdminInvoiceDownload')->name('admin.invoice.download');
    });

    // Return Order All Route 
    Route::controller(ReturnController::class)->group(function () {
        Route::get('/return/request', 'ReturnRequest')->name('return.request');
        Route::get('/return/request/approved/{order_id}', 'ReturnRequestApproved')->name('return.request.approved');
        Route::get('/complete/return/request', 'CompleteReturnRequest')->name('complete.return.request');
    });

    // Report All Route 
    Route::controller(ReportController::class)->group(function () {
        Route::get('/report/view', 'ReportView')->name('report.view');
        Route::post('/search/by/date', 'SearchByDate')->name('search-by-date');
        Route::post('/search/by/month', 'SearchByMonth')->name('search-by-month');
        Route::post('/search/by/year', 'SearchByYear')->name('search-by-year');

        Route::get('/order/by/user', 'OrderByUser')->name('order.by.user');
        Route::post('/search/by/user', 'SearchByUser')->name('search-by-user');
    });

    // Active user and vendor All Route 
    Route::controller(ActiveUserController::class)->group(function () {

        Route::get('/all/user', 'AllUser')->name('all-user');
        Route::get('/actives/vendor', 'ActiveVendor')->name('active-vendor');
    });

    // Site Setting all Route 
    Route::controller(SiteSettingController::class)->group(function () {

        Route::get('/site/setting', 'SiteSetting')->name('site-setting');
        Route::post('/site/setting/update', 'SiteSettingUpdate')->name('site.setting.update');
        Route::post('/seo/setting/update', 'SeoSettingUpdate')->name('seo.setting.update');
        Route::get('/seo/setting', 'SeoSetting')->name('seo.setting');
    });

    // Admin Reviw All Route 
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/pending/review', 'PendingReview')->name('pending.review');
        Route::get('/review/approve/{id}', 'ReviewApprove')->name('review.approve');
        Route::get('/publish/review', 'PublishReview')->name('publish.review');
        Route::get('/review/delete/{id}', 'ReviewDelete')->name('review.delete');
    });
}); // End Admin middleware and controller


require __DIR__ . '/auth.php';
