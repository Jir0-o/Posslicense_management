        <!-- Menu -->
        <style>
            .layout-menu a {
                text-decoration: none !important;
            }
            .unicorn-logo {
                width: 60px; /* Adjust width as needed */
            }
        </style>
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{route('dashboard.index')}}" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink">
                            <!-- SVG content here -->
                        </svg>
                        <img 
                            src="{{ asset('storage/profile-photos/store_photos/unicorn-removebg-preview.png') }}" 
                            alt="Unicorn Logo" 
                            class="side-nav-logo"
                        />
                    </span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Dashboard Section</span>
                </li>
                <!-- Dashboard -->
                <li class="menu-item">
                    <a href="{{route('dashboard.index')}}"
                        class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home"></i>
                        <div data-i18n="Dashboard">Dashboard</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">license Section</span>
                </li>
                 <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-user-check"></i>
                        <div data-i18n="Layouts">License</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{route('licenses.index')}}" class="menu-link">
                                <div data-i18n="Without menu">Shop License</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text"> Role and Permission</span>
                </li>
                <!-- Settings -->
                <li class="menu-item">
                    <a href="{{route('settings')}}"
                        class="menu-link">
                        <i class="menu-icon bx bx-cog"></i>
                        <div data-i18n="Settings">Role Permission & User</div>
                    </a>
                </li>
            </ul>
        </aside>
        <!-- / Menu -->
