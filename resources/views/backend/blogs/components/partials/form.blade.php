<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @if(isset($method))
        @method($method)
    @endif
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="simpleinput">Title</label>
                                <input value="{{ old('title') ? old('title') : (isset($blog->title) ? $blog->title : '') }}" type="text" name="title" id="simpleinput" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Description</label>
                                <textarea name="description" placeholder="Type here" class="form-control tinymce5"
                                          rows="4">{{ old('description') ? old('description') : (isset($blog->description) ? $blog->description : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    @if(isset($method) && $method == "PUT")
                        <h3 class="card-title">
                            Update
                        </h3>
                    @else
                        <h3 class="card-title">
                            Create
                        </h3>
                    @endif

                </div>
                <div class="card-body">
                    <button type="submit" name="btnSubmit" value="save" class="btn btn-primary submit btnCreate">
                        <i class="mdi mdi-content-save-edit-outline"></i>
                        Lưu
                    </button>
                    <input name="router" type="hidden" value="" id="router">

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Status
                    </h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="example-select">Input Select</label>
                        <select class="form-control" id="example-select" name="status">
                            <option value="1">Active</option>
                            <option value="">Hidden</option>
                        </select>
                    </div>

                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Thumbnail
                    </h3>
                </div>
                <div class="card-body parent-thumbnail">
                    <div class="form-group">
                        <input name="thumbnail" type="file" id="example-fileinput"
                               class="form-control-file btn_gallery d-none" accept="images/*">
                    </div>
                    <div class="preview-image-wrapper">
                        <img
                            src="{{ !empty($blog->thumbnail) ? asset('storage/' .$blog->thumbnail) : asset('backend/assets/images/placeholder.png') }}"
                            alt="Preview image" class="preview_image" width="150">
                        <div class="mx-auto cursor-pointer position-relative mt-1">
                            <button id="btn-avatar" type="button" class="btn btn-primary w-full preview_image">Select
                                Photo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
