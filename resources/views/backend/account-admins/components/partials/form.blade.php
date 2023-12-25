<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
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
                                    <label for="first_name" class="col-form-label">First Name<sup
                                            style="color: red">*</sup></label>
                                    <input name="first_name" type="text" placeholder="Type here"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name" required
                                           value="{{ old('first_name') ? old('first_name') : (isset($user->first_name) ? $user->first_name : '') }}"/>
                                    @error('first_name')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name" class="col-form-label">Last Name<sup
                                            style="color: red">*</sup></label>
                                    <input name="last_name" type="text" placeholder="Type here"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name" required
                                           value="{{ old('last_name') ? old('last_name') : (isset($user->last_name) ? $user->last_name : '') }}"/>
                                    @error('last_name')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email" class="col-form-label">Email <sup
                                            style="color: red">*</sup></label>
                                    <input name="email" type="email" placeholder="Type here"
                                           class="form-control @error('sku') is-invalid @enderror"
                                           id="email" required
                                           value="{{ old('email') ? old('email') : (isset($user->email) ? $user->email : '') }}"/>
                                    @error('email')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone" class="col-form-label">Phone Number</label>
                                    <input name="phone" type="tel" placeholder="Type here"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           value="{{ old('phone') ? old('phone') : (isset($user->phone) ? $user->phone : '') }}"/>
                                    @error('phone')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="birthday" class="col-form-label">Birthday</label>
                                    <input name="birthday" type="date" placeholder="Type here"
                                           class="form-control @error('birthday') is-invalid @enderror"
                                           id="birthday"
                                           value="{{ old('birthday') ? old('birthday') : (isset($user->birthday) ? $user->birthday : '') }}"/>
                                    @error('birthday')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address" class="col-form-label">Role</label>
                                    <select name="roles[]" class="form-control select2-base" data-toggle="select2" multiple>
                                        @foreach($roles as $role)
                                            <option {{ (isset($user) && $user->hasRole($role)) ? "selected" : ""}} value="{{$role->name}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('address')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>


                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="form-group col-md-6">
                                <label class="col-form-label">Ảnh đại diện</label>
                                <div class="">
                                    <img class="img-product d-flex" style="margin: 0 auto" height="250px"
                                         src="{{isset($user) ? \App\Helpers\Common::getImage($user->avatar) : asset('backend/assets/images/upload.svg')}}"
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
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
</form>
