<form method="POST" action="{{ $action }}" enctype="multipart/form-data"
      data-plugin="dropzone" data-previews-container="#file-previews"
      data-upload-preview-template="#uploadPreviewTemplate">
    @if(isset($method))
        @method($method)
    @endif
    @csrf
    <div class="row mb-3">
        <div class="col-12">
            <button type="submit" class="btn btn-success">{{trans('messages.save')}}</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="product_name" class="col-form-label">Product title</label>
                                    <input name="name" type="text" placeholder="Type here" class="form-control"
                                           id="product_name"
                                           value="{{ old('name') ? old('name') : (isset($product->name) ? $product->name : '') }}"/>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="product_sku" class="col-form-label">Product Sku</label>
                                    <input name="sku" type="text" placeholder="Type here" class="form-control"
                                           id="product_sku"
                                           value="{{ old('sku') ? old('sku') : (isset($product->sku) ? $product->sku : '') }}"/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="col-form-label">Regular price</label>
                                    <input
                                        value="{{ old('price') ? old('price') : (isset($product->price) ? $product->price : '') }}"
                                        name="price" placeholder="$" type="text" class="form-control"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="col-form-label">Promotional price</label>
                                    <input
                                        value="{{ old('sale_price') ? old('sale_price') : (isset($product->sale_price) ? $product->sale_price : '') }}"
                                        name="sale_price" placeholder="$" type="text" class="form-control"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="col-form-label">Stock</label>
                                    <input
                                        value="{{ old('stock') ? old('stock') : (isset($product->stock) ? $product->stock : '') }}"
                                        name="stock" placeholder="" type="number" class="form-control"/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label">Category</label>
                                    <select name="category_id" class="form-control select2-base" data-toggle="select2">
                                        {!! $htmlOption !!}
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    @php
                                        $choose_tags = old('tags') ? old('tags') : (isset($product->tags )?$product->tags->pluck('id'):collect());
                                    @endphp
                                    <label for="product_name" class="col-form-label">Tags</label>
                                    <select name="tags[]" class="form-control select2-multi-tag" multiple
                                            data-placeholder="Choose ...">
                                        @foreach($tags as $tag)
                                            <option
                                                value="{{$tag->name}}" {{ $choose_tags->contains($tag->id) ?'selected':'' }} >{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Full description</label>
                                <textarea name="description" placeholder="Type here" class="form-control tinymce5"
                                          rows="4">{{ old('description') ? old('description') : (isset($product->description) ? $product->description : '') }}</textarea>
                            </div>


                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="form-group col-md-6">
                                <label class="col-form-label">Ảnh đại diện</label>
                                <div class="">
                                    <img class="img-product d-flex" style="margin: 0 auto" height="250px"
                                         src="{{isset($product) ? $product->avatar : asset('backend/assets/images/upload.svg')}}"
                                         alt=""/>
                                    <div class="input-group mt-2">
                                        <div class="custom-file">
                                            <input name="avatar" type="file" class="custom-file-input avatar"
                                                   id="inputGroupFile04">
                                            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="col-form-label">Ảnh chi tiết</label>
                                <div class="dropzone" id="myAwesomeDropzone">
                                    <div class="fallback">
                                        <input name="image_path[]" type="file" class="img-product-detail" multiple/>
                                    </div>

                                    <div class="dz-message needsclick">
                                        <i class="h1 text-muted dripicons-cloud-upload"></i>
                                        <h3>Drop files here or click to upload.</h3>
                                        <span class="text-muted font-13">(This is just a demo dropzone. Selected files are
            <strong>not</strong> actually uploaded.)</span>
                                    </div>

                                    <div class="dropzone-previews mt-3" id="file-previews"></div>

                                    <!-- file preview template -->
                                    <div class="d-none" id="uploadPreviewTemplate">
                                        <div class="card mt-1 mb-0 shadow-none border">
                                            <div class="p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <img data-dz-thumbnail src="#"
                                                             class="avatar-sm rounded bg-light"
                                                             alt="">
                                                    </div>
                                                    <div class="col pl-0">
                                                        <a href="javascript:void(0);"
                                                           class="text-muted font-weight-bold"
                                                           data-dz-name></a>
                                                        <p class="mb-0" data-dz-size></p>
                                                    </div>
                                                    <div class="col-auto">
                                                        <!-- Button -->
                                                        <a href="" class="btn btn-link btn-lg text-muted"
                                                           data-dz-remove>
                                                            <i class="dripicons-cross"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>


{{--    <div class="row">--}}
{{--        <div class="col-9">--}}
{{--            <div class="content-header">--}}
{{--                <h2 class="content-title">{{ $title }}</h2>--}}
{{--                <div>--}}
{{--                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>--}}
{{--                    <button class="btn btn-md rounded font-sm hover-up">{{trans('messages.save')}}</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-6">--}}
{{--            <div class="card mb-4">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>Basic</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="mb-4 col-xl-6">--}}
{{--                                <label for="product_name" class="form-label">Product title</label>--}}
{{--                                <input name="name" type="text" placeholder="Type here" class="form-control"--}}
{{--                                       id="product_name"--}}
{{--                                       value="{{ old('name') ? old('name') : (isset($product->name) ? $product->name : '') }}"/>--}}
{{--                            </div>--}}
{{--                            <div class="mb-4 col-xl-6">--}}
{{--                                <label for="product_sku" class="form-label">Product Sku</label>--}}
{{--                                <input name="sku" type="text" placeholder="Type here" class="form-control"--}}
{{--                                       id="product_sku"--}}
{{--                                       value="{{ old('sku') ? old('sku') : (isset($product->sku) ? $product->sku : '') }}"/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="mb-4">--}}
{{--                            <label class="form-label">Full description</label>--}}
{{--                            <textarea name="description" placeholder="Type here" class="form-control tinymce5"--}}
{{--                                      rows="4">{{ old('description') ? old('description') : (isset($product->description) ? $product->description : '') }}</textarea>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-4">--}}
{{--                                <div class="mb-4">--}}
{{--                                    <label class="form-label">Regular price</label>--}}
{{--                                    <div class="row gx-2">--}}
{{--                                        <input--}}
{{--                                            value="{{ old('price') ? old('price') : (isset($product->price) ? $product->price : '') }}"--}}
{{--                                            name="price" placeholder="$" type="text" class="form-control"/>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-4">--}}
{{--                                <div class="mb-4">--}}
{{--                                    <label class="form-label">Promotional price</label>--}}
{{--                                    <input--}}
{{--                                        value="{{ old('sale_price') ? old('sale_price') : (isset($product->sale_price) ? $product->sale_price : '') }}"--}}
{{--                                        name="sale_price" placeholder="$" type="text" class="form-control"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-lg-4">--}}
{{--                                <div class="mb-4">--}}
{{--                                    <label class="form-label">Stock</label>--}}
{{--                                    <input--}}
{{--                                        value="{{ old('stock') ? old('stock') : (isset($product->stock) ? $product->stock : '') }}"--}}
{{--                                        name="stock" placeholder="" type="number" class="form-control"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                        <label class="form-check mb-4">--}}
{{--                            <input class="form-check-input" type="checkbox" value=""/>--}}
{{--                            <span class="form-check-label"> Make a template </span>--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- card end// -->--}}
{{--            <div class="card mb-4">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>Shipping</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <form>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-6">--}}
{{--                                <div class="mb-4">--}}
{{--                                    <label for="product_name" class="form-label">Width</label>--}}
{{--                                    <input type="text" placeholder="inch" class="form-control" id="product_name"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-6">--}}
{{--                                <div class="mb-4">--}}
{{--                                    <label for="product_name" class="form-label">Height</label>--}}
{{--                                    <input type="text" placeholder="inch" class="form-control" id="product_name"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="mb-4">--}}
{{--                            <label for="product_name" class="form-label">Weight</label>--}}
{{--                            <input type="text" placeholder="gam" class="form-control" id="product_name"/>--}}
{{--                        </div>--}}
{{--                        <div class="mb-4">--}}
{{--                            <label for="product_name" class="form-label">Shipping fees</label>--}}
{{--                            <input type="text" placeholder="$" class="form-control" id="product_name"/>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- card end// -->--}}
{{--        </div>--}}
{{--        <div class="col-lg-3">--}}
{{--            <div class="card mb-4">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>Ảnh đại diện</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="input-upload">--}}
{{--                        <img class="img-product"--}}
{{--                             src="{{isset($product) ? $product->avatar : asset('backend/assets/imgs/theme/upload.svg')}}"--}}
{{--                             alt=""/>--}}
{{--                        <input name="avatar" class="form-control avatar" type="file"/>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- card end// -->--}}
{{--            <div class="card mb-4">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>Ảnh chi tiết</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        @php--}}
{{--                            if (isset($product)){--}}
{{--                                $imageDetail = [];--}}
{{--                                $productImages = $product->images;--}}
{{--                                foreach($productImages as $images){--}}
{{--                                    $imageDetail[] = \App\Models\Image::query()->where('id',$images->id)->first();--}}
{{--                                }--}}
{{--                            }--}}
{{--                        @endphp--}}
{{--                        @if(isset($imageDetail))--}}
{{--                            @foreach( $imageDetail as $imageItem)--}}
{{--                                <div class="col-md-12 col-lg-12 col-xl-4">--}}
{{--                                    <div class="input-upload">--}}
{{--                                        <img class="img-product-detail"--}}
{{--                                             src="{{ !empty($imageItem->image_path) ? $imageItem->image_path :  asset('backend/assets/imgs/theme/upload.svg')}}"--}}
{{--                                             alt=""/>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                        <input name="image_path[]" multiple class="form-control img-product-detail" type="file"/>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- card end// -->--}}
{{--            <div class="card mb-4">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>Organization</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row gx-2">--}}
{{--                        <div class="col-md-12 mb-3">--}}
{{--                            <label class="form-label">Category</label>--}}
{{--                            <select name="category_id" class="form-select select2-base">--}}
{{--                                {!! $htmlOption !!}--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="mb-4">--}}
{{--                            @php--}}
{{--                                $choose_tags = old('tags') ? old('tags') : (isset($product->tags )?$product->tags->pluck('id'):collect());--}}
{{--                            @endphp--}}
{{--                            <label for="product_name" class="form-label">Tags</label>--}}
{{--                            <select name="tags[]" class="form-control select2-multi-tag" multiple>--}}
{{--                                @foreach($tags as $tag)--}}
{{--                                    <option--}}
{{--                                        value="{{$tag->name}}" {{ $choose_tags->contains($tag->id) ?'selected':'' }} >{{$tag->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- row.// -->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- card end// -->--}}
{{--        </div>--}}
{{--    </div>--}}
</form>
