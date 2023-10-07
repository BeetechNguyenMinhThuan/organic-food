@extends('backend.layouts.master')
@section('addJs')
    @include('backend.roles.components.script.script')
    @include('backend.roles.components.script.functions')
    @include('backend.roles.components.script.function_ajax')
    @include('backend.roles.components.script.actions')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ol>
                </div>
                <h4 class="page-title">Add New Role</h4>
            </div>
        </div>
    </div>
    @include('backend.roles.components.partials.form', ['action'=>route('admin.roles.store'),'title'=> 'Add New Role'])
@endsection
