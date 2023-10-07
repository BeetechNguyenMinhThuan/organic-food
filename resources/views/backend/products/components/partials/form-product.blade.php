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
                                    <label for="product_name" class="col-form-label">Product title <sup
                                            style="color: red">*</sup></label>
                                    <input name="name" type="text" placeholder="Type here"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="product_name"
                                           value="{{ old('name') ? old('name') : (isset($product->name) ? $product->name : '') }}"/>
                                    @error('name')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="product_sku" class="col-form-label">Product Sku <sup style="color: red">*</sup></label>
                                    <input name="sku" type="text" placeholder="Type here"
                                           class="form-control @error('sku') is-invalid @enderror"
                                           id="product_sku"
                                           value="{{ old('sku') ? old('sku') : (isset($product->sku) ? $product->sku : '') }}"/>
                                    @error('sku')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="col-form-label">Regular price <sup style="color: red">*</sup></label>
                                    <input
                                        value="{{ old('price') ? old('price') : (isset($product->price) ? $product->price : '') }}"
                                        name="price" placeholder="$" type="text"
                                        class="form-control @error('price') is-invalid @enderror"/>
                                    @error('price')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
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
                                         src="{{isset($product) ? \App\Helpers\Common::getImage($product->avatar) : asset('backend/assets/images/upload.svg')}}"
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

</form>
