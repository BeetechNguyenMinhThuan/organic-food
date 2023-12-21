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
                <h4 class="page-title">Lịch sử truy cập</h4>
            </div>
        </div>
    </div>
    @if(isset($data) && count($data) > 0 )
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
                                    <th>Người truy cập</th>
                                    <th>Địa chỉ IP</th>
                                    <th>Quốc gia</th>
                                    <th>Trình duyệt</th>
                                    <th>Thiết bị</th>
                                    <th>Nền tảng</th>
                                    <th>Ngày truy cập</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $index => $item)
                                    <tr>
                                        <td>{{$index + $data->firstItem() }}</td>
                                       <td>
                                           <ul>
                                               <li>{{$item->user->fullname}}</li>
                                               <li>{{$item->user->email}}</li>
                                           </ul>
                                       </td>
                                        <td>{{$item->ip_address }}</td>
                                        <td>{{$item->country_name }}</td>
                                        <td>{{$item->browser }}</td>
                                        <td>{{$item->device }}</td>
                                        <td>{{$item->platform }}</td>
                                        <td>{{$item->created_at }}</td>

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

@stop
@section('addJs')
@endsection
