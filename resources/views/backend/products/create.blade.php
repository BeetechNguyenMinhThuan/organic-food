@extends('backend.layouts.master')
@section('addJs')
    @include('backend.products.components.script.script')
    @include('backend.products.components.script.functions')
    @include('backend.products.components.script.function_ajax')
    @include('backend.products.components.script.actions')
@endsection
@section('content')
    <form method="post" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-9">
                <div class="content-header">
                    <h2 class="content-title">Add New Product</h2>
                    <div>
                        <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>
                        <button class="btn btn-md rounded font-sm hover-up">Create</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Basic</h4>
                    </div>
                    <div class="card-body">
                        <div>
                           <div class="row">
                               <div class="mb-4 col-xl-6">
                                   <label for="product_name" class="form-label">Product title</label>
                                   <input name="name" type="text" placeholder="Type here" class="form-control"
                                          id="product_name"/>
                               </div>
                               <div class="mb-4 col-xl-6">
                                   <label for="product_sku" class="form-label">Product Sku</label>
                                   <input name="sku" type="text" placeholder="Type here" class="form-control"
                                          id="product_sku"/>
                               </div>
                           </div>
                            <div class="mb-4">
                                <label class="form-label">Full description</label>
                                <textarea name="description" placeholder="Type here" class="form-control tinymce5"
                                          rows="4"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label class="form-label">Regular price</label>
                                        <div class="row gx-2">
                                            <input name="price" placeholder="$" type="text" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label class="form-label">Promotional price</label>
                                        <input name="sale_price" placeholder="$" type="text" class="form-control"/>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label class="form-label">Stock</label>
                                        <input name="stock" placeholder="" type="number" class="form-control"/>
                                    </div>
                                </div>

                            </div>
                            <label class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" value=""/>
                                <span class="form-check-label"> Make a template </span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- card end// -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Shipping</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Width</label>
                                        <input type="text" placeholder="inch" class="form-control" id="product_name"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label for="product_name" class="form-label">Height</label>
                                        <input type="text" placeholder="inch" class="form-control" id="product_name"/>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="product_name" class="form-label">Weight</label>
                                <input type="text" placeholder="gam" class="form-control" id="product_name"/>
                            </div>
                            <div class="mb-4">
                                <label for="product_name" class="form-label">Shipping fees</label>
                                <input type="text" placeholder="$" class="form-control" id="product_name"/>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- card end// -->
            </div>
            <div class="col-lg-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Media</h4>
                    </div>
                    <div class="card-body">
                        <div class="input-upload">
                            <img class="img-product" src="{{asset('backend/assets/imgs/theme/upload.svg')}}" alt=""/>
                            <input name="avatar" class="form-control avatar" type="file"/>
                        </div>
                    </div>
                </div>
                <!-- card end// -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Organization</h4>
                    </div>
                    <div class="card-body">
                        <div class="row gx-2">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select select2-base">
                                    {!! $htmlOption !!}
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="product_name" class="form-label">Tags</label>
                                <select name="tag_id[]" class="form-control select2-multi-tag" multiple>
                                    <option selected="selected">orange</option>
                                    <option>white</option>
                                    <option selected="selected">purple</option>
                                </select>
                            </div>
                        </div>
                        <!-- row.// -->
                    </div>
                </div>
                <!-- card end// -->
            </div>
        </div>
    </form>

@endsection
