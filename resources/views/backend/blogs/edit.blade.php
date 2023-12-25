@extends('backend.layouts.master')
@section('addJs')
    @include('backend.blogs.components.script.script')
    @include('backend.blogs.components.script.functions')
    @include('backend.blogs.components.script.function_ajax')
    @include('backend.blogs.components.script.actions')
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
                <h4 class="page-title">Edit Blog</h4>
            </div>
        </div>
    </div>
    @include('backend.blogs.components.partials.form', [
      'action'=>route('admin.blogs.update',['id'=>$blog->id]),
      'method'=>'PUT',
      'blog' => $blog,
      'title' => 'Edit Blog',
      ])
@endsection
