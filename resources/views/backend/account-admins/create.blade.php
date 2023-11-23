@extends('backend.layouts.master')
@section('addJs')
    @include('backend.account-admins.components.script.script')
    @include('backend.account-admins.components.script.functions')
    @include('backend.account-admins.components.script.function_ajax')
    @include('backend.account-admins.components.script.actions')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Admins</li>
                    </ol>
                </div>
                <h4 class="page-title">Add New Admin</h4>
            </div>
        </div>
    </div>
    @include('backend.account-admins.components.partials.form', ['action'=>route('admin.account-admins.store'),'title'=> 'Add New Admin'])
@endsection
