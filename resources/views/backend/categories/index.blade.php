@extends('backend.layouts.master')
@section('addJs')
    <script type="text/javascript" src="{{ asset('backend/categories/categories.js') }}"></script>
@endsection
@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Categories</h2>
            <p>Add, edit or delete a category</p>
        </div>
        <div>
            <input type="text" placeholder="Search Categories" class="form-control bg-white"/>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                @include('backend.alerts.alert')
                <div class="col-md-3">
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Name</label>
                            <input name="name" type="text" placeholder="Type here" class="form-control"
                                   id="product_name"/>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Parent</label>
                            <select name="parent_id" class="form-select">
                                <option value="0">Danh mục cha</option>
                                {!! $htmlOption !!}
                            </select>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary">Create category</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""/>
                                    </div>
                                </th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Parent Category Name</th>
                                <th>Slug</th>
                                <th>Order</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""/>
                                        </div>
                                    </td>
                                    <td>{{$category->id}}</td>
                                    <td><b>{{ $category->name }}</b></td>
                                    <td><b>{{ $category->parent->name ?? "" }}</b></td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->sort_key }}</td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                               class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">View detail</a>
                                                <a class="dropdown-item" href="#">Edit info</a>
                                                <a data-url="{{route('admin.categories.destroy',['id'=>$category->id])}}" class="dropdown-item text-danger action_delete" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $categories->links() }}
                </div>
                <!-- .col// -->
            </div>
            <!-- .row // -->
        </div>
        <!-- card body .// -->
    </div>
@endsection
