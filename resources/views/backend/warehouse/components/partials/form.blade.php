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
                                    value="{{ old('name') ? old('name') : (isset($product->name) ? $product->name : '') }}"
                                    type="text" name="name" id="simpleinput" class="form-control">
                                @error('name')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="simpleinput">Quantity</label>
                                <input
                                    value="{{ old('start_at') ? old('start_at') : (isset($product->stock) ? $product->stock : "") }}"
                                    type="number" name="stock" id="simpleinput" class="form-control">
                                @error('quantity')
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
