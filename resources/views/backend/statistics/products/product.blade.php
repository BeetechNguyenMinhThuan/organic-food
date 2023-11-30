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
                <h4 class="page-title">Thống kê Sản phẩm</h4>
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
                    <form action="{{route('admin.statistic.product')}}" method="GET" class="form-filter">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-date">Từ ngày</label>
                                    <input value="{{!empty(request()->start_at) ? request()->start_at : "" }}"
                                           placeholder="Từ ngày" data-picker="date-picker-date" class="form-control"
                                           id="example-month" type="text" name="start_at">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-date">Đến ngày</label>
                                    <input value="{{!empty(request()->end_at) ? request()->end_at : "" }}"
                                           placeholder="Đến ngày" data-picker="date-picker-date" class="form-control"
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
                                    <a href="{{route('admin.statistic.product')}}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @if(isset($products) && count($products) > 0 )
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table table-centered w-100 dt-responsive nowrap"
                                id=""
                            >
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng đã bán</th>
                                    <th>Xem những khách hàng đã mua</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $index => $product)
                                    <tr>
                                        <td>{{$index + $products->firstItem() }}</td>
                                        <td>
                                            <img
                                                src="{{ \App\Helpers\Common::getImage($product->avatar)}}"
                                                alt="contact-img"
                                                title="contact-img"
                                                class="rounded mr-3"
                                                height="48"
                                            /><span>{{$product->name}}</span>
                                        </td>
                                        <td>{{$product->total_sold}}</td>
                                        <td class="table-action">
                                            <a data-toggle="modal" data-target="#primary-header-modal"
                                               data-product-id="{{$product->id}}" href="javascript:void(0);"
                                               class="action-icon view-customer">
                                                <i class="mdi mdi-eye"></i
                                                ></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->

            {{--            MODAL--}}
            <div id="primary-header-modal" class="modal fade" tabindex="-1" role="dialog"
                 aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header modal-colored-header bg-primary">
                            <h4 class="modal-title" id="primary-header-modalLabel">Danh sách khách hàng đã mua sản
                                phẩm</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    @else
        @include('backend.partials.no-data-found')
    @endif

@endsection
@section('js_library')
    @include('common.partials.script-library', [
        'highcharts' => true,
         'datepicker' => true,
        'datetimepicker' => true,
    ])
@stop
@section('addJs')
    @include('backend.statistics.products.components.script.script')
    <script type="module" src="{{asset('backend/statistics/statistic.js')}}"></script>
@endsection
