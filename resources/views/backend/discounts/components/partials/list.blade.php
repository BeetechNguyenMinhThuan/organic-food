@if(isset($discounts) && count($discounts) > 0 )
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a
                                href="{{route('admin.discounts.create')}}"
                                class="btn btn-danger mb-2"
                            ><i class="mdi mdi-plus-circle mr-2"></i> Add
                                Discount</a
                            >
                        </div>
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
                                <th>Start at</th>
                                <th>End at</th>
                                <th>Max Use</th>
                                <th>Percent</th>
                                <th style="width: 85px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($discounts as $index => $discount)
                                <tr>
                                    <td>{{$index + $discounts->firstItem() }}</td>
                                    {{--                                    <td>--}}
                                    {{--                                        <img--}}
                                    {{--                                            src="{{ \App\Helpers\Common::getImage($blog->user->avatar) }}"--}}
                                    {{--                                            alt="contact-img"--}}
                                    {{--                                            title="contact-img"--}}
                                    {{--                                            class="rounded mr-3"--}}
                                    {{--                                            height="48"--}}
                                    {{--                                        />--}}
                                    {{--                                    </td>--}}
                                    <td>{{$discount->name}}</td>
                                    <td>{{$discount->start_at}}</td>
                                    <td>{{$discount->end_at}}</td>
                                    <td>{{$discount->max_use}}</td>
                                    <td>{{$discount->percent}}</td>
                                    <td class="table-action">
                                        <a href="javascript:void(0);" class="action-icon">
                                            <i class="mdi mdi-eye"></i
                                            ></a>
                                        <a href="{{route('admin.discounts.edit',['id'=>$discount->id])}}"
                                           class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i
                                            ></a>
                                        <a data-url="{{route('admin.discounts.destroy',['id'=>$discount->id])}}"
                                           href="javascript:void(0);" class="action-icon action_delete">
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
            {{$discounts->links()}}
        </div>
        <!-- end col -->

    </div>
@else
    @include('backend.partials.no-data-found')
@endif
