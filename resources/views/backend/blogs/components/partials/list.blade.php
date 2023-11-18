@if(isset($blogs) && count($blogs) > 0 )
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a
                                href="{{route('admin.blogs.create')}}"
                                class="btn btn-danger mb-2"
                            ><i class="mdi mdi-plus-circle mr-2"></i> Add
                                Blog</a
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
                                <th>Author</th>
                                <th>Info Blog</th>
                                <th>status</th>
                                <th style="width: 85px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($blogs as $index => $blog)
                                <tr>
                                    <td>{{$index + $blogs->firstItem() }}</td>
{{--                                    <td>--}}
{{--                                        <img--}}
{{--                                            src="{{ \App\Helpers\Common::getImage($blog->user->avatar) }}"--}}
{{--                                            alt="contact-img"--}}
{{--                                            title="contact-img"--}}
{{--                                            class="rounded mr-3"--}}
{{--                                            height="48"--}}
{{--                                        />--}}
{{--                                    </td>--}}
                                    <td>
                                        <img
                                            src="{{ \App\Helpers\Common::getImage($blog->thumbnail) }}"
                                            alt="contact-img"
                                            title="contact-img"
                                            class="rounded mr-3"
                                            height="100"
                                        />
                                        <p>Title : {{$blog->title}}</p>
                                        <p>View : {{$blog->view_count}}</p>
                                    </td>
                                    <td>{!! $blog->handleStatus() !!}</td>
                                    <td class="table-action">
                                        <a href="javascript:void(0);" class="action-icon">
                                            <i class="mdi mdi-eye"></i
                                            ></a>
                                        <a href="{{route('admin.blogs.edit',['id'=>$blog->id])}}"
                                           class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i
                                            ></a>
                                        <a data-url="{{route('admin.blogs.destroy',['id'=>$blog->id])}}"
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
        </div>
        <!-- end col -->

    </div>
@else
    @include('backend.partials.no-data-found')
@endif
