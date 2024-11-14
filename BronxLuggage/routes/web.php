<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
//Front End
//Home
Route::group(['prefix' => ''], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home/index', [HomeController::class, 'index'])->name('home');;
});

//Contact Us
Route::group(['prefix' => ''], function () {
    Route::get('/contactus/index', [ContactusController::class, 'contactus']);
    Route::post('/save-contact', [ContactusController::class, 'save_contact']);
});

//Shop
Route::group(['prefix' => 'shop'], function () {
    Route::get('/index', [ShopController::class, 'index']);
    Route::get('/shopsingle', [ShopController::class, 'shopsingle']);
    Route::get('/product-detail/{id}', [ProductController::class, 'product_detail']);
    Route::get('/search-products-name', [ShopController::class, 'searchByName']);
});

//Category_Product
Route::group(['prefix' => ''], function () {
    Route::get('/category-product/{id}', [CategoryController::class, 'show_category']);
});

//Brand_Product
Route::group(['prefix' => ''], function () {
    Route::get('/brand-product/{id}', [BrandController::class, 'show_brand']);
    Route::get('/product-detail/{id}', [ProductController::class, 'product_detail']);
    Route::post('/product-detail/{id}', [ProductController::class, 'postComment']);//cmt trang shop
});

//About Us
Route::group(['prefix' => ''], function () {
    Route::get('/aboutus/index', [AboutUsController::class, 'index']);
});

//Login User
Route::group(['prefix' => ''], function () {
    Route::get('/login/index', [LoginController::class, 'index']);
});

//Register
Route::group(['prefix' => ''], function () {
    Route::get('/register/index', [RegisterController::class, 'index']);
});

//Cart
Route::group(['prefix' => ''], function () {
    Route::get('/show-cart', [CartController::class, 'show_cart']);
    Route::get('/delete-cart/{id}', [CartController::class, 'delete_cart']);

    Route::post('/update-cart-quantity/{id}', [CartController::class, 'update_cart_quantity']);
    Route::post('/save-cart', [CartController::class, 'save_cart']);
});

//Customer
Route::group(['prefix' => ''], function () {
    Route::get('/logout', [CustomerController::class, 'logout']);

    Route::post('/add-customer', [CustomerController::class, 'add_customer']);
    Route::post('/home/index', [CustomerController::class, 'login']);
});

//Checkout
Route::get('/checkout-page', [CheckoutController::class, 'index']);
Route::get('/payment', [CheckoutController::class, 'payment']);

Route::post('/order-place', [CheckoutController::class, 'order_place']);
Route::post('/save-checkout', [CheckoutController::class, 'save_checkout']);

//Order
Route::get('/manage-order', [CheckoutController::class, 'manage_order']);
Route::get('/view-order/{id}', [CheckoutController::class, 'view_order']);
Route::get('/search-order-name', [CheckoutController::class, 'searchByName']);
Route::get('/detele-order/{id}', [CheckoutController::class, 'delete_order']);
Route::post('/delete-orders', [CheckoutController::class, 'deleteOrders']);

//Gallery
Route::group(['prefix' => ''], function () {
    Route::get('/add-gallery/{id}', [ProductGalleryController::class, 'add_gallery']);
    Route::post('/select-gallery', [ProductGalleryController::class, 'select_gallery']);
    Route::post('/insert-gallery/{product_id}', [ProductGalleryController::class, 'insert_gallery']);
    Route::post('/update-gallery-name', [ProductGalleryController::class, 'update_gallery_name']);
    Route::post('/delete-gallery', [ProductGalleryController::class, 'delete_gallery']);
    Route::post('/update-gallery', [ProductGalleryController::class, 'update_gallery']);

});

//Customer Orders
Route::get('/order-details/{id}', [OrderController::class, 'showCustomerOrders']);
//Back end
//Admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminController::class, 'index']);
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/logout', [AdminController::class, 'logout']);

    Route::post('/admin-dashboard', [AdminController::class, 'admindashboard']);
});

//Category_Admin
Route::group(['prefix' => ''], function () {
    Route::get('/add-category', [CategoryController::class, 'add_category']);
    Route::get('/all-category', [CategoryController::class, 'all_category']);
    Route::get('/edit-category/{id}', [CategoryController::class, 'edit_category']);
    Route::get('/detele-category/{id}', [CategoryController::class, 'delete_category']);
    Route::get('/unactive-category/{id}', [CategoryController::class, 'unactive_category']);
    Route::get('/active-category/{id}', [CategoryController::class, 'active_category']);

    Route::post('/delete-categories', [CategoryController::class, 'deleteCategories']);
    Route::post('/save-category', [CategoryController::class, 'save_category']);
    Route::post('/update-category/{id}', [CategoryController::class, 'update_category']);
    Route::get('/search-category-name', [CategoryController::class, 'searchByName']);
});

//Brand_Admin
Route::group(['prefix' => ''], function () {
    Route::get('/add-brand', [BrandController::class, 'add_brand']);
    Route::get('/all-brand', [BrandController::class, 'all_brand']);
    Route::get('/edit-brand/{id}', [BrandController::class, 'edit_brand']);
    Route::get('/detele-brand/{id}', [BrandController::class, 'delete_brand']);
    Route::get('/unactive-brand/{id}', [BrandController::class, 'unactive_brand']);
    Route::get('/active-brand/{id}', [BrandController::class, 'active_brand']);

    Route::post('/delete-brands', [BrandController::class, 'deleteBrands']);
    Route::post('/save-brand', [BrandController::class, 'save_brand']);
    Route::post('/update-brand/{id}', [BrandController::class, 'update_brand']);
    Route::get('/search-brand-name', [BrandController::class, 'searchByName']);
});

//Product_Admin
Route::group(['prefix' => ''], function () {
    Route::get('/add-product', [ProductController::class, 'add_product']);
    Route::get('/all-product', [ProductController::class, 'all_product']);
    Route::get('/edit-product/{id}', [ProductController::class, 'edit_product']);
    Route::get('/detele-product/{id}', [ProductController::class, 'delete_product']);
    Route::get('/unactive-product/{id}', [ProductController::class, 'unactive_product']);
    Route::get('/active-product/{id}', [ProductController::class, 'active_product']);
    Route::get('/unactive-comment/{id}', [ProductController::class, 'unactive_comment']);
    Route::get('/active-comment/{id}', [ProductController::class, 'active_comment']);
    Route::get('/comment', [ProductController::class, 'list_comment']);
    Route::get('/detele-comment/{id}', [ProductController::class, 'delete_comment']);

    Route::post('/delete-comments', [ProductController::class, 'deleteComments']);
    Route::post('/delete-products', [ProductController::class, 'deleteProducts']);
    Route::post('/save-product', [ProductController::class, 'save_product']);
    Route::post('/update-product', [ProductController::class, 'update_product']);
    Route::get('/search-product-name', [ProductController::class, 'searchByName']);
});

//Contact
Route::group(['prefix' => ''], function () {

    Route::get('/all-contact', [ContactusController::class, 'all_contact']);
    Route::get('/edit-contact/{id}', [ContactusController::class, 'edit_contact']);
    Route::get('/detele-contact/{id}', [ContactusController::class, 'delete_contact']);
    Route::get('/search-contact-name', [ContactusController::class, 'searchByName']);
    Route::post('/delete-contacts', [ContactusController::class, 'deleteContacts']);
    Route::post('/save-contact', [ContactusController::class, 'save_contact']);
});

//Customer 
Route::get('/manage-customer', [CustomerController::class, 'all_customer']);
Route::get('/search-customer-name', [CustomerController::class, 'searchByName']);
Route::post('/delete-customers', [CustomerController::class, 'deleteCustomers']);
Route::get('/detele-customer/{id}', [CustomerController::class, 'delete_customer']);


