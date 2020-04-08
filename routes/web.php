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

Route::get('/','HomeController@index')->name('home');

Auth::routes();

Route::group([
    'middleware'=>'roles',
    'roles'=>['admin']
], function(){
    Route::get('/admin/home','admin\HomeController@index')->name('admin.home');

    //admin posts
    Route::get('/admin/posts','admin\PostController@index')->name('admin.posts');
    Route::get('/admin/create/post','admin\PostController@create')->name('admin.post.create');
    Route::put('/admin/store/post','admin\PostController@store')->name('admin.post.store');
    Route::get('/admin/edit/post/{post}','admin\PostController@edit')->name('admin.post.edit');
    Route::put('/admin/post/update/{post}','admin\PostController@update')->name('admin.post.update');
    Route::get('/admin/post/approve/{post}','admin\PostController@approvePost')->name('admin.post.approve');
    Route::get('/admin/post/disapprove/{post}','admin\PostController@disapprovePost')->name('admin.post.disapprove');
    Route::delete('/admin/post/delete/{post}','admin\PostController@delete')->name('admin.post.delete');
    Route::get('/admin/post/user/{user}','admin\PostController@showUserPost')->name('admin.post.user');
    Route::post('/admin/post/filter','admin\PostController@filterPost')->name('admin.post.filter');

    //admin tags
    Route::get('/admin/tags','admin\TagController@index')->name('admin.tags');
    Route::put('/admin/tags/update/{tag}','admin\TagController@update')->name('admin.tag.update');
    Route::put('/admin/tags/store','admin\TagController@store')->name('admin.tag.store');
    Route::delete('/admin/tag/delete/{tag}','admin\tagController@delete')->name('admin.tag.delete');

    //admin categories
    Route::get('/admin/category','admin\CategoryController@index')->name('admin.category');
    Route::put('/admin/category/update/{category}','admin\categoryController@update')->name('admin.category.update');
    Route::put('/admin/category/store','admin\categoryController@store')->name('admin.category.store');
    Route::delete('/admin/category/delete/{category}','admin\categoryController@delete')->name('admin.category.delete');

    //admin users
    Route::get('/admin/user','admin\UserController@index')->name('admin.user');
    Route::put('/admin/user/update','admin\UserController@userUpdate')->name('admin.user.update');
    Route::get('/admin/role','admin\UserController@userRole')->name('admin.user.role');
    Route::put('/admin/role/update/{user}','admin\UserController@userRoleUpdate')->name('admin.role.update');
    Route::delete('/admin/user/delete/{user}','admin\UserController@deleteUser')->name('admin.user.delete');

}); 

Route::group([
    'middleware'=>'roles',
    'roles'=>['user']
], function(){
    Route::get('/user/home','user\HomeController@index')->name('user.home');

    //user posts
    Route::get('/user/posts','user\PostController@index')->name('user.posts');
    Route::post('/user/post/filter','user\PostController@filterPost')->name('user.post.filter');
    Route::get('/user/post/create','user\PostController@create')->name('user.post.create');
    Route::put('/user/post/store','user\PostController@store')->name('user.post.store');
    Route::get('/user/post/edit/{post}','user\PostController@edit')->name('user.post.edit');
    Route::put('/user/post/update/{post}','user\PostController@update')->name('user.post.update');
    Route::delete('/user/post/delete/{post}','user\PostController@delete')->name('user.post.delete');

    //user details
    Route::get('/user/details','user\UserController@index')->name('user.details');
    Route::put('/user/update','user\UserController@userUpdate')->name('user.update');

    //user details
    Route::get('user/details','user\UserController@index')->name('user.details');

  
}); 