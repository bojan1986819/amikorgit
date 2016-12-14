<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', function () {
    if(Auth::check()){return Redirect::to('users');}
    return view('welcome');
})->name('home');

Route::get('/users', function () {
    if(Auth::check()){return Redirect::to('users');}
    return view('welcome');
});

Route::post('/signup', [
    'uses' => 'UserController@postSignUp',
    'as' => 'signup'
]);

Route::post('/signin', [
    'uses' => 'UserController@postSignIn',
    'as' => 'signin'
]);

Route::get('/logout', [
    'uses' => 'UserController@getLogout',
    'as' => 'logout'
]);

Route::get('/account', [
    'uses' => 'UserController@getAccount',
    'as' => 'account'
]);

Route::post('/upateaccount', [
    'uses' => 'UserController@postSaveAccount',
    'as' => 'account.save'
]);

Route::get('/userimage/{filename}', [
    'uses' => 'UserController@getUserImage',
    'as' => 'account.image'
]);

Route::get('/users', [
    'uses' => 'UserController@getUserList',
    'as' => 'users',
    'middleware' => 'admin'
]);

Route::get('/delete-user/{user_id}', [
    'uses' => 'UserController@getDeleteUser',
    'as' => 'user.delete',
    'middleware' => 'admin'
]);

Route::post('/edituser', [
    'uses' => 'UserController@postEditUser',
    'as' => 'edituser',
    'middleware' => 'admin'
]);

Route::match(['get','post'],'/clients', [
    'uses' => 'ClientController@getIndex',
    'as' => 'clients',
    'middleware' => 'auth'
]);

Route::get('/clientsdata', [
    'uses' => 'ClientController@anyData',
    'as' => 'clientsdata',
    'middleware' => 'auth'
]);

/*innen kezdődnek a CRUD-os verzió dolgai a kliensekhez*/

Route::group(['middleware' => ['web']], function() {
    Route::resource('client','ClientController');
    Route::post ( '/editItem', 'ClientController@editItem' );
    Route::post ( '/addItem', 'ClientController@addItem' );
    Route::post ( '/deleteItem', 'ClientController@deleteItem' );
});

Route::get('/client', [
    'uses' => 'ClientController@index',
    'as' => 'client',
    'middleware' => 'auth'
]);

Route::get('/clientsearch', [
    'uses' => 'ClientController@clientSearch',
    'as' => 'clientsearch',
    'middleware' => 'auth'
]);


Route::any('/new_product', [
    'uses' => 'ProductController@newProduct',
    'as' => 'new_product',
    'middleware' => 'auth'
]);

Route::any('/products', [
    'uses' => 'ProductController@productIndex',
    'as' => 'products',
    'middleware' => 'auth'
]);

Route::any('/all_products', [
    'uses' => 'ProductController@allProductList',
    'as' => 'all_products',
    'middleware' => 'auth'
]);

Route::get('/products/{id}', 'ProductController@getProduct');

Route::get('/new_product/nameautocomplete', 'ProductController@nameAutocomplete');

Route::any('/neworder', [
    'uses' => 'InvoiceController@newOrder',
    'as' => 'neworder',
    'middleware' => 'auth'
]);

Route::get('email', ['uses' => 'MailController@getEmailForm', 'as' => 'email', 'middleware' => 'auth']);
Route::post('postemail', ['uses' => 'MailController@postEmail','as' => 'postemail', 'middleware' => 'auth']);

Route::any('/balance', [
    'uses' => 'CalculationController@allIncome',
    'as' => 'balance',
    'middleware' => 'auth'
]);



