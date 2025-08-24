<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row align-items-center">
            <li class="nav-item mr-auto">
                <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
                    <img src="{{ asset($setting->admin_logo ?? 'backend/app-assets/images/logo/logo.png') }}"
                        width="40" alt="logo">
                    <h2 class="brand-text">{{ $setting->admin_title ?? 'My Admin' }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('dashboard') }}">
                    <i data-feather="home"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Home
                    </span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('getInTouch.list', 'getInTouch.show') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('getInTouch.list') }}">
                    <i data-feather="mail"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Inbox
                    </span>
                </a>
            </li>

            <li class="navigation-header">
                <span data-i18n="Charts &amp; Maps">
                    CMS
                </span>
                <i data-feather="more-horizontal"></i>
            </li>

            <li class="{{ request()->routeIs('homeBanner.create') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('homeBanner.create') }}">
                    <i data-feather="box"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Home Banner Setting
                    </span>
                </a>
            </li>
            <li class="{{ request()->routeIs(['homeTour.create', 'homeTour.edit', 'homeTour.list']) ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('homeTour.list') }}">
                    <i data-feather="activity"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Home Tour Setting
                    </span>
                </a>
            </li>
            <li class="{{ request()->routeIs(['trips.show', 'trips.list']) ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('trips.list') }}">
                    <i data-feather="list"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Trip Lists
                    </span>
                </a>
            </li>
            <li class="{{ request()->routeIs(['cruise.show', 'cruise.list']) ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('cruise.list') }}">
                    <i data-feather="list"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Cruise Lists
                    </span>
                </a>
            </li>
            <li class="{{ request()->routeIs(['singlePageBanner.edit', 'singlePageBanner.list']) ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('singlePageBanner.list') }}">
                    <i data-feather="image"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Banner Image Setting
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs(['homeExperienceImageSection.list', 'homeExperienceImageSection.create', 'homeExperienceImageSection.edit']) ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('homeExperienceImageSection.list') }}">
                    <i data-feather="image"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Experience Section Image
                    </span>
                </a>
            </li>
            <li class="{{ request()->routeIs('mission.create') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('mission.create') }}">
                    <i data-feather="target"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Our Mission
                    </span>
                </a>
            </li>
            <li class="{{ request()->routeIs('ourstory.create') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('ourstory.create') }}">
                    <i data-feather="book"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Our Story
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('uniqueFeatures.list', 'uniqueFeatures.create', 'uniqueFeatures.edit') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('uniqueFeatures.list') }}">
                    <i data-feather="award"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Unique Features
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('responsibleTravel.list', 'responsibleTravel.create', 'responsibleTravel.edit') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('responsibleTravel.list') }}">
                    <i data-feather="globe"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Responsible Travel
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('bookingTrip.list', 'bookingTrip.edit', 'bookingTrip.show') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('bookingTrip.list') }}">
                    <i class="ri-flight-takeoff-line"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Booking Trip
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('rating.list', 'rating.create', 'rating.edit', 'rating.show') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('rating.list') }}">
                    <i class="fas fa-star-half-alt"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Rating
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('peopleBehind.list', 'peopleBehind.create', 'peopleBehind.edit', 'peopleBehind.show') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('peopleBehind.list') }}">
                    <i data-feather="thumbs-up"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        People Behind Trip
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('destinationCover.list', 'destinationCover.create', 'destinationCover.edit', 'destinationCover.show') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('destinationCover.list') }}">
                    <i data-feather="map"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Destination We Cover
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('whyTravelWithUs.list', 'whyTravelWithUs.create', 'whyTravelWithUs.edit') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('whyTravelWithUs.list') }}">
                    <i data-feather="compass"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Why Travel With Us
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('seoTitle.list', 'seoTitle.create', 'seoTitle.edit', 'seoTitle.show') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('seoTitle.list') }}">
                    <i data-feather="trending-up"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        SEO Title
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('dynamicTripButton.list', 'dynamicTripButton.create', 'dynamicTripButton.edit') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('dynamicTripButton.list') }}">
                    <i data-feather="package"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Dynamic Trip Button
                    </span>
                </a>
            </li>
            <li class="{{ request()->routeIs('gallery.list', 'gallery.create', 'gallery.edit') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('gallery.list') }}">
                    <i data-feather="camera"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Gallery
                    </span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('travelAdvisor.list', 'travelAdvisor.create', 'travelAdvisor.edit') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('travelAdvisor.list') }}">
                    <i data-feather="archive"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Travel Advisor
                    </span>
                </a>
            </li>
            <li class="{{ request()->routeIs('category.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('category.index') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-item text-truncate" data-i18n="Analytics">
                        Category
                    </span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('faq.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('faq.index') }}">
                    <i data-feather="help-circle"></i>
                    <span class="menu-title text-truncate" data-i18n="ag-grid">
                        FAQ
                    </span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('dynamicpages.index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('dynamicpages.index') }}">
                    <i data-feather="layers"></i>
                    <span class="menu-title text-truncate">
                        Dynamic Pages
                    </span>
                </a>
            </li>


            <li class=" navigation-header">
                <span data-i18n="Charts &amp; Maps">
                    Settings
                </span>
                <i data-feather="more-horizontal"></i>
            </li>

            <li
                class="nav-item {{ request()->routeIs(['admin.setting.*', 'profile.*', 'dynamicpages.*']) ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="settings"></i>
                    <span class="menu-title text-truncate" data-i18n="Charts">
                        System Settings
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('profile') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Profile Settings
                            </span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('system.setting') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('system.setting') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                System Setting
                            </span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.setting') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.setting') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Admin Setting
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.setting.mail') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.setting.mail') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Mail Setting
                            </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.role.*') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('admin.role.list') }}">
                    <i data-feather="shield"></i>
                    <span class="menu-title text-truncate">
                        Role Management
                    </span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('user.list') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="users"></i>
                    <span class="menu-title text-truncate" data-i18n="ag-grid">
                        Users
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ request()->routeIs('user.create') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('user.create') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                Create User
                            </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('user.list') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('user.list') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Chartjs">
                                User List
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
