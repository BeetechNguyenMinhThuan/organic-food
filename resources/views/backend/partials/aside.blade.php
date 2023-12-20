<div class="left-side-menu">
    <!-- LOGO -->
    <a href="{{route('admin.dashboard.index')}}" class="logo text-center logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('frontend/assets/imgs/home/logo-vip.png') }}" alt="" height="90px">
                    </span>
        <span class="logo-sm">
                        <img src="{{asset('backend/assets/images/logo_sm.png')}}" alt="" height="16">
                    </span>
    </a>

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-dark">
                    <span class="logo-lg">
                        <img src="{{asset('backend/assets/images/logo-dark.png')}}" alt="" height="16">
                    </span>
        <span class="logo-sm">
                        <img src="{{asset('backend/assets/images/logo_sm_dark.png')}}" alt="" height="16">
                    </span>
    </a>

    <div class="h-100" id="left-side-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="metismenu side-nav">

            <li class="side-nav-title side-nav-item">Navigation</li>

            <li class="side-nav-item">
                <a href="{{route('admin.dashboard.index')}}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Trang quản trị </span>
                </a>
            </li>
            @can('module category')
                <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        <i class="uil-store"></i>
                        <span> Danh mục </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{route('admin.categories.index')}}">Danh sách danh mục</a>
                        </li>
                    </ul>
                </li>
            @endcan

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Menus </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.menus.index')}}">Danh sách Menu</a>
                    </li>
                </ul>
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Sliders </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.sliders.index')}}">Danh sách Slider</a>
                    </li>
                </ul>
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Thương hiệu </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.brands.index')}}">Danh sách thương hiệu</a>
                    </li>
                </ul>
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Sản phẩm </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.products.index')}}">Danh sách sản phẩm</a>
                    </li>
                    <li>
                        <a href="{{route('admin.products.create')}}">Thêm sản phẩm</a>
                    </li>
                </ul>
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Giảm giá </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.discounts.index')}}">Danh sách giảm giá</a>
                    </li>
                </ul>
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Cài đặt </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.settings.index')}}">Danh sách cài đặt</a>
                    </li>
                    <li>
                        <a href="{{route('admin.settings.create')}}">Thêm cài đặt</a>
                    </li>
                </ul>
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Bài viết </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.blogs.create')}}">Thêm bài viết</a>
                    </li>
                    <li>
                        <a href="{{route('admin.blogs.index')}}">danh sách bài viết</a>
                    </li>
                </ul>
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Bình luận </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.comment.index')}}">Danh sách bình luận</a>
                    </li>
                </ul>
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Quyền và vai trò</span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.roles.index')}}">Danh sách vai trò</a>
                    </li>
                    <li>
                        <a href="{{route('admin.roles.create')}}">Thêm vai trò</a>
                    </li>
                    <li>
                        <a href="{{route('admin.permissions.index')}}">Danh sách quyền</a>
                    </li>
                    <li>
                        <a href="{{route('admin.permissions.create')}}">Thêm quyền</a>
                    </li>
                </ul>
            </li>

            @can('module users')
                <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        <i class="uil-store"></i>
                        <span> Người dùng </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{route('admin.account-admins.index')}}">Danh sách Admin</a>
                        </li>
                        <li>
                            <a href="{{route('admin.users.index')}}">Danh sách khách hàng</a>
                        </li>
                    </ul>
                </li>
            @endcan

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Hoá đơn </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.orders.index')}}">Danh sách hoá đơn</a>
                    </li>

                </ul>
            </li>
            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Kho hàng </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.warehouse.index')}}">Danh sách kho hàng</a>
                    </li>

                </ul>
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Thống kê </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.statistic.product')}}">Sản phẩm</a>
                    </li>

                    <li>
                        <a href="{{route('admin.statistic.order')}}">Đơn hàng</a>
                    </li>

                    <li>
                        <a href="{{route('admin.statistic.activityUser')}}">Lịch sử truy cập</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
