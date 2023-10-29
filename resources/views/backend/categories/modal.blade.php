<div class="modal fade" id="{{$idModal}}" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">{{$title}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{$route}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input name="name" type="text" placeholder="Type here"
                               class="form-control"
                               id="name" value="{{ isset($category) ? $category->name : (old('name') ? old('name') : "")}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Parent</label>
                        <select name="parent_id" class="form-control select2-base">
                            <option value="0">Danh mục cha</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>
                    <label class="col-form-label">Ảnh đại diện</label>
                    <div class="">
                        <img class="img-product d-flex" style="margin: 0 auto"
                             height="250px"
                             src="{{isset($category) ? \App\Helpers\Common::getImage($category->avatar) : asset('backend/assets/images/upload.svg')}}"
                             alt=""/>
                        <div class="form-group mt-2">
                            <div class="custom-file">
                                <input name="avatar" type="file"
                                       class="custom-file-input avatar @error('avatar') is-invalid @enderror"
                                       id="inputGroupFile04">
                                <label class="custom-file-label" for="inputGroupFile04">Choose
                                    file</label>
                            </div>
                            @error('avatar')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary"
                                type="submit">{{trans('messages.save')}}</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
