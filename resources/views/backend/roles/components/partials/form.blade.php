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
                    <div class="form-group col-md-6">
                        <label for="name" class="col-form-label">Name<sup
                                    style="color: red">*</sup></label>
                        <input name="name" type="text" placeholder="Type here"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               value="{{ old('name') ? old('name') : (isset($role->name) ? $role->name : '') }}"/>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h6 class="card-header">Permissions</h6>
                <div class="card-body">
                    <h5 class="card-title">Chọn quyền</h5>
                   <div class="row">
                       @foreach($permissions as $key => $permission)
                           <div class="custom-control custom-checkbox col-md-2 mb-2 mt-2">
                               <input {{ (isset($role) && $role->permissions->pluck('name')->contains($permission->name)) ? "checked" : "" }}  value="{{$permission->name}}" name="permissions[]" type="checkbox" class="custom-control-input" id="permission_{{$key}}" multiple>
                               <label class="custom-control-label" for="permission_{{$key}}">{{$permission->name}}</label>
                           </div>
                       @endforeach
                   </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
</form>
