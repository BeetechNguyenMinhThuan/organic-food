@extends('backend.layouts.master')
@section('addJs')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Warehouse</li>
                    </ol>
                </div>
                <h4 class="page-title">Warehouse</h4>
            </div>
        </div>
    </div>

    @include('backend.warehouse.components.partials.list')

@endsection
