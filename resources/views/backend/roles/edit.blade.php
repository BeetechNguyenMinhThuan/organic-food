@extends('backend.layouts.master')
@section('addJs')
    @include('backend.roles.components.script.script')
    @include('backend.roles.components.script.functions')
    @include('backend.roles.components.script.function_ajax')
    @include('backend.roles.components.script.actions')
@endsection
@section('content')
    @include('backend.roles.components.partials.form', [
    'action'=>route('admin.roles.update',['id'=>$role->id]),
    'method'=>'PUT',
    'setting' => $role,
    'title' => 'Edit Setting',
    ])

@endsection
