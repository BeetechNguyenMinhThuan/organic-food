@extends('backend.layouts.master')
@section('addJs')
    @include('backend.permissions.components.script.script')
    @include('backend.permissions.components.script.functions')
    @include('backend.permissions.components.script.function_ajax')
    @include('backend.permissions.components.script.actions')
@endsection
@section('content')
    @include('backend.permissions.components.partials.form', [
    'action'=>route('admin.permissions.update',['id'=>$permission->id]),
    'method'=>'PUT',
    'setting' => $permission,
    'title' => 'Edit Permission',
    ])

@endsection
