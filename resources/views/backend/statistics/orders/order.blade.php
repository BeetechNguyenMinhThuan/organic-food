@extends('backend.layouts.master')
@section('css_library')
    @include('common.partials.style-library', ['datepicker' => true, 'clockpicker' => true])
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
                <h4 class="page-title">Thống kê đơn hàng</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <p>
                <a class="btn btn-primary" data-toggle="collapse"
                   href="#collapseExample" aria-expanded="false"
                   aria-controls="collapseExample">
                    Lọc
                </a>
            </p>
            <div class="collapse show" id="collapseExample">
                <div class="card card-body mb-0">
                    <form class="form-filter">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input value="{{!empty(request()->start_at) ? request()->start_at : "" }}"
                                           placeholder="Từ tháng" data-monthpicker="date-picker-month"
                                           class="form-control"
                                           id="example-month" type="text" name="start_at">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input value="{{!empty(request()->end_at) ? request()->end_at : "" }}"
                                           placeholder="Đến tháng" data-monthpicker="date-picker-month"
                                           class="form-control"
                                           id="example-month" type="text" name="end_at">
                                </div>
                            </div>
                        </div>
                        <div class="action">
                            <div class="row" style="justify-content: flex-end;gap: 20px">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Lọc</button>
                                </div>
                                <div class="text-right">
                                    <a href="{{route('admin.statistic.order')}}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section class="statistics-orders">
        <div class="row">
            <div class="col-12">
                <div id="statistics-orders"></div>
            </div>
            {{--            <div class="col-12">--}}
            {{--                <div id="statistics-orders-revenue"></div>--}}
            {{--            </div>--}}
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <p>
                <a class="btn btn-primary" data-toggle="collapse"
                   href="#collapseExample1" aria-expanded="false"
                   aria-controls="collapseExample">
                    Lọc
                </a>
            </p>
            <div class="collapse show" id="collapseExample1">
                <div class="card card-body mb-0">
                    <form class="form-filter">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input
                                        value="{{!empty(request()->revenue_start_at) ? request()->revenue_start_at : "" }}"
                                        placeholder="Từ ngày" data-picker="date-picker-date"
                                        class="form-control"
                                        id="example-month" type="text" name="revenue_start_at">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input
                                        value="{{!empty(request()->revenue_end_at) ? request()->revenue_end_at : "" }}"
                                        placeholder="Đến ngày" data-picker="date-picker-date"
                                        class="form-control"
                                        id="example-month" type="text" name="revenue_end_at">
                                </div>
                            </div>
                        </div>
                        <div class="action">
                            <div class="row" style="justify-content: flex-end;gap: 20px">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Lọc</button>
                                </div>
                                <div class="text-right">
                                    <a href="{{route('admin.statistic.order')}}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section class="statistics-revenue">
        <div class="row">
            <div class="col-12">
                <div id="statistics-orders-revenue"></div>
            </div>
        </div>
    </section>
@endsection
@section('js_library')
    @include('common.partials.script-library', [
        'highcharts' => true,
         'datepicker' => true,
        'datetimepicker' => true,
    ])
@stop
@section('addJs')
    @include('backend.statistics.orders.components.script.script')
    <script type="module" src="{{asset('backend/statistics/statistic.js')}}"></script>
@endsection
