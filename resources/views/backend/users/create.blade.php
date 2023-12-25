@extends('backend.layouts.master')
@section('addJs')
    @include('backend.users.components.script.script')
    @include('backend.users.components.script.functions')
    @include('backend.users.components.script.function_ajax')
    @include('backend.users.components.script.actions')
@endsection
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
                <h4 class="page-title">Add New User</h4>
            </div>
        </div>
    </div>
    @include('backend.users.components.partials.form', ['action'=>route('admin.users.store'),'title'=> 'Add New User'])
@endsection
