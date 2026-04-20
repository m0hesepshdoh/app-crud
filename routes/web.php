<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CarmodelController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactInfoController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\PartsCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\SparePartsController;

// Front_Auth Subfolder
use App\Http\Controllers\Admin\Front_Auth\LoginController as AdminLoginController;

// Auth Subfolder
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;

// Carhat Subfolder
use App\Http\Controllers\Carhat\CarhatController;

// Front Subfolder
use App\Http\Controllers\Front\BlogController as FrontBlogController;
use App\Http\Controllers\Front\CarsController;
use App\Http\Controllers\Front\ChatbotController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PagesController;
use App\Http\Controllers\Front\ServiceController;

Auth::routes();

Route::group(['namespace' => 'Admin\Front_Auth'], function () {
    Route::get('/login', [AdminLoginController::class, 'login'])->name('login1');
    Route::post('/login-post', [AdminLoginController::class, 'postLogin'])->name('post.login');
});

Route::group(['namespace' => 'Front'], function () {

    Route::get('/', [HomeController::class, 'front_index'])->name('index'); 
    Route::get('/all-categories', [HomeController::class, 'all_categories'])->name('all_categories');
    Route::get('/about-us', [PagesController::class, 'about'])->name('about');
    Route::get('/location', [PagesController::class, 'location'])->name('location');
    Route::get('/users', [PagesController::class, 'user'])->name('user');
    Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
    Route::get('/blog-view/{id?}', [BlogController::class, 'my_blog'])->name('my_blog');
    Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
    Route::get('/advance-search', [HomeController::class, 'advance_search'])->name('advance-search');
    Route::get('/signup', [PagesController::class, 'signup'])->name('signup');
    Route::get('/news', [PagesController::class, 'news'])->name('news');
    Route::get('/article', [PagesController::class, 'article'])->name('article');
    Route::get('/cars', [CarsController::class, 'cars'])->name('cars');
    Route::get('/cars-by-categtory/{slug}', [CarsController::class, 'category_wise_cars'])->name('category_wise_cars');
    Route::get('/specefic-category-wise-car/{id}', [CarsController::class, 'specefic_category_car'])->name('specefic_category_car');
    Route::get('/view/{id}', [CarsController::class, 'cars_view'])->name('cars.view');
    Route::get('/location-cars/{id}', [CarsController::class, 'cars_location'])->name('cars_by_location');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/product/search', [HomeController::class, 'search1'])->name('search1');
    Route::get('/advanced-search', [HomeController::class, 'advance_search'])->name('advanced.search');
    Route::get('/services', [PagesController::class, 'services'])->name('services');
    Route::get('/services/loans', [PagesController::class, 'loans'])->name('loans');
    Route::get('/services/loans/scb', [PagesController::class, 'scb'])->name('loans_scb');

    Route::get('/demo-page', [PagesController::class, 'demo'])->name('demo');

    // Services
    Route::get('/services/service-center', [ServiceController::class, 'service_center'])->name('service_center');
    Route::get('/services/spare-parts', [ServiceController::class, 'spare_parts'])->name('spare_parts');
    Route::get('/service-by-spare-parts/{slug}', [ServiceController::class, 'shop_by_parts'])->name('parts_by_shop');
    Route::get('/spare-parts-shop/{id}', [ServiceController::class, 'shop_view'])->name('view.parts.shop');
    Route::get('/parts-detail/{id}', [ServiceController::class, 'parts_view'])->name('front.parts.view');


    // Ajax Route For ChatBot
    Route::get('/bot_msg', [ChatbotController::class, 'message']);

    // Pages
    Route::group(['prefix' => 'pages'], function () {
    });

});

Route::group(['middleware' => 'auth'], function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
    Route::get('/users', [DashboardController::class, 'user_index'])->name('users.list');
    Route::get('/users/create', [DashboardController::class, 'create'])->name('users.create');
    Route::post('/users/store', [DashboardController::class, 'store'])->name('users.store');
    Route::post('/users/update/{id}', [DashboardController::class, 'update_users'])->name('users.update');
    Route::get('/users/edit/{id}', [DashboardController::class, 'user_edit'])->name('users.edit');
    Route::get('/users/delete/{id}', [DashboardController::class, 'user_delete'])->name('users.delete');
    Route::get('/dashboard/profile/{id}', [DashboardController::class, 'profile'])->name('user.profile');
    Route::post('/update', [DashboardController::class, 'update'])->name('user.update');
    Route::post('/update/password', [DashboardController::class, 'pass_update'])->name('pass.update');

    // User
    Route::get('/user_img_delete/{id?}', [DashboardController::class, 'getDeleteImage'])->name('user-img-delete');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth'], function () {


    // Chat Bot
    Route::group(['prefix' => 'chat_bot'], function () {
        Route::get('/panel', [ChatController::class, 'panel'])->name('chat.bot');
        Route::get('/create', [ChatController::class, 'create'])->name('chat.create');
        Route::post('/store', [ChatController::class, 'store'])->name('chat.store');
        Route::post('/update/{id}', [ChatController::class, 'update'])->name('chat.update');
        Route::get('/edit/{id}', [ChatController::class, 'edit'])->name('chat.edit');
        Route::get('/delete/{id}', [ChatController::class, 'delete'])->name('chat.delete');
    });

    // Products List
    Route::group(['prefix' => 'car'], function () {
        Route::get('/list', [ProductController::class, 'index'])->name('product.list');
        Route::get('/create', [ProductController::class, 'add'])->name('product.add');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/update', [ProductController::class, 'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('/view/{id}', [ProductController::class, 'view'])->name('product.view');
    });

    // Category
    Route::group(['prefix' => 'Category'], function () {
        Route::get('/list', [CategoryController::class, 'list'])->name('admin.category.list');
        Route::get('/add', [CategoryController::class, 'add'])->name('admin.category.add');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::post('/delete/{id}', [CategoryController::class, 'delete'])->name('admin.category.delete');
    });

    // Blog
    Route::group(['prefix' => 'Blog'], function () {
        Route::get('/list', [BlogController::class, 'list'])->name('admin.blog.list');
        Route::get('/add', [BlogController::class, 'add'])->name('admin.blog.add');
        Route::post('/store', [BlogController::class, 'store'])->name('admin.blog.store');
        Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::post('/update/{id}', [BlogController::class, 'update'])->name('admin.blog.update');
        Route::get('/delete/{id}', [BlogController::class, 'delete'])->name('admin.blog.delete');
    });

     // Brand
     Route::group(['prefix' => 'Brand'], function () {
        Route::get('/list', [BrandController::class, 'list'])->name('admin.brand.list');
        Route::get('/add', [BrandController::class, 'add'])->name('admin.brand.add');
        Route::post('/store', [BrandController::class, 'store'])->name('admin.brand.store');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('admin.brand.edit');
        Route::post('/update/{id}', [BrandController::class, 'update'])->name('admin.brand.update');
        Route::post('/delete/{id}', [BrandController::class, 'delete'])->name('admin.brand.delete');
    });

    // Carmodel
    Route::group(['prefix' => 'Carmodel'], function () {
        Route::get('/list', [CarmodelController::class, 'list'])->name('admin.carmodel.list');
        Route::get('/add', [CarmodelController::class, 'add'])->name('admin.carmodel.add');
        Route::post('/store', [CarmodelController::class, 'store'])->name('admin.carmodel.store');
        Route::get('/edit/{id}', [CarmodelController::class, 'edit'])->name('admin.carmodel.edit');
        Route::post('/update/{id}', [CarmodelController::class, 'update'])->name('admin.carmodel.update');
        Route::post('/delete/{id}', [CarmodelController::class, 'delete'])->name('admin.carmodel.delete');
    });

    //Product Image
    Route::get('/product_image/list', [ProductImageController::class, 'index'])->name('product_image.list');
    Route::get('/product_image/add', [ProductImageController::class, 'add'])->name('product_image.add');
    Route::get('/product_image/edit/{id}', [ProductImageController::class, 'edit'])->name('product_image.edit');
    Route::get('/product_image/delete/{id}', [ProductImageController::class, 'delete'])->name('product_image.delete');
    Route::post('/product_image/store', [ProductImageController::class, 'store'])->name('product_image.store');
    Route::post('/product_image/update', [ProductImageController::class, 'update'])->name('product_image.update');

    // Country
    Route::group(['prefix' => 'country'], function () {
        Route::get('/index', [CountryController::class, 'list'])->name('admin.country.list');
        Route::get('/add', [CountryController::class, 'add'])->name('admin.country.add');
        Route::post('/store', [CountryController::class, 'store'])->name('admin.country.store');
        Route::get('/edit/{id}', [CountryController::class, 'edit'])->name('admin.country.edit');
        Route::post('/update/{id}', [CountryController::class, 'update'])->name('admin.country.update');
        Route::post('/delete/{id}', [CountryController::class, 'delete'])->name('admin.country.delete');
    });

    // City
    Route::group(['prefix' => 'city'], function () {
        Route::get('/view', [CityController::class, 'index'])->name('admin.city.index');
        Route::get('/create', [CityController::class, 'create'])->name('admin.city.create');
        Route::post('/store', [CityController::class, 'store'])->name('admin.city.store');
        Route::get('/edit/{id}', [CityController::class, 'edit'])->name('admin.city.edit');
        Route::post('/update/{id}', [CityController::class, 'update'])->name('admin.city.update');
        Route::post('/delete/{id}', [CityController::class, 'delete'])->name('admin.city.delete');
    });

    //ajax route for product module
    Route::get('/prod_img_delete/{id?}', [ProductController::class, 'getDeleteImage']);


    //ajax route for Category module
    Route::get('/category_img_delete/{id?}', [CategoryController::class, 'getDeleteImage']);

    //ajax route for for Blog module
    Route::get('/blog_img_delete/{id?}', [BlogController::class, 'getDeleteImage']);

});

Route::group(['namespace' => 'Admin','prefix' => 'spare-parts'], function () {

    // Spare Parts
    Route::get('/', [SparePartsController::class, 'index'])->name('parts.index');
    Route::get('/create', [SparePartsController::class, 'create'])->name('parts.create');
    Route::post('/store', [SparePartsController::class, 'store'])->name('parts.store');
    Route::get('/edit/{id}', [SparePartsController::class, 'edit'])->name('parts.edit');
    Route::post('/update/{id}', [SparePartsController::class, 'update'])->name('parts.update');
    Route::get('/delete/{id}', [SparePartsController::class, 'delete'])->name('parts.delete');
    Route::get('/view/{id}', [SparePartsController::class, 'view'])->name('parts.view');

    // Ajax
    Route::get('/spare_parts_img_delete/{id?}', [SparePartsController::class, 'getDeleteImage'])->name('spare-parts-img-delete');

});

Route::group(['namespace' => 'Admin','prefix' => 'contact-info'], function () {

    // User Contact Details
    Route::post('/store', [ContactInfoController::class, 'store'])->name('user_contact.store');
    Route::get('/', [ContactInfoController::class, 'index'])->name('user_contact.index');
    Route::get('/delete/{id}', [ContactInfoController::class, 'delete'])->name('user_contact.delete');

});

Route::group(['namespace' => 'Admin','prefix' => 'parts-category'], function () {

    // Parts Category
    Route::get('/', [PartsCategoryController::class, 'index'])->name('parts.category.index');
    Route::get('/create', [PartsCategoryController::class, 'create'])->name('parts.category.create');
    Route::post('/store', [PartsCategoryController::class, 'store'])->name('parts.category.store');
    Route::get('/edit/{id}', [PartsCategoryController::class, 'edit'])->name('parts.category.edit');
    Route::post('/update/{id}', [PartsCategoryController::class, 'update'])->name('parts.category.update');
    Route::get('/delete/{id}', [PartsCategoryController::class, 'delete'])->name('parts.category.delete');

    // Ajax Route
    Route::get('/parts_img_delete/{id?}', [PartsCategoryController::class, 'getDeleteImage'])->name('parts-img-delete');

});

Route::get('/cc', function () {
    // \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    
    // \Artisan::call('route:cache');
    \Artisan::call('config:clear');
    \Artisan::call('config:cache');
});
