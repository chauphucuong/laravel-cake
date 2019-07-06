<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ProductType;
use App\Cart;
use Session;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('header',function($view){
            $loai_sp=ProductType::all();
            $view->with('loai_sp',$loai_sp);
        });
        view()->composer(['header','page.dat_hang'],function($view){
            // Kiểm tra có sản phẩm trong giỏ hàng không
            if(Session('cart')){
                // biến old sẽ lấy các giá trị hiên có trong giỏ hàng
                $cart =new Cart(Session::get('cart'));
                $view->with(['cart'=>Session::get('cart'),
                'product_cart'=>$cart->items, 'totalPrice'=>$cart->totalPrice,
                'totalQty'=>$cart->totalQty]);
            }
        });
    }   

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
