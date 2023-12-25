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
                        <label for="config_key" class="col-form-label">Config Key <sup
                                    style="color: red">*</sup></label>
                        <input name="config_key" type="text" placeholder="Type here"
                               class="form-control @error('config_key') is-invalid @enderror"
                               id="config_key"
                               value="{{ old('config_key') ? old('config_key') : (isset($setting->config_key) ? $setting->config_key : '') }}"/>
                        @error('config_key')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="config_value" class="col-form-label">Config Value <sup
                                    style="color: red">*</sup></label>
                        <input
                                value="{{ old('config_value') ? old('config_value') : (isset($setting->config_value) ? $setting->config_value : '') }}"
                                name="config_value" placeholder="" type="text"
                                class="form-control @error('config_value') is-invalid @enderror"/>
                        @error('config_value')
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
