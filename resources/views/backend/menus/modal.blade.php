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
                <form method="POST" action="{{$route}}">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input name="name" type="text" placeholder="Type here"
                               class="form-control" value="{{$menu->name}}"
                               id="name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Parent</label>
                        <select name="parent_id" class="form-control select2-base">
                            <option value="0">Danh mục cha</option>
                            {!! $htmlOption !!}
                        </select>
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
