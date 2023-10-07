@if(isset($products) && count($products) > 0 )
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a
                                href="{{route('admin.products.create')}}"
                                class="btn btn-danger mb-2"
                            ><i class="mdi mdi-plus-circle mr-2"></i> Add
                                Products</a
                            >
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button
                                    type="button"
                                    class="btn btn-success mb-2 mr-1"
                                >
                                    <i class="mdi mdi-settings"></i>
                                </button>
                                <button type="button" class="btn btn-light mb-2 mr-1">
                                    Import
                                </button>
                                <button type="button" class="btn btn-light mb-2">
                                    Export
                                </button>
                            </div>
                        </div>
                        <!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table table-centered w-100 dt-responsive nowrap"
                            id="products-datatable"
                        >
                            <thead class="thead-light">
                            <tr>
                                <th class="all" style="width: 20px">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="customCheck1"
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="customCheck1"
                                        >&nbsp;</label
                                        >
                                    </div>
                                </th>
                                <th class="all">Product</th>
                                <th>Category</th>
                                <th>Added Date</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th style="width: 85px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $key => $product)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                class="custom-control-input"
                                                id="customCheck{{$key+2}}"
                                            />
                                            <label
                                                class="custom-control-label"
                                                for="customCheck{{$key+2}}"
                                            >&nbsp;</label
                                            >
                                        </div>
                                    </td>
                                    <td>
                                        <img
                                            src="{{ \App\Helpers\Common::getImage($product->avatar)}}"
                                            alt="contact-img"
                                            title="contact-img"
                                            class="rounded mr-3"
                                            height="48"
                                        />
                                        <p
                                            class="m-0 d-inline-block align-middle font-16"
                                        >
                                            <a
                                                href="apps-ecommerce-products-details.html"
                                                class="text-body"
                                            >{{$product->name}}</a
                                            >
                                            <br/>
                                            <span class="text-warning mdi mdi-star"></span>
                                            <span class="text-warning mdi mdi-star"></span>
                                            <span class="text-warning mdi mdi-star"></span>
                                            <span class="text-warning mdi mdi-star"></span>
                                            <span class="text-warning mdi mdi-star"></span>
                                        </p>
                                    </td>
                                    <td>{{optional($product->category)->name}}</td>
                                    <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y') }}</td>
                                    <td>{{number_format($product->price,)}}</td>

                                    <td>{{$product->stock}}</td>
                                    <td>
                                        @if($product->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>

                                        @endif
                                    </td>

                                    <td class="table-action">
                                        <a href="javascript:void(0);" class="action-icon">
                                            <i class="mdi mdi-eye"></i
                                            ></a>
                                        <a href="{{route('admin.products.edit',['id'=>$product->id])}}"
                                           class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i
                                            ></a>
                                        <a href="javascript:void(0);" class="action-icon action_delete"
                                           data-url="{{route('admin.products.destroy',['id'=>$product->id])}}">
                                            <i class="mdi mdi-delete"></i
                                            ></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->

    </div>
@else
    @include('backend.partials.no-data-found')
@endif
