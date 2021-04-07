<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
	Route::get('/', function () {
	    return view('welcome');
	});
*/

Auth::routes();

/*
 * Exception Error Routes
 *-------------------------------------*/
Route::get('404',['as'=>'404','uses'=>'ErrorHandlerController@errorCode404']);

Route::get('405',['as'=>'405','uses'=>'ErrorHandlerController@errorCode405']);

Route::get('403',['as'=>'403','uses'=>'ErrorHandlerController@errorCode403']);

/*
 * Frontend Site
 *-------------------------------------*/
Route::get('/about', 'FrontController@about')->name('about');
Route::get('/shipping-delivery', 'FrontController@shipping')->name('shipping-delivery');
Route::get('/privacy-policy', 'FrontController@privacy')->name('privacy-policy');
Route::get('/return-refund', 'FrontController@refund')->name('return-refund');
Route::get('/faq', 'FrontController@faq')->name('faq');
Route::get('/newses', 'FrontController@newses')->name('newses');
Route::get('/careers', 'FrontController@careers')->name('careers');
Route::get('/jobs', 'FrontController@jobs')->name('jobs');
Route::get('/terms', 'FrontController@terms')->name('terms');
Route::get('/contact', 'FrontController@contact')->name('contact');
Route::get('/showroom-location', 'FrontController@showroom')->name('showroom');
//track
Route::post('/order-track', 'FrontController@OrderTracking')->name('order-track');



//HomePage
Route::get('/', 'FrontController@index')->name('home');

//set location
Route::post('/setlocation', 'FrontController@setlocation')->name('setlocation.submit');

//Search Product
Route::get('/search', 'FrontController@search')->name('search');

//Product Page
Route::get('/category/{slug}', 'FrontController@products')->name('products');

Route::get('/products', 'FrontController@products')->name('products');
Route::get('/services', 'FrontController@services')->name('products');


//Product Details Page
Route::get('/detsils/{id}', 'FrontController@singleProduct')->name('single.product');



//get area form city
Route::get('/city/{id}/area', 'FrontController@get_Areabycity')->name('areabycity');

//Cart
Route::get('/cart', 'CartController@index');
Route::post('/cart/update', 'CartController@update')->name('cart.update');
Route::post('/cart/add', 'CartController@store')->name('cart.add');
Route::delete('/cart/delete', 'CartController@destroy')->name('cart.destroy');
Route::delete('/cart/del/{id}', 'CartController@cartDestroy')->name('cart.delete');


//Cart add by form submit
Route::post('/cart/submit', 'CartController@addcart')->name('cart.submit');

//checkout
Route::get('/checkout', 'CheckoutController@index')->name('checkout');
Route::post('/checkout', 'CheckoutController@store')->name('checkout.submit');
Route::delete('/checkout', 'CheckoutController@OrderCancel')->name('checkout.cancel');

Route::get('/payment/{orderId}', 'CheckoutController@payment')->name('payment');
Route::get('/checkout/{id}/cancel', 'CheckoutController@cancelItem')->name('checkout.cancelitem');

//Get Json Data for Time List slot of Checkout page
Route::get('/timelist/{delId}/{dayval}', 'CheckoutController@GetTimelist')->name('area.timelist');

//Add New Delivery address
Route::post('/delivery/add', 'CheckoutController@AddDelivery')->name('delivery.add');

Route::post('/delivery/{id}', 'CheckoutController@EditDelivery')->name('delivery.update');

/*
 * Users Route Group
 ---------------------------*/
Route::post('/verifyOtp', ['middleware' => 'checkSession', 'uses'=>'userController@verifyOtp']);

Route::get('/verify', 'Auth\RegisterController@verify')->name('verify');
Route::post('/verify', 'Auth\RegisterController@checkVery')->name('check-verify');
Route::post('/sendotpcode', 'Auth\RegisterController@checkVery')->name('send-otp');

//User Logout
Route::post('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
Route::get('/logout', 'Auth\LoginController@userLogout')->name('logout');

//User order routes
Route::get('/users/order', 'HomeController@order')->name('user.order');
Route::get('/users/{id}/order', 'HomeController@showOrder')->name('user.order.details');
Route::post('/users/{id}/order', 'HomeController@updateOrder')->name('user.order.update');

// Forgot Password
Route::get('password/reset', 'Auth\PasswordController@showOtpRequestForm')->name('password.request'); 
Route::post('password/reset', 'Auth\PasswordController@sendOtpCode')->name('password.otgRequest');

Route::get('password/change', 'Auth\PasswordController@showResetForm')->name('password.change');
Route::post('password/change', 'Auth\PasswordController@passChange')->name('password.submit');

/*
 * Admin routes
++++++++++++++++++++++*/
Route::prefix('admin')->group(function(){

	/*
	* Admin Login Section
	*-----------------------------*/
	Route::get('/login', 'Auth\AdminLoginController@ShowLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
	Route::get('/', 'AdminController@index')->name('admin.dashboard');


	/*
	* Category
	*-----------------------------*/
	Route::get('/category', 'CategoryController@index')->name('admin.category');

	//Add category
	Route::get('/add-category', 'CategoryController@create')->name('admin.add-category');
	Route::post('/add-category', 'CategoryController@store')->name('admin.add-category.submit');

	//Update Category Item
	Route::get('/category/{id}/edit', 'CategoryController@edit')->name('admin.edit-category');
	Route::post('/category/{id}', 'CategoryController@update')->name('admin.edit-category.update');

	//Delete Category Item
	Route::delete('/category/{id}', 'CategoryController@destroy')->name('category.destroy');


	/*
	* City
	*-----------------------------*/
	Route::get('/city', 'CityController@index')->name('admin.city');

	//Add city
	Route::get('/add-city', 'CityController@create')->name('admin.add-city');
	Route::post('/add-city', 'CityController@store')->name('admin.add-city.submit');

	//Update city Item
	Route::get('/city/{id}/edit', 'CityController@edit')->name('admin.edit-city');
	Route::post('/city/{id}', 'CityController@update')->name('admin.edit-city.update');

	//Delete city Item
	Route::delete('/city/{id}', 'CityController@destroy')->name('city.destroy');


	/*
	* Area
	*-----------------------------*/
	Route::get('/area', 'AreaController@index')->name('admin.area');

	//Add area
	Route::get('/add-area', 'AreaController@create')->name('admin.add-area');
	Route::post('/add-area', 'AreaController@store')->name('admin.add-area.submit');

	//Update area Item
	Route::get('/area/{id}/edit', 'AreaController@edit')->name('admin.edit-area');
	Route::post('/area/{id}', 'AreaController@update')->name('admin.edit-area.update');

	//Delete area Item
	Route::delete('/area/{id}', 'AreaController@destroy')->name('area.destroy');	


	/*
	* Products
	*-----------------------------*/
	Route::get('/products', 'ProductController@index')->name('admin.products');

	//Add products
	Route::get('/add-products', 'ProductController@create')->name('admin.add-products');
	Route::post('/add-products', 'ProductController@store')->name('admin.add-products.submit');

	//Update products Item
	Route::get('/products/{id}/edit', 'ProductController@edit')->name('admin.edit-products');
	Route::post('/products/{id}', 'ProductController@update')->name('admin.edit-products.update');

	//Delete products Item
	Route::delete('/products/{id}', 'ProductController@destroy')->name('products.destroy');

	//Update products Item
	Route::get('/products/{id}/show', 'ProductController@show')->name('admin.show-products');

	//get area for ajax
	Route::get('/product/{id}/city', 'ProductController@getAreas')->name('city.area');

	//Delete Gallery Images
	Route::post('/delimg', 'ProductController@imgdestroy')->name('admin.delimg');

	//Add Products Options
	Route::post('/options/add', 'ProductController@storOptins')->name('admin.adoptions');
	Route::post('/deloption', 'ProductController@optionDestroy')->name('admin.deloptions');

	/*
	* Area
	*-----------------------------*/
	//Route::get('/order', 'OrderController@index')->name('admin.order');
	Route::get('/order/{status}', 'OrderController@index')->name('admin.order');
	Route::get('/order/{id}/details', 'OrderController@show')->name('admin.order.details');
	Route::post('/order/{id}/update', 'OrderController@update')->name('admin.order.update');

	Route::get('/order-new', 'OrderController@new')->name('admin.order.new');

	/*
	* Slider
	*-----------------------------*/
	Route::get('/slider', 'SliderController@index')->name('admin.slider');

	//Add slider
	Route::get('/add-slider', 'SliderController@create')->name('admin.add-slider');
	Route::post('/add-slider', 'SliderController@store')->name('admin.add-slider.submit');

	//Update slider Item
	Route::get('/slider/{id}/edit', 'SliderController@edit')->name('admin.edit-slider');
	Route::post('/slider/{id}', 'SliderController@update')->name('admin.edit-slider.update'); 
	Route::delete('/slider/{id}', 'SliderController@destroy')->name('slider.destroy');

	//user options
	Route::get('/admins', 'AdminController@adminList')->name('admin.list');
	Route::get('/add-users', 'AdminController@addUsers')->name('admin.add-users');
	Route::post('/add-users', 'AdminController@storeUsers')->name('admin.store-users');
	Route::get('/edit-users/{id}/edit', 'AdminController@editUsers')->name('admin.edit-users');
	Route::post('/edit-users/{id}/update', 'AdminController@updateUsers')->name('admin.update-users');
	Route::delete('/delete-users/{id}', 'AdminController@deleteUsers')->name('admin.delete-users'); 

});
