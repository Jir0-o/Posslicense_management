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
                <!-- Layouts -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Manage Task Section</span>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-task"></i>
                        <div data-i18n="Layouts">Manage Task Details</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without menu">Manage Work Plan</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without menu">Assign Task</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Container">Project Details</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-calendar-check"></i>
                        <div data-i18n="Layouts">Task & Plan Manage</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without navbar">Work Plan</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without navbar">Task Details</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Login Details Section</span>
                </li>
                 <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-user-check"></i>
                        <div data-i18n="Layouts">Login Details</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without menu">User Login Details</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Report & Other Section</span>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                        <div data-i18n="Layouts">Other Tabs</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without menu">Notice Board</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without navbar">Application</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                        <div data-i18n="Layouts">Report Section</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Container">View Report</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without navbar">Login Report</div>
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
