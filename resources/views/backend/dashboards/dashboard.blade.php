@extends('backend.layouts.master')
@section('content')
    <div class="content-header p-3">
        <div>
            <h2 class="content-title card-title">Dashboard</h2>
            <p>Whole data about your business here</p>
        </div>
        <div>
            <a href="#" class="btn btn-primary"><i class="text-muted material-icons md-post_add"></i>Create report</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light"><i
                            class="text-primary material-icons md-monetization_on"></i></span>
                    <div class="text">
                        <h3 class="mb-1 card-title">Total Price</h3>
                        <h4>{!! \App\Helpers\Common::getFormatNumberPrice($order->sum('total_price')) !!}</h4>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light"><i
                            class="text-success material-icons md-local_shipping"></i></span>
                    <div class="text">
                        <h3 class="mb-1 card-title">Orders</h3>
                        <h4>{{$order->count()}}</h4>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i
                            class="text-warning material-icons md-qr_code"></i></span>
                    <div class="text">
                        <h3 class="mb-1 card-title">Products</h3>
                        <h4 class="d-inline">{{$products->count()}}</h4>
                        <h4 class="d-inline text-sm"> In {{$categories->count()}} Categories </h4>
                    </div>
                </article>
            </div>
        </div>
{{--        <div class="col-lg-3">--}}
{{--            <div class="card card-body mb-4">--}}
{{--                <article class="icontext">--}}
{{--                    <span class="icon icon-sm rounded-circle bg-info-light"><i--}}
{{--                            class="text-info material-icons md-shopping_basket"></i></span>--}}
{{--                    <div class="text">--}}
{{--                        <h6 class="mb-1 card-title">Monthly Earning</h6>--}}
{{--                        <span>$6,982</span>--}}
{{--                        <span class="text-sm"> Based in your local time. </span>--}}
{{--                    </div>--}}
{{--                </article>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    <section class="statistics">
        <div class="row">
            <div class="col-lg-6">
                <div id="statistics-user"></div>
            </div>
        </div>
    </section>
@endsection
@section('js_library')
    @include('common.partials.script-library', [
        'highcharts' => true,
    ])
@stop
@section('addJs')
    @include('backend.dashboards.components.script.script')
@endsection
