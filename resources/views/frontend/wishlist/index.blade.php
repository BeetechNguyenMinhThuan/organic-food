@extends('frontend.layouts.master')
@section('modal')
    {{--    @include('frontend.partials.modal-pre-load')--}}
@endsection
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop <span></span> Fillter
            </div>
        </div>
    </div>
    <div class="container mb-30 mt-50">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <div class="mb-50">
                    <h1 class="heading-2 mb-10">Your Wishlist</h1>
                    <h6 class="text-body">There are <span class="text-brand">5</span> products in this list</h6>
                </div>
                <div class="table-responsive shopping-summery">
                    <table class="table table-wishlist">
                        <thead>
                        <tr class="main-heading">
                            <th class="custome-checkbox start pl-30">
                                <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11"
                                       value=""/>
                                <label class="form-check-label" for="exampleCheckbox11"></label>
                            </th>
                            <th scope="col" colspan="2">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock Status</th>
                            <th scope="col">Action</th>
                            <th scope="col" class="end">Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productsFavorite as $product)
                            <tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    <input class="form-check-input" type="checkbox" name="checkbox"
                                           id="exampleCheckbox1" value=""/>
                                    <label class="form-check-label" for="exampleCheckbox1"></label>
                                </td>
                                <td class="image product-thumbnail pt-40"><img
                                        src="{{asset('/storage/'.$product->avatar)}}" alt="#"/></td>
                                <td class="product-des product-name">
                                    <h6><a class="product-name mb-10"
                                           href="{{route('products.detail',['name'=>$product->slug])}}">{{$product->name}}
                                            / {{$product->weight}}</a></h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h3 class="text-brand">{!! $product->formatPrice() !!}</h3>
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                    @if($product->stock)
                                        <span class="stock-status in-stock mb-0"> In Stock </span>
                                    @else
                                        <span class="stock-status text-white bg-danger in-stock mb-0"> Not Stock </span>
                                    @endif
                                </td>
                                <td class="text-right" data-title="Cart">
                                    @if($product->stock)
                                        <button data-url="{{ route('cart.add',['productId'=>$product->id])}}"
                                                class="btn btn-sm button-add-to-cart">Add to cart
                                        </button>
                                    @endif
                                </td>
                                <td class="action text-center" data-title="Remove">
                                    <a data-url="{{route('products.remove.favorite',$product->id)}}" href="#"
                                       class="text-body action-removeFavorite"><i class="fi-rs-trash"></i></a>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('addJs')
@endsection
