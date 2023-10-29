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
                                data-toggle="modal" data-target="#modalCategoryManager"
                                href="javascript:void(0);"
                                class="btn btn-danger mb-2"
                            ><i class="mdi mdi-plus-circle mr-2"></i> Add
                                Category</a
                            >
                            @include('backend.categories.modal',[
                                'idModal' => 'modalCategoryManager',
                                'category'=>null,
                                'route' => route('admin.categories.store'),
                                'title'=> "Add category"
                            ])

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
                                        <a href="javascript:void(0);" class="action-icon" data-toggle="modal"
                                           data-target="{{"#modalCategoryManager".$category->id}}">
                                            <i class="mdi mdi-square-edit-outline"></i
                                            ></a>
                                        <a data-url="{{route('admin.categories.destroy',['id'=>$category->id])}}"
                                           href="javascript:void(0);" class="action-icon action_delete">
                                            <i class="mdi mdi-delete"></i
                                            ></a>
                                    </td>
                                    @include('backend.categories.modal',[
                                           'idModal' => 'modalCategoryManager'.$category->id,
                                           'category'=>$category,
                                           'route' => route('admin.categories.update',['id'=>$category->id]),
                                           'title'=> "Edit category"
                                       ])
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
