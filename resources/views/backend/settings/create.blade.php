@extends('backend.layouts.master')
@section('addJs')
    @include('backend.settings.components.script.script')
    @include('backend.settings.components.script.functions')
    @include('backend.settings.components.script.function_ajax')
    @include('backend.settings.components.script.actions')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Add New Setting</h4>
            </div>
        </div>
    </div>
    @include('backend.settings.components.partials.form', ['action'=>route('admin.settings.store'),'title'=> 'Add New Setting'])
@endsection
