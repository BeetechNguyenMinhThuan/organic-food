@extends('backend.layouts.master')
@section('addJs')
    @if($errors->any())
        <script>
            $(document).ready(function () {
                $('#modalAddBrand').modal('show');
            })
        </script>
    @endif
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Brands</li>
                    </ol>
                </div>
                <h4 class="page-title">Brands</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a
                                data-toggle="modal" data-target="#modalAddBrand"
                                href="javascript:void(0);"
                                class="btn btn-danger mb-2"
                            ><i class="mdi mdi-plus-circle mr-2"></i> Add
                                Brand</a
                            >
                            <div class="modal fade" id="modalAddBrand" tabindex="-1" role="dialog"
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
                                            <form method="POST" action="{{ route('admin.brands.store') }}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="name" class="col-form-label">Name</label>
                                                    <input name="name" type="text" placeholder="Type here"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           id="name"
                                                           value="{{ old('name') ? old('name') : (isset($brand->name) ? $brand->name : '') }}">
                                                    @error('name')
                                                    <div class="text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="description" class="col-form-label">Description</label>
                                                    <textarea name="description" placeholder="Type here"
                                                              class="form-control"
                                                              id="description">{{ old('description') ? old('description') : (isset($brand->description) ? $brand->description : '') }}</textarea>
                                                </div>
                                                <label class="col-form-label">Ảnh đại diện</label>
                                                <div class="">
                                                    <img class="img-product d-flex" style="margin: 0 auto"
                                                         height="250px"
                                                         src="{{isset($brand) ? \App\Helpers\Common::getImage($brand->image) : asset('backend/assets/images/upload.svg')}}"
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

                        </div>
                        <!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th class="all">Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($brands as $key => $brand)
                                <tr>
                                    <td>
                                        {{$brand->name}}
                                    </td>
                                    <td>{{$brand->description}}</td>
                                    <td>
                                        <img
                                            src="{{ \App\Helpers\Common::getImage($brand->image) }}"
                                            alt="contact-img"
                                            title="contact-img"
                                            class="rounded mr-3"
                                            height="48"
                                        />
                                    </td>

                                    <td class="table-action">
                                        <a href="javascript:void(0);" class="action-icon">
                                            <i class="mdi mdi-eye"></i
                                            ></a>
                                        <a href="javascript:void(0);" class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i
                                            ></a>
                                        <a
                                            data-url="{{route('admin.brands.destroy',['id'=>$brand->id])}}
                                                            "
                                            href="javascript:void(0);" class="action-icon
                                                            action_delete">
                                            <i class="mdi mdi-delete"></i
                                            ></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$brands->links()}}
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->
    </div>

@endsection
