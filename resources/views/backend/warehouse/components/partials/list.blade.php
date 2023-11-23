@if(isset($products) && count($products) > 0 )
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table table-centered w-100 dt-responsive nowrap"
                            id=""
                        >
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th style="width: 85px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $index => $product)
                                <tr>
                                    <td>{{$index + $products->firstItem() }}</td>
                                    {{--                                    <td>--}}
                                    {{--                                        <img--}}
                                    {{--                                            src="{{ \App\Helpers\Common::getImage($blog->user->avatar) }}"--}}
                                    {{--                                            alt="contact-img"--}}
                                    {{--                                            title="contact-img"--}}
                                    {{--                                            class="rounded mr-3"--}}
                                    {{--                                            height="48"--}}
                                    {{--                                        />--}}
                                    {{--                                    </td>--}}
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->stock}}</td>
                                    <td class="table-action">
                                        <a href="javascript:void(0);" class="action-icon">
                                            <i class="mdi mdi-eye"></i
                                            ></a>
                                        <a href="{{route('admin.warehouse.edit',['id'=>$product->id])}}"
                                           class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i
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
            {{$products->links()}}
        </div>
        <!-- end col -->

    </div>
@else
    @include('backend.partials.no-data-found')
@endif
