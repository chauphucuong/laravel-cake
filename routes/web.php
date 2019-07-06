<?php

use App\Http\Controllers\PageController;

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


Route::get('/',[
    'as' =>'trang-chu',
    'uses'=>'PageController@getIndex'
]);

Route::get('loai-san-pham/{type}',[
    'as' =>'loaisanpham',
    'uses'=>'PageController@getLoaiSP'
]);
Route::get('chi-tiet-san-pham/{id}',[
    'as' =>'chitietsanpham',
    'uses'=>'PageController@getChiTietSP'
]);

Route::get('lien-he',[
    'as' =>'lienhe',
    'uses'=>'PageController@getLienHe'
]);

Route::get('about',[
    'as' =>'about',
    'uses'=>'PageController@getAbout'
]);

Route::get('dat-hang',[
    'as' =>'dathang',
    'uses'=>'PageController@getCheckout'
]);

Route::get('add-to-cart/{id}',[
    'as' =>'themgiohang',
    'uses'=>'PageController@getAddtoCart'
]);

Route::get('del-cart/{id}',[
    'as' =>'xoagiohang',
    'uses'=>'PageController@getDeltemCart'
]);

Route::post('dat-hang',[
    'as'=>'dathang',
    'uses'=>'PageController@postCheckout'
]);

Route::get('dang-nhap',[
    'as' =>'login',
    'uses'=>'PageController@getLogin'
]);

Route::post('dang-nhap',[
    'as' =>'login',
    'uses'=>'PageController@postLogin'
]);

Route::get('dang-ki',[
    'as' =>'signin',
    'uses'=>'PageController@getSignup'
]);

Route::post('dang-ki',[
    'as' =>'signin',
    'uses'=>'PageController@postSignup'
]);

Route::get('dang-xuat',[
    'as'=>'logout',
    'uses'=>'PageController@postLogout'
]);

Route::get('search',[
    'as'=>'search',
    'uses'=>'PageController@getSearch'
]);

Route::get('test',function(){
    return view('test');
});