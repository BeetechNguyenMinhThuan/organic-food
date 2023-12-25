@extends('backend.layouts.master')
@section('addJs')
    @include('backend.products.components.script.script')
    @include('backend.products.components.script.functions')
    @include('backend.products.components.script.function_ajax')
    @include('backend.products.components.script.actions')
@endsection
@section('content')
    @include('backend.products.components.partials.form-product', [
    'action'=>route('admin.products.update',['id'=>$product->id]),
    'method'=>'PUT',
    'product' => $product,
    'title' => 'Edit Product',
    ])

@endsection
