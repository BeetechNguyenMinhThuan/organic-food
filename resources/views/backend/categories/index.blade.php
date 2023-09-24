@extends('backend.layouts.master')
@section('addJs')
    <script type="text/javascript" src="{{ asset('backend/categories/categories.js') }}"></script>
    {{--    <script src="{{ asset('backend/assets/js/pages/demo.products.js')}}"></script>--}}

@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
                <h4 class="page-title">Category</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a
                                data-toggle="modal" data-target="#bs-example-modal-lg"
                                href="javascript:void(0);"
                                class="btn btn-danger mb-2"
                            ><i class="mdi mdi-plus-circle mr-2"></i> Add
                                Category</a
                            >
                            <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog"
                                 aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                ×
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('admin.categories.store') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input name="name" type="text" placeholder="Type here"
                                                           class="form-control"
                                                           id="name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Parent</label>
                                                    <select name="parent_id" class="form-control select2-base">
                                                        <option value="0">Danh mục cha</option>
                                                        {!! $htmlOption !!}
                                                    </select>
                                                </div>
                                                <div class="form-group text-right">
                                                    <button class="btn btn-primary"
                                                            type="submit">{{trans('messages.save')}}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                        </div>
                        <!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table table-centered w-100 dt-responsive nowrap"
                            id=""
                        >
                            <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Parent Category Name</th>
                                <th>Slug</th>
                                <th>Order</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $key => $category)
                                <tr>
                                    <td><b>{{ $category->name }}</b></td>
                                    <td><b>{{ $category->parent->name ?? "" }}</b></td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->sort_key }}</td>
                                    <td class="table-action">
                                        <a href="javascript:void(0);" class="action-icon">
                                            <i class="mdi mdi-eye"></i
                                            ></a>
                                        <a href="javascript:void(0);" class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i
                                            ></a>
                                        <a data-url="{{route('admin.categories.destroy',['id'=>$category->id])}}"
                                           href="javascript:void(0);" class="action-icon action_delete">
                                            <i class="mdi mdi-delete"></i
                                            ></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$categories->links()}}
                    </div>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->
    </div>

@endsection
