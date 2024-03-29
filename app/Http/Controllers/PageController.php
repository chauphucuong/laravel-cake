<?php

namespace App\Http\Controllers;
use App\Cart;
use Illuminate\Http\Request;
use App\Slide;
use App\Product;
use App\ProductType;
use App\Customer;
use App\Bill;
use App\BillDetail;
use App\User;
use Session;
use Hash;
use Auth;
use Illuminate\Foundation\Console\Presets\React;
class PageController extends Controller
{
    public function  getIndex(){
        $slide= Slide::all();
        //$new_product=  Product::where('new',1)->get();
        $new_product=  Product::where('new',1)->paginate(4);
        $sanpham_khuyenmai=  Product::where('promotion_price','<>',0)->paginate(8);
        //return view('page.trangchu',['slide'=> $slide]);
        return view('page.trangchu',compact('slide','new_product','sanpham_khuyenmai'));
    }
    public function  getLoaiSP($type){
        $sp_theoloai =  Product::where('id_type',$type)->get();
        $sp_khac=  Product::where('id_type','<>',$type)->paginate(3);
        $loai= ProductType::all();
        $loai_sp=ProductType::where('id',$type)->first();
        return view('page.loai_sanpham',compact('sp_theoloai','sp_khac','loai','loai_sp'));
    }
    
    public function  getChiTietSP(Request $req){
        $sanpham = Product::where('id',$req->id)->first();
        $sp_tuongtu=Product::where('id_type',$sanpham->id_type)->paginate(3);
        $new_product=  Product::where('new',1)->paginate(4);
        $all_sanpham=Product::all();
        $sp_banchay = array();
        foreach($all_sanpham as $sp)
        {
            if(BillDetail::where('id_product',$sp->id)->count() > 0)
                $sp_banchay[] = $sp;
        }
        //Code mẫu 
        //         $data =  \DB::table('error_reports')
        //         ->select(array('exception_type', \DB::raw('COUNT(*) as count')))
        //         ->orderBy('count', 'DESC')
        //         ->groupBy('exception_type')
        //         ->take(5)
        //         ->get();
        
        //   $data = collect($data)->map(function($x){ return (array) $x; })->toArray(); 

        //Lỗi raw không as được
        // $users = BillDetail::select(BillDetail::raw('id_product as user_count'))
        //              ->get();
        //

        //Query as
        //$a=BillDetail::select('id_product as count')->get();

        // $data = BillDetail::select(array('id_product', BillDetail::raw('id_product as count')))
        //     ->orderBy('count', 'DESC')
        //     ->groupBy('id_product')
        //     ->take(5)
        //     ->get();

        // $data1 = collect($data)->map(function($x){ return (array) $x; })->toArray(); 
        // $sp_banchay=Product::select('*')->take(5)->get()->toArray();
        return view('page.chitiet_sanpham',compact('sanpham','sp_tuongtu','new_product','sp_banchay'));
    }
    public function  getLienHe(){
        return view('page.lienhe');
    }
    public function  getAbout(){
        return view('page.about');
    }

    public function  getAddtoCart(Request $req,$id){
        $product = Product::find($id);
        //Biến oldCart kiểm tra xem có sản phẩm nào trong giỏ hàng chưa
        $oldCart = Session('cart') ? Session::get('cart'):null;
        //Biến Cart được gán với các giá trị trong giỏ hàng
        $cart=new Cart($oldCart);
        $cart->add($product,$id);   //chỉ add vào chưa lưu sản phẩm đó nên cần put
        $req->session()->put('cart',$cart); 
        return redirect()->back();
    }

    public function getDeltemCart($id){
        $oldCart = Session::has('cart') ? Session::get('cart'):null;
        $cart=new Cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items) > 0){
            Session::put('cart',$cart);
        }
        else{
            Session::forget('cart');
        }
        return redirect()->back();
    }
    
    public function getCheckout(){
        return view('page.dat_hang');
    }

    public function postCheckout(Request $req){
        $cart= Session::get('cart');
        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender =  $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes;
        $customer->save();

        $bill=  new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->notes;
        $bill->save();

        foreach($cart->items as $key =>$value)
        {
            $bill_detail =new BillDetail;
            $bill_detail->id_bill=$bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity= $value['qty'];
            $bill_detail->unit_price =($value['price']/$value['qty']);
            $bill_detail->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao','Đặt hàng thành công');
        
    }

    public function getLogin(){
        return view('page.dangnhap');
    }

    public function postLogin(Request $req){
        $this->validate($req,[
            'email'=>'required|email',
            'password'=>'required|min:6|max:20'
        ],[
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu ít nhất 6 kí tự',
            'password.max' =>'Mật khẩu không quá 20 kí tự'
        ]);
        $credentials  = array('email' => $req->email,'password' =>$req->password);
        if(Auth::attempt($credentials)){
            return redirect()->back()->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
        }
        else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
        }
    }
    public function getSignup(){
        return view('page.dangki');
    }


    public function postSignup(Request $req){
        $this->validate($req,[
            'email'  => 'required|email|unique:users,email',
            'password'  => 'required|min:6|max:20',
            'fullname'  => 'required',
            're_password'  => 'required|same:password',
        ],[
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Không đúng định dạng email',
            'email.unique'=>'Email đã có người sử dụng',
            'password.required'=>'Vui lòng nhập mật khẩu',
            're_password.same'=>'Mật khẩu không giống nhau',
            'password.min'=>'Mật khẩu ít nhất 6 kí tự'
        ]);
        $user =new User();
        $user->full_name =$req->fullname;
        $user->email =$req->email;
        $user->password =Hash::make($req->password);
        $user->phone =$req->phone;
        $user->address =$req->address;
        $user->save();
        return redirect()->back()->with('thongbao','Tạo tài khoản thành công');
    }

    public function postLogout(){
        Auth::logout();
        return redirect()->route('trang-chu');
    }

    public function getSearch(Request $req){
        $product = Product::where('name','like','%'.$req->key.'%')
                            ->orwhere('unit_price',$req->key)
                            ->get();
        return view('page.search',compact('product'));
    }
}
