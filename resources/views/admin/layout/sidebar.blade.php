<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Storage::url(Auth::guard('admin')->user()->image ?? 'dist/img/user2-160x160.jpg') }}"
                    class="img-circle elevation-2" alt="User Image" style="height: 40px; width: 40px;">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('admin.home_banners.index') }}"
                        class="nav-link {{ request()->routeIs('admin.home_banners.index') ? 'active' : '' }}">
                        <i class="fas fa-th-list nav-icon"></i>
                        <p>Home Banner</p>
                    </a>
                </li>

                <!-- Settings Menu -->
                <li
                    class="nav-item has-treeview {{ request()->routeIs('admin.update_password') || request()->routeIs('admin.details') || request()->routeIs('admin.edit_profile') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.update_password') || request()->routeIs('admin.details') || request()->routeIs('admin.edit_profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.update_password') }}"
                                class="nav-link {{ request()->routeIs('admin.update_password') ? 'active' : '' }}">
                                <i class="fas fa-key nav-icon"></i>
                                <p>Admin Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.details') }}"
                                class="nav-link {{ request()->routeIs('admin.details') ? 'active' : '' }}">
                                <i class="fas fa-info-circle nav-icon"></i>
                                <p>Admin Details</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.edit_profile') }}"
                                class="nav-link {{ request()->routeIs('admin.edit_profile') ? 'active' : '' }}">
                                <i class="far fa-user nav-icon"></i>
                                <p>Edit Profile</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Products Menu -->
                <li
                    class="nav-item has-treeview {{ request()->routeIs('admin.products') || request()->routeIs('admin.products_description.index') || request()->routeIs('admin.product_reviews.index') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.products') || request()->routeIs('admin.product_reviews.index') || request()->routeIs('admin.products') ? 'active' : '' }}">
                        <i class="fas fa-box nav-icon"></i>
                        <p>
                            Product
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.products') }}"
                                class="nav-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                                <i class="fas fa-th-list nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products_description.index') }}"
                                class="nav-link {{ request()->routeIs('admin.products_description.index') ? 'active' : '' }}">
                                <i class="fas fa-info-circle nav-icon"></i>
                                <p>Details</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.product_reviews.index') }}"
                                class="nav-link {{ request()->routeIs('admin.product_reviews.index') ? 'active' : '' }}">
                                <i class="far fa-user nav-icon"></i>
                                <p>Reviews</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Product Categories Menu Item -->
                <li class="nav-item">
                    <a href="{{ route('admin.category.index') }}"
                        class="nav-link {{ request()->routeIs('admin.category.index') ? 'active' : '' }}">
                        <i class="fas fa-th-list nav-icon"></i>
                        <p>Product Categories</p>
                    </a>
                </li>

                <!-- Posts Menu Item -->
                <li class="nav-item">
                    <a href="{{ route('admin.posts.index') }}"
                        class="nav-link {{ request()->routeIs('admin.posts.index') ? 'active' : '' }}">
                        <i class="fas fa-edit nav-icon"></i>
                        <p>Posts</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart nav-icon"></i>
                        <p>Order Status</p>
                    </a>
                </li>

                <!-- Shipping Methods Menu Item -->
                <li class="nav-item">
                    <a href="{{ route('admin.shipping.index') }}"
                        class="nav-link {{ request()->routeIs('admin.shipping.index') ? 'active' : '' }}">
                        <i class="fas fa-shipping-fast nav-icon"></i>
                        <p>Shipping Methods</p>
                    </a>
                </li>

                <!-- Our Services Menu Item -->
                <li class="nav-item">
                    <a href="{{ route('admin.ourservices.index') }}"
                        class="nav-link {{ request()->routeIs('admin.ourservices.index') ? 'active' : '' }}">
                        <i class="far fa-folder nav-icon"></i>
                        <p>Our Services</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                        <i class="far fa-folder nav-icon"></i>
                        <p>User Management</p>
                    </a>
                </li>

                <!-- Partners Menu Item -->
                <li class="nav-item">
                    <a href="{{ route('admin.partners.index') }}"
                        class="nav-link {{ request()->routeIs('admin.partners.index') ? 'active' : '' }}">
                        <i class="far fa-user nav-icon"></i>
                        <p>Partners</p>
                    </a>
                </li>

                <!-- Payment Methods Menu Item -->
                <li class="nav-item">
                    <a href="{{ route('admin.payment_methods.index') }}"
                        class="nav-link {{ request()->routeIs('admin.payment_methods.index') ? 'active' : '' }}">
                        <i class="far fa-folder nav-icon"></i>
                        <p>Payment Methods</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>