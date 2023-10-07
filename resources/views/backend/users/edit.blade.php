@extends('backend.layouts.master')
@section('addJs')
    @include('backend.users.components.script.script')
    @include('backend.users.components.script.functions')
    @include('backend.users.components.script.function_ajax')
    @include('backend.users.components.script.actions')
@endsection
@section('content')
    @include('backend.users.components.partials.form', [
    'action'=>route('admin.users.update',['id'=>$user->id]),
    'method'=>'PUT',
    'user' => $user,
    'title' => 'Edit User',
    ])

@endsection
