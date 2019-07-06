@extends('master')
@section('content')
<div class="inner-header">
    <div class="container">
        <div class="pull-left">
        <h6 class="inner-title">Sản phẩm {{$sanpham->name}}</h6>
        </div>
        <div class="pull-right">
            <div class="beta-breadcrumb font-large">
             <a href="{{route('trang-chu')}}">Home</a> / <span>Thông tin sản phẩm</span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="container">
    <div id="content">
        <div class="row">
            <div class="col-sm-9">

                <div class="row">
                    <div class="col-sm-4">
                        <img src="source/image/product/{{  $sanpham->image}}" alt="">
                    </div>
                    <div class="col-sm-8">
                        <div class="single-item-body">
                            <p class="single-item-title"><h2>{{  $sanpham->name}}</h2></p>
                            <p class="single-item-price" style="font-size:18px">
                                @if($sanpham->promotion_price ==0)
                                <span class="flash-sale">{{number_format($sanpham->unit_price)}} đồng </span>
                                @else
                                <span class="flash-del">{{number_format($sanpham->unit_price)}} đồng</span>
                                <span class="flash-sale">{{number_format($sanpham->promotion_price)}} đồng</span>
                                @endif
                            </p>
                        </div>

                        <div class="clearfix"></div>
                        <div class="space20">&nbsp;</div>

                        <div class="single-item-desc">
                            <p>{{ $sanpham->description }}</p>
                        </div>
                        <div class="space20">&nbsp;</div>

                        <p>Số lượng</p>
                        <div class="single-item-options">
                            <select class="wc-select" name="color">
                                <option>Số lượng</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <a class="add-to-cart" href="#"><i class="fa fa-shopping-cart"></i></a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="space40">&nbsp;</div>
                <div class="woocommerce-tabs">
                    <ul class="tabs">
                        <li><a href="#tab-description">Mô tả</a></li>
                    </ul>

                    <div class="panel" id="tab-description">
                        <p>{{ $sanpham->description }}</p>
                      
                    </div>
                    <div class="panel" id="tab-reviews">
                        <p>No Reviews</p>
                    </div>
                </div>
                <div class="space50">&nbsp;</div>
                <div class="beta-products-list">
                    <h4>Sản phẩm tương tự</h4>
                    <div class="row">
                        @foreach($sp_tuongtu as $sptt)
                        <div class="col-sm-4">
                            <div class="single-item">
                                @if($sptt->promotion_price !=0)
                                <div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
                                @endif
                                <div class="single-item-header">
                                    <a href="product.html"><img src="source/image/product/{{ $sptt->image }}"height="250px" alt=""></a>
                                </div>
                                <div class="single-item-body">
                                    <p class="single-item-title">{{ $sptt->name }}</p>
                                    @if($sptt->promotion_price ==0)
                                    <span class="flash-sale">{{number_format($sptt->unit_price)}} đồng </span>
                                    @else
                                    <span class="flash-del">{{number_format($sptt->unit_price)}} đồng</span>
                                    <span class="flash-sale">{{number_format($sptt->promotion_price)}} đồng</span>
                                    @endif
                                </div>
                                <div class="single-item-caption">
                                    <a class="add-to-cart pull-left" href="product.html"><i class="fa fa-shopping-cart"></i></a>
                                    <a class="beta-btn primary" href="product.html">Details <i class="fa fa-chevron-right"></i></a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{-- <div class="row">{{ $sp_tuongtu->links() }}</div> --}}
                    </div>
                </div> <!-- .beta-products-list -->
            </div>
            <div class="col-sm-3 aside">
                <div class="widget">
                    <h3 class="widget-title">Sản phẩm bán chạy</h3>
                    @foreach($sp_banchay as $row)
                    <div class="widget-body">
                        <div class="beta-sales beta-lists">
                            <div class="media beta-sales-item">
                                <a class="pull-left" href="{{ route('chitietsanpham',$row->id) }}"><img src="source/image/product/{{$row->image}}" alt=""></a>
                                <div class="media-body">
                                        {{$row->name}}</br>
                                    @if($row->promotion_price == 0)
                                        <span class="beta-sales-price" style="font-size:16px;">{{ number_format($row->unit_price)}} đồng</span>
                                    @else        
                                        <span class="beta-sales-price" style="font-size:16px;">{{  number_format($row->promotion_price)}} đồng</span>
                                    @endif    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div> <!-- best sellers widget -->
                <div class="widget">
                    <h3 class="widget-title">Sản phẩm mới</h3>
                    <div class="widget-body">
                        <div class="beta-sales beta-lists">
                            @foreach($new_product as $new)
                            <div class="media beta-sales-item">
                                @if($new->promotion_price !=0)
                                <div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
                                @endif
                                <a class="pull-left" href="{{ route('chitietsanpham',$new->id) }}"><img src="source/image/product/{{$new->image}}" alt=""></a>
                                <div class="media-body">
                                        {{$new->name}}
                                    <span class="beta-sales-price">{{$new->unit_price}}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">{{$new_product->links()}}</div> 
                </div> <!-- best sellers widget -->
            </div>
        </div>
    </div> <!-- #content -->
</div> <!-- .container -->
@endsection