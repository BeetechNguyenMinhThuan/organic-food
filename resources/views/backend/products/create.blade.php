@extends('backend.layouts.master')
@section('addJs')
    @include('backend.products.components.script.script')
    @include('backend.products.components.script.functions')
    @include('backend.products.components.script.function_ajax')
    @include('backend.products.components.script.actions')
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
                <h4 class="page-title">Add New Product</h4>
            </div>
        </div>
    </div>
    @include('backend.products.components.partials.form-product', ['action'=>route('admin.products.store'),'title'=> 'Add New Product'])
@endsection
