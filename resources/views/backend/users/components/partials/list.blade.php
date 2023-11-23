@if(isset($users) && count($users) > 0 )
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
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
                            id=""
                        >
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th style="width: 85px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{$index + $users->firstItem() }}</td>
                                    <td>
                                        <img
                                            src="{{ \App\Helpers\Common::getImage($user->avatar)}}"
                                            alt="contact-img"
                                            title="contact-img"
                                            class="rounded mr-3"
                                            height="48"
                                        />
                                    </td>
                                    <td>{{$user->full_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td class="table-action">
                                        <a href="javascript:void(0);" class="action-icon">
                                            <i class="mdi mdi-eye"></i
                                            ></a>
                                        <a href="{{route('admin.users.edit',['id'=>$user->id])}}"
                                           class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i
                                            ></a>
                                        <a href="javascript:void(0);" class="action-icon action_delete"
                                           data-url="{{route('admin.users.destroy',['id'=>$user->id])}}">
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
