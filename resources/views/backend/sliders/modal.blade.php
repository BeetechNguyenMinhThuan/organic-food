<div class="modal fade" id="{{$idModal}}" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ $route }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name</label>
                        <input name="name" type="text" placeholder="Type here"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               value="{{ old('name') ? old('name') : (isset($slider->name) ? $slider->name : '') }}">
                        @error('name')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Description</label>
                        <input name="description" type="text" placeholder="Type here"
                               class="form-control"
                               id="description"
                               value="{{ old('description') ? old('description') : (isset($slider->description) ? $slider->description : '') }}">
                    </div>
                    <label class="col-form-label">Ảnh đại diện</label>
                    <div class="">
                        <img class="img-product d-flex" style="margin: 0 auto"
                             height="250px"
                             src="{{isset($slider) ? \App\Helpers\Common::getImage($slider->image) : asset('backend/assets/images/upload.svg')}}"
                             alt=""/>
                        <div class="form-group mt-2">
                            <div class="custom-file">
                                <input name="image" type="file"
                                       class="custom-file-input avatar @error('image') is-invalid @enderror"
                                       id="inputGroupFile04">
                                <label class="custom-file-label" for="inputGroupFile04">Choose
                                    file</label>
                            </div>
                            @error('image')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group text-right mt-2">
                        <button class="btn btn-primary"
                                type="submit">{{trans('messages.save')}}</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
