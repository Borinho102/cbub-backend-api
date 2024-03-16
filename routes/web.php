<?php

use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProfileController;
use App\Livewire\Admin\Businesses\BusinessDetails;
use App\Livewire\Admin\Businesses\BusinessList;
use App\Livewire\Admin\Businesses\CreateBusiness;
use App\Livewire\Admin\Businesses\EditBusiness;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Categories\CreateCategory as AdminCreateCategory;
use App\Livewire\Admin\Categories\CategoryList as AdminCategoryList;

use App\Livewire\Admin\Products\CreateProduct as AdminCreateProduct;
use App\Livewire\Admin\Products\EditProduct as AdminEditProduct;
use App\Livewire\Admin\Products\ProductList as AdminProductList;
use App\Livewire\Admin\Products\ProductDetails as AdminProductDetails;
use App\Livewire\User\Dashboard as UserDashboard;
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
    Route::get('', AdminDashboard::class)
        ->middleware(['verified'])
        ->name('dashboard');

    Route::get('/profile', [AdminProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [AdminProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // BUSINESSES ROUTES
    Route::get('businesses', BusinessList::class)->name('businesses.index');
    Route::get('businesses/create', CreateBusiness::class)->name('businesses.create');
    Route::get('businesses/{business}/show', BusinessDetails::class)->name('businesses.show');
    Route::get('businesses/{business}/edit', EditBusiness::class)->name('businesses.edit');

    // PRODUCTS ROUTES
    Route::get('products', AdminProductList::class)->name('products.index');
    Route::get('products/create', AdminCreateProduct::class)->name('products.create');
    Route::get('products/{product}/show', AdminProductDetails::class)->name('products.show');
    Route::get('products/{product}/edit', AdminEditProduct::class)->name('products.edit');

    // CATEGORIES ROUTES
    Route::get('categories', AdminCategoryList::class)->name('categories.index');
    Route::get('categories/create', AdminCreateCategory::class)->name('categories.create');
    //Route::get('categories/{category}/edit', EditBusiness::class)->name('categories.edit');
});

Route::group([
    'prefix' => 'business.portal.66/console',
    'middleware' => 'auth:users',
    'as' => 'console.',
], function () {
    Route::get('', UserDashboard::class)
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
