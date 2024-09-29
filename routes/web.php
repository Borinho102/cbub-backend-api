<?php

use App\Http\Controllers\StatisticController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MiscellaneousController;

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Settings as AdminSettings;

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

use App\Livewire\Admin\Notifications\NotificationList as AdminNotificationList;
use App\Livewire\Admin\Notifications\CreateNotification as AdminCreateNotification;

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

use App\Livewire\Admin\Shops\CreateShop as AdminCreateShop;
use App\Livewire\Admin\Shops\EditShop as AdminEditShop;
use App\Livewire\Admin\Shops\ShopList as AdminShopList;

use App\Livewire\Business\Dashboard as BusinessDashboard;
use App\Livewire\Business\Settings as BusinessSettings;

use App\Livewire\Business\Users\UserList as BusinessUserList;
use App\Livewire\Business\Users\EditUser as EditBusinessUser;
use App\Livewire\Business\Users\CreateUser as CreateBusinessUser;

use App\Livewire\Business\Customers\CustomerDetails as BusinessCustomerDetails;
use App\Livewire\Business\Customers\CustomerList as BusinessCustomerList;
use App\Livewire\Business\Customers\CreateCustomer as BusinessCreateCustomer;

use App\Livewire\Business\Notifications\NotificationList as BusinessNotificationList;
use App\Livewire\Business\Notifications\CreateNotification as BusinessCreateNotification;

use App\Livewire\Business\Orders\OrderDetails as BusinessOrderDetails;
use App\Livewire\Business\Orders\OrderList as BusinessOrderList;
use App\Livewire\Business\Orders\EditOrder as BusinessEditOrder;

use App\Livewire\Business\Products\CreateProduct as BusinessCreateProduct;
use App\Livewire\Business\Products\EditProduct as BusinessEditProduct;
use App\Livewire\Business\Products\ProductList as BusinessProductList;
use App\Livewire\Business\Products\ProductDetails as BusinessProductDetails;
use App\Livewire\Business\Products\ProductDiscountList as BusinessProductDiscountList;
use App\Livewire\Business\Products\ProductStockList as BusinessProductStockList;

use App\Livewire\Business\Products\ProductReviewList as BusinessProductReviewList;
use App\Livewire\Business\Products\Categories\CreateCategory as BusinessCreateProductCategory;
use App\Livewire\Business\Products\Categories\EditCategory as BusinessEditProductCategory;
use App\Livewire\Business\Products\Categories\CategoryList as BusinessProductCategoryList;

use App\Livewire\Business\PromoCodes\CreatePromoCode as BusinessCreatePromoCode;
use App\Livewire\Business\PromoCodes\EditPromoCode as BusinessEditPromoCode;
use App\Livewire\Business\PromoCodes\PromoCodeList as BusinessPromoCodeList;

use App\Livewire\Business\Shops\CreateShop as BusinessCreateShop;
use App\Livewire\Business\Shops\EditShop as BusinessEditShop;
use App\Livewire\Business\Shops\ShopList as BusinessShopList;

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

Route::get('', [PageController::class, 'index'])->name('index');
Route::get('privacy', [PageController::class, 'privacyPolicy'])->name('privacy_policy');
Route::get('terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms_and_conditions');

Route::group([
    'prefix' => 'secure.portal.99/console',
    'middleware' => ['auth:admins', 'verified'],
    'as' => 'admin.',
], function () {
    Route::get('', AdminDashboard::class)->name('dashboard');
    Route::get('settings/{menu}', AdminSettings::class)->name('settings');

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

    // SHOPS ROUTES
    Route::get('shops', AdminShopList::class)->name('shops.index');
    Route::get('shops/create', AdminCreateShop::class)->name('shops.create');
    //Route::get('shops/{shop}/show', AdminShopDetails::class)->name('businesses.show');
    Route::get('shops/{shop}/edit', AdminEditShop::class)->name('shops.edit');

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

    // NOTIFICATION ROUTES
    Route::get('notifications', AdminNotificationList::class)->name('notifications.index');
    Route::get('notifications/create', AdminCreateNotification::class)->name('notifications.create');
});

Route::group([
    'prefix' => 'business.portal.66/console',
    'middleware' => ['auth:business', 'verified'],
    'as' => 'business.',
], function () {
    Route::get('', BusinessDashboard::class)->name('dashboard');
    Route::get('settings/{menu}', BusinessSettings::class)->name('settings');

    // SHOPS ROUTES
    Route::get('shops', BusinessShopList::class)->name('shops.index');
    Route::get('shops/create', BusinessCreateShop::class)->name('shops.create');
    //Route::get('shops/{shop}/show', BusinessShopDetails::class)->name('shops.show');
    Route::get('shops/{shop}/edit', BusinessEditShop::class)->name('shops.edit');

    // PRODUCTS ROUTES
    Route::get('products', BusinessProductList::class)->name('products.index');
    Route::get('products/create', BusinessCreateProduct::class)->name('products.create');
    Route::get('products/{product}/show', BusinessProductDetails::class)->name('products.show');
    Route::get('products/{product}/edit', BusinessEditProduct::class)->name('products.edit');
    Route::get('products/reviews', BusinessProductReviewList::class)->name('products.reviews.index');
    Route::get('products/discounts', BusinessProductDiscountList::class)->name('products.discounts.index');
    Route::get('products/stocks', BusinessProductStockList::class)->name('products.stocks.index');

    // PRODUCTS CATEGORIES ROUTES
    Route::get('products/categories', BusinessProductCategoryList::class)->name('products.categories.index');
    Route::get('products/categories/create', BusinessCreateProductCategory::class)->name('products.categories.create');
    Route::get('products/categories/{category}/edit', BusinessEditProductCategory::class)->name('products.categories.edit');

    // PROMO CODE ROUTES
    Route::get('promo-codes', BusinessPromoCodeList::class)->name('promo_codes.index');
    Route::get('promo-codes/create', BusinessCreatePromoCode::class)->name('promo_codes.create');
    Route::get('promo-codes/{promo_code}/edit', BusinessEditPromoCode::class)->name('promo_codes.edit');

    // ORDER ROUTES
    Route::get('orders', BusinessOrderList::class)->name('orders.index');
    Route::get('orders/{order_id}/edit', BusinessEditOrder::class)->name('orders.edit');
    Route::get('orders/{order_id}', BusinessOrderDetails::class)->name('orders.show');

    // CUSTOMERS ROUTES
    Route::get('customers', BusinessCustomerList::class)->name('customers.index');
    Route::get('customers/create', BusinessCreateCustomer::class)->name('customers.create');
    Route::get('customers/{customer}', BusinessCustomerDetails::class)->name('customers.show');

    // USERS ROUTES
    Route::get('users', BusinessUserList::class)->name('users.index');
    Route::get('users/create', CreateBusinessUser::class)->name('users.create');
    Route::get('users/{id}/edit', EditBusinessUser::class)->name('users.edit');

    // NOTIFICATION ROUTES
    Route::get('notifications', BusinessNotificationList::class)->name('notifications.index');
    Route::get('notifications/create', BusinessCreateNotification::class)->name('notifications.create');
});


Route::group([
    'prefix' => 'miscellaneous',
    'middleware' => 'auth:business,admins',
    'as' => 'misc.',
], function () {
    Route::get('statistics/{type}', StatisticController::class)
        ->middleware(['json.response'])
        ->name('statistics');

    Route::get('search/users', [MiscellaneousController::class, 'searchUsers'])
        ->name('search.users');
    Route::get('search/products', [MiscellaneousController::class, 'searchProducts'])
        ->name('search.products');
    Route::get('search/promo-codes', [MiscellaneousController::class, 'searchPromoCodes'])
        ->name('search.promo_codes');
    Route::get('search/product-categories', [MiscellaneousController::class, 'searchProductCategories'])
        ->name('search.product_categories');
    Route::get('search/business-categories', [MiscellaneousController::class, 'searchBusinessCategories'])
        ->name('search.business_categories');
    Route::get('search/businesses', [MiscellaneousController::class, 'searchBusinesses'])
        ->name('search.businesses');
    Route::get('search/customers', [MiscellaneousController::class, 'searchCustomers'])
        ->name('search.customers');
    Route::get('search/shops', [MiscellaneousController::class, 'searchShops'])
        ->name('search.shops');
    Route::get('search/countries', [MiscellaneousController::class, 'searchCountries'])
        ->name('search.countries');
    Route::get('search/countries/{country}/cities', [MiscellaneousController::class, 'searchCountryCities'])
        ->name('search.countries.cities');
});

require __DIR__.'/auth.php';
