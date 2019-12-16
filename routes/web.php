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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/*Route::get('gallery/list','GalleryController@viewGalleryList');
Route::post('gallery/save','GalleryController@saveGallery');

Route::get('gallery/view/{id}','GalleryController@viewGalleryPics');
*/
Route::resource('gallery','GalleryController');
Route::any('image/upload','GalleryController@imageUpload');
Route::delete('deleteImage/{id}', 'GalleryController@destroyImage')->name('deleteImage');
Route::get('more',function(){
	return 'null sd';
});
Route::get('/slideshow/{gallery}','GalleryController@slideshow')->name('gallery.slideshow');