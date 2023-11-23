@extends('backend.layouts.master')
@section('addJs')
    @include('backend.discounts.components.script.script')
    @include('backend.discounts.components.script.functions')
    @include('backend.discounts.components.script.function_ajax')
    @include('backend.discounts.components.script.actions')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Blogs</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Discount</h4>
            </div>
        </div>
    </div>
    @include('backend.discounts.components.partials.form', [
      'action'=>route('admin.discounts.update',['id'=>$discount->id]),
      'method'=>'PUT',
      'discount' => $discount,
      'title' => 'Edit Discount',
      ])
@endsection
