@extends('backend.layouts.master')
@section('addJs')
    @include('backend.warehouse.components.script.script')
    @include('backend.warehouse.components.script.functions')
    @include('backend.warehouse.components.script.function_ajax')
    @include('backend.warehouse.components.script.actions')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Warehouse</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Warehouse</h4>
            </div>
        </div>
    </div>
    @include('backend.warehouse.components.partials.form', [
      'action'=>route('admin.warehouse.update',['id'=>$product->id]),
      'method'=>'PUT',
      'product' => $product,
      'title' => 'Edit Warehouse',
      ])
@endsection
