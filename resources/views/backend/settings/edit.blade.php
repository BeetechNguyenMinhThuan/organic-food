@extends('backend.layouts.master')
@section('addJs')
    @include('backend.settings.components.script.script')
    @include('backend.settings.components.script.functions')
    @include('backend.settings.components.script.function_ajax')
    @include('backend.settings.components.script.actions')
@endsection
@section('content')
    @include('backend.settings.components.partials.form', [
    'action'=>route('admin.settings.update',['id'=>$setting->id]),
    'method'=>'PUT',
    'setting' => $setting,
    'title' => 'Edit Setting',
    ])

@endsection
