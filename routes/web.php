<?php

use App\Http\Controllers\Admin\DataFeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MiscellaneousController;
use App\Livewire\Admin\Dashboard as AdminDashboard;

use App\Livewire\Admin\Admins\AdminList;
use App\Livewire\Admin\Admins\EditAdmin;
use App\Livewire\Admin\Admins\CreateAdmin;

use App\Livewire\Admin\Customers\CustomerDetails as AdminCustomerDetails;
use App\Livewire\Admin\Customers\CustomerList as AdminCustomerList;
use App\Livewire\Admin\Orders\OrderDetails as AdminOrderDetails;
use App\Livewire\Admin\Orders\OrderList as AdminOrderList;

use App\Livewire\Admin\Businesses\BusinessDetails;
use App\Livewire\Admin\Businesses\BusinessList;
use App\Livewire\Admin\Businesses\CreateBusiness;
use App\Livewire\Admin\Businesses\EditBusiness;
use App\Livewire\Admin\Businesses\ProductList as AdminBusinessProductList;
use App\Livewire\Admin\Businesses\UserList as AdminBusinessUserList;
use App\Livewire\Admin\Businesses\Categories\CreateCategory as AdminCreateBusinessCategory;
use App\Livewire\Admin\Businesses\Categories\EditCategory as AdminEditBusinessCategory;
use App\Livewire\Admin\Businesses\Categories\CategoryList as AdminBusinessCategoryList;

use App\Livewire\Admin\Products\CreateProduct as AdminCreateProduct;
use App\Livewire\Admin\Products\EditProduct as AdminEditProduct;
use App\Livewire\Admin\Products\ProductList as AdminProductList;
use App\Livewire\Admin\Products\ProductDetails as AdminProductDetails;
use App\Livewire\Admin\Products\ProductDiscountList as AdminProductDiscountList;
use App\Livewire\Admin\Products\ProductStockList as AdminProductStockList;

use App\Livewire\Admin\Products\ProductReviewList as AdminProductReviewList;
use App\Livewire\Admin\Products\Categories\CreateCategory as AdminCreateProductCategory;
use App\Livewire\Admin\Products\Categories\EditCategory as AdminEditProductCategory;
use App\Livewire\Admin\Products\Categories\CategoryList as AdminProductCategoryList;

use App\Livewire\Admin\PromoCodes\CreatePromoCode as AdminCreatePromoCode;
use App\Livewire\Admin\PromoCodes\EditPromoCode as AdminEditPromoCode;
use App\Livewire\Admin\PromoCodes\PromoCodeList as AdminPromoCodeList;

use App\Livewire\Business\Dashboard as BusinessDashboard;
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

Route::get('', HomeController::class)->name('index');

Route::group([
    'prefix' => 'secure.portal.99/console',
    'middleware' => 'auth:admins',
    'as' => 'admin.',
], function () {
    Route::get('json-data-feed/{type}', [DataFeedController::class, 'getDataFeed'])
        ->name('json_data_feed');

    Route::get('', AdminDashboard::class)
        ->middleware(['verified'])
        ->name('dashboard');

    // BUSINESSES ROUTES
    Route::get('businesses', BusinessList::class)->name('businesses.index');
    Route::get('businesses/create', CreateBusiness::class)->name('businesses.create');
    Route::get('businesses/{business}/show', BusinessDetails::class)->name('businesses.show');
    Route::get('businesses/{business}/edit', EditBusiness::class)->name('businesses.edit');

    // BUSINESSES CATEGORIES ROUTES
    Route::get('businesses/categories', AdminBusinessCategoryList::class)
        ->name('businesses.categories.index');
    Route::get('businesses/categories/create', AdminCreateBusinessCategory::class)
        ->name('businesses.categories.create');
    Route::get('businesses/categories/{category}/edit', AdminEditBusinessCategory::class)
        ->name('businesses.categories.edit');
    Route::get('businesses/{business}/products', AdminBusinessProductList::class)
        ->name('businesses.products.index');
    Route::get('businesses/{business}/users', AdminBusinessUserList::class)
        ->name('businesses.users.index');

    // PRODUCTS ROUTES
    Route::get('products', AdminProductList::class)->name('products.index');
    Route::get('products/create', AdminCreateProduct::class)->name('products.create');
    Route::get('products/{product}/show', AdminProductDetails::class)->name('products.show');
    Route::get('products/{product}/edit', AdminEditProduct::class)->name('products.edit');
    Route::get('products/reviews', AdminProductReviewList::class)->name('products.reviews.index');
    Route::get('products/discounts', AdminProductDiscountList::class)->name('products.discounts.index');
    Route::get('products/stocks', AdminProductStockList::class)->name('products.stocks.index');

    // PRODUCTS CATEGORIES ROUTES
    Route::get('products/categories', AdminProductCategoryList::class)->name('products.categories.index');
    Route::get('products/categories/create', AdminCreateProductCategory::class)->name('products.categories.create');
    Route::get('products/categories/{category}/edit', AdminEditProductCategory::class)->name('products.categories.edit');

    // PROMO CODE ROUTES
    Route::get('promo-codes', AdminPromoCodeList::class)->name('promo_codes.index');
    Route::get('promo-codes/create', AdminCreatePromoCode::class)->name('promo_codes.create');
    Route::get('promo-codes/{promo_code}/edit', AdminEditPromoCode::class)->name('promo_codes.edit');

    // ORDER ROUTES
    Route::get('orders', AdminOrderList::class)->name('orders.index');
    Route::get('orders/{order}', AdminOrderDetails::class)->name('orders.show');

    // CUSTOMERS ROUTES
    Route::get('customers', AdminCustomerList::class)->name('customers.index');
    Route::get('customers/{customer}', AdminCustomerDetails::class)->name('customers.show');

    // ADMIN ROUTES
    Route::get('admins', AdminList::class)->name('admins.index');
    Route::get('admins/create', CreateAdmin::class)->name('admins.create');
    Route::get('admins/{id}/edit', EditAdmin::class)->name('admins.edit');
});

Route::group([
    'prefix' => 'business.portal.66/console',
    'middleware' => 'auth:business',
    'as' => 'business.',
], function () {
    Route::get('', BusinessDashboard::class)
        ->name('dashboard');
});


Route::group([
    'prefix' => 'miscellaneous',
    'middleware' => 'auth:business,admins',
    'as' => 'misc.',
], function () {
    Route::get('search/users', [MiscellaneousController::class, 'searchUsers'])
        ->name('search.users');
    Route::get('search/products', [MiscellaneousController::class, 'searchProducts'])
        ->name('search.products');
    Route::get('search/product-categories', [MiscellaneousController::class, 'searchProductCategories'])
        ->name('search.product_categories');
    Route::get('search/businesses', [MiscellaneousController::class, 'searchBusinesses'])
        ->name('search.businesses');
});

require __DIR__.'/auth.php';
