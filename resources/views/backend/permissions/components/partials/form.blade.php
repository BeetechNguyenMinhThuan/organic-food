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
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name<sup
                                    style="color: red">*</sup></label>
                        <input name="name" type="text" placeholder="Type here"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               value="{{ old('name') ? old('name') : (isset($permission->name) ? $permission->name : '') }}"/>
                        @error('name')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
</form>
