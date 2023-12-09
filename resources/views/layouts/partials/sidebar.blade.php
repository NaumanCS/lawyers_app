<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('admin.dashboard') }}" class="text-black">
            Admin Dashboard
        </a>
    </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
                </li>
                <li class="{{ request()->is('all-users*') ? 'active' : '' }}">
                    <a href="{{ route('all.users') }}"><i class="fas fa-columns"></i> <span>All Lawyers</span></a>
                </li>
                <li>
                    <a href="{{route('admin.lawyer.verification')}}"><i class="fas fa-layer-group"></i> <span>Verifications</span></a>
                </li>
                <li class="{{ request()->is('category*') ? 'active' : '' }}">
                    <a href="{{ route('category.index') }}"><i class="fas fa-columns"></i> <span>Categories</span></a>
                </li>
                <li class="{{ request()->is('service*') ? 'active' : '' }}">
                    <a href="{{ route('service.index') }}"><i class="fas fa-columns"></i> <span>Services</span></a>
                </li>
                <li class="{{ request()->is('admin/order*') ? 'active' : '' }}">
                    <a href="{{ route('admin.order.index') }}"><i class="fas fa-columns"></i> <span>Order</span></a>
                </li>
                <li class="{{ request()->is('admin/general-setting*') ? 'active' : '' }}">
                    <a href="{{ route('admin.general.setting.index') }}"><i class="fas fa-columns"></i> <span>General
                            Setting</span></a>
                </li>
                <li class="{{ request()->is('admin/transaction*') ? 'active' : '' }}">
                    <a href="{{ route('admin.transaction.index') }}"><i class="fas fa-columns"></i>
                        <span>Completed Transaction</span></a>
                </li>
                <li class="{{ request()->is('admin/pending/transaction') ? 'active' : '' }}">
                    <a href="{{ route('admin.transaction.pending') }}"><i class="fas fa-columns"></i>
                        <span>Pending Transaction</span></a>
                </li>
                <li class="{{ request()->is('admin/user/accounts*') ? 'active' : '' }}">
                    <a href="{{ route('admin.user.accounts.index') }}"><i class="fas fa-columns"></i>
                        <span>User Accounts</span></a>
                </li>
                {{-- <li>
                    <a href="subcategories.html"><i class="fab fa-buffer"></i> <span>Sub Categories</span></a>
                </li>
                <li>
                    <a href="service-list.html"><i class="fas fa-bullhorn"></i> <span> Services</span></a>
                </li>
                <li>
                    <a href="total-report.html"><i class="far fa-calendar-check"></i> <span> Booking List</span></a>
                </li>
                <li>
                    <a href="payment_list.html"><i class="fas fa-hashtag"></i> <span>Payments</span></a>
                </li>
                <li>
                    <a href="ratingstype.html"><i class="fas fa-star-half-alt"></i> <span>Rating Type</span></a>
                </li>
                <li>
                    <a href="review-reports.html"><i class="fas fa-star"></i> <span>Ratings</span></a>
                </li>
                <li>
                    <a href="subscriptions.html"><i class="far fa-calendar-alt"></i> <span>Subscriptions</span></a>
                </li>
                <li>
                    <a href="wallet.html"><i class="fas fa-wallet"></i> <span> Wallet</span></a>
                </li>
                <li>
                    <a href="service-providers.html"><i class="fas fa-user-tie"></i> <span> Service Providers</span></a>
                </li>
                <li>
                    <a href="users.html"><i class="fas fa-user"></i> <span>Users</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-clipboard"></i> <span> Invoices</span>
                        <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
                    </a>
                    <ul>
                        <li><a href="invoices.html">Invoices List</a></li>
                        <li><a href="invoice-grid.html">Invoices Grid</a></li>
                        <li><a href="add-invoice.html">Add Invoices</a></li>
                        <li><a href="edit-invoice.html">Edit Invoices</a></li>
                        <li><a href="view-invoice.html">Invoices Details</a></li>
                        <li><a href="invoices-settings.html">Invoices Settings</a></li>
                    </ul>
                </li>
                <li>
                    <a href="settings.html"><i class="fas fa-cog"></i> <span>Settings</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i> <span> Frontend Settings</span>
                        <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="front-settings.html"> <span> Header Settings</span></a>
                        </li>
                        <li>
                            <a href="footer-settings.html"> <span>Footer Settings</span></a>
                        </li>
                        <li>
                            <a href="pages.html"> <span>Pages </span></a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
