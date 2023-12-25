@if(isset($comments) && count($comments) > 0 )
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
                                <th>status</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Product</th>
                                <th style="width: 85px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $index => $comment)
                                <tr>
                                    <td>{{$index + $comments->firstItem() }}</td>
                                    <td>
                                        @if($comment->status)
                                            <a href='{{route('admin.comment.changeStatus',['productId' => $comment->product_id,'commentId' => $comment->id])}}'
                                               class='btn btn-danger'>Bỏ duyệt</a>
                                        @else
                                            <a href='{{route('admin.comment.changeStatus',['productId' => $comment->product_id,'commentId' => $comment->id])}}'
                                               class='btn btn-success'>Duyệt</a>
                                        @endif
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <img
                                            src="{{ \App\Helpers\Common::getImage($comment->user->avatar) }}"
                                            alt="contact-img"
                                            title="contact-img"
                                            class="rounded-circle mr-1"
                                            height="30" width="30"
                                        />
                                        <span>{{$comment->user->fullname}}</span>
                                    </td>
                                    <td>
                                        {{$comment->comment}}
                                        @if($comment->status == 1)
                                            <form
                                                action="{{route('admin.comment.adminReplyComment',['productId' => $comment->product_id,'commentId' => $comment->id])}}"
                                                method="GET" class="reply-comment">
                                                <textarea required class="d-block mb-1 mt-2 form-control" name="comment"
                                                          id=""
                                                          cols="40"
                                                          rows="2"></textarea>
                                                <button type="submit" class="btn btn-secondary">Trả lời</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <a target="_blank"
                                           href="{{route('products.detail',['name'=>$comment->product->slug])}}">{{$comment->product->name}}</a>
                                    </td>
                                    <td class="table-action">
                                        <a href="javascript:void(0);" class="action-icon">
                                            <i class="mdi mdi-eye"></i
                                            ></a>
                                        <a href="{{route('admin.blogs.edit',['id'=>$comment->id])}}"
                                           class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i
                                            ></a>
                                        <a data-url="{{route('admin.comment.deleteComment',['productId'=>$comment->product->id,'commentId'=>$comment->id])}}"
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
            {{$comments->links()}}
            <!-- end card-->
        </div>
        <!-- end col -->
    </div>
@else
    @include('backend.partials.no-data-found')
@endif
