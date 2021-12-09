<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ __('pages.title') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">{{ __('pages.brand') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('Menu Utama') }}</li>
            <li class="{{ Request::route()->getName() == 'dashboard' ? 'active' : (
                Request::route()->getName() == 'dashboard.log' ? 'active' : '') }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-fire"></i><span>{{ __('pages.dashboard') }}</span>
                </a>
            </li>
            <li class="menu-header">{{ __('Data') }}</li>
            <li class="nav-item dropdown {{ Request::route()->getName() == 'users.index' ? 'active' : (
                Request::route()->getName() == 'users.create' ? 'active' : (
                        Request::route()->getName() == 'users.edit' ? 'active' : (
                            Request::route()->getName() == 'users.show' ? 'active' : ''))) }}">
                <a href="{{ route('users.index') }}" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-users"></i>
                    <span>{{ __('Pengguna') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'users.index' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.index') }}">{{ __('Daftar') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'users.create' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.create') }}">{{ __('Tambah') }}</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ Request::route()->getName() == 'customer.index' ? 'active' : (
                Request::route()->getName() == 'customer.create' ? 'active' : (
                        Request::route()->getName() == 'customer.edit' ? 'active' : (
                            Request::route()->getName() == 'customer.show' ? 'active' : ''))) }}">
                <a href="{{ route('customer.index') }}" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-user-tie"></i>
                    <span>{{ __('Customer') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'customer.index' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('customer.index') }}">{{ __('Daftar') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'customer.create' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('customer.create') }}">{{ __('Tambah') }}</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ Request::route()->getName() == 'category.index' ? 'active' : (
                Request::route()->getName() == 'category.create' ? 'active' : (
                        Request::route()->getName() == 'category.edit' ? 'active' : (
                            Request::route()->getName() == 'category.show' ? 'active' : ''))) }}">
                <a href="{{ route('category.index') }}" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-tags"></i>
                    <span>{{ __('Kategori') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'category.index' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('category.index') }}">{{ __('Daftar') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'category.create' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('category.create') }}">{{ __('Tambah') }}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>