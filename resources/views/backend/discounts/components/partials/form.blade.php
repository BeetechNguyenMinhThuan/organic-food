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
                                <label for="simpleinput">Name</label>
                                <input
                                        value="{{ old('name') ? old('name') : (isset($discount->name) ? $discount->name : '') }}"
                                        type="text" name="name" id="simpleinput" class="form-control">
                                @error('name')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="simpleinput">Start at</label>
                                <input
                                        value="{{ old('start_at') ? old('start_at') : (isset($discount->start_at) ? \Carbon\Carbon::parse($discount->start_at)->format('Y-m-d') : '') }}"
                                        type="date" name="start_at" id="simpleinput" class="form-control">
                                @error('start_at')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="simpleinput">End at</label>
                                <input
                                        value="{{ old('end_at') ? old('end_at') : (isset($discount->end_at) ? \Carbon\Carbon::parse($discount->end_at)->format('Y-m-d') : '') }}"
                                        type="date" name="end_at" id="simpleinput" class="form-control">
                                @error('end_at')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="simpleinput">Max use</label>
                                <input
                                        value="{{ old('max_use') ? old('max_use') : (isset($discount->max_use) ? $discount->max_use : '') }}"
                                        type="number" name="max_use" id="simpleinput" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="simpleinput">Percent</label>
                                <input
                                        value="{{ old('percent') ? old('percent') : (isset($discount->percent) ? $discount->percent : '') }}"
                                        type="number" name="percent" id="simpleinput" class="form-control">
                                @error('percent')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
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


        </div>
    </div>
</form>
