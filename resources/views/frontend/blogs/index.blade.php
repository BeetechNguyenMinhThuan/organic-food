@extends('frontend.layouts.master')
@section('modal')
    {{--    @include('frontend.partials.modal-pre-load')--}}
@endsection
@section('content')
    <div class="page-header mt-30 mb-75">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">Blog & News</h1>
                        <div class="breadcrumb">
                            <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span> Blog & News
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop-product-fillter mb-50">
                        <div class="totall-product">
                            <h2>
                                <img class="w-36px mr-10" src="{{asset('frontend/assets/imgs/theme/icons/category-1.svg')}}" alt=""/>
                                Recips Articles
                            </h2>
                        </div>
                    </div>
                    <div class="loop-grid">
                        <div class="row">
                            @if ($blogs->isNotEmpty())
                                @foreach($blogs as $blog)
                                    <article class="col-xl-3 col-lg-4 col-md-6 text-center hover-up mb-30 animated">
                                        <div class="post-thumb">
                                            <a href="{{route('blogs.detail',['slug' => $blog->slug])}}">
                                                <img class="border-radius-15"
                                                     src="{{asset('storage/'.$blog->thumbnail)}}" alt=""/>
                                            </a>
                                        </div>
                                        <div class="entry-content-2">
                                            <h4 class="post-title mb-15">
                                                <a href="{{route('blogs.detail',['slug' => $blog->slug])}}">{{$blog->title}}</a>
                                            </h4>
                                            <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                                <div>
                                                    <span
                                                        class="post-on mr-10">{{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y');}}</span>
                                                    <span class="hit-count has-dot mr-10">{{$blog->view_count ?? 0}} Views</span>
                                                </div>
                                            </div>
                                        </div>
                                    </article>

                                @endforeach
                            @else
                            @endif
                        </div>
                    </div>
                    <div class="pagination-area mt-20 mb-20">
                        {!! $blogs->links('vendor.pagination.default') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('addJs')
    <script type="module" src="{{asset('frontend/carts/carts.js')}}"></script>
@endsection
