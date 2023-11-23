@extends('backend.layouts.master')
@section('addJs')
    @include('backend.account-admins.components.script.script')
    @include('backend.account-admins.components.script.functions')
    @include('backend.account-admins.components.script.function_ajax')
    @include('backend.account-admins.components.script.actions')
@endsection
@section('content')
    @include('backend.account-admins.components.partials.form', [
    'action'=>route('admin.account-admins.update',['id'=>$user->id]),
    'method'=>'PUT',
    'user' => $user,
    'title' => 'Edit User',
    ])

@endsection
