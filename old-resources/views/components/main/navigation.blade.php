{{--<nav class="navbar navbar-expand-lg bg-secondary bg-opacity-50">--}}
{{--    <div class="container-fluid container-md">--}}
{{--        <a class="navbar-brand" href="{{ route('actives.index') }}">{{ config('app.name', 'Capital Space') }}</a>--}}
{{--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--            <span class="navbar-toggler-icon"></span>--}}
{{--        </button>--}}
{{--        <div class="collapse navbar-collapse d-md-flex justify-content-between" id="navbarNavAltMarkup">--}}
{{--            <div class="navbar-nav align-items-center mb-3 mb-md-0">--}}
{{--                <a class="nav-link {{request()->routeIs('actives.index') ? 'active' : ''}}" aria-current="page" href="{{ route('actives.index') }}">Портфель</a>--}}

{{--                <a class="nav-link active" aria-current="page" data-bs-toggle="modal" data-bs-target="#createActiveModal">--}}
{{--                        Добавить акцию--}}
{{--                </a>--}}

{{--                <div class="nav-link mx-3">--}}
{{--                    <form action="{{route('test.date')}}" method="post">--}}
{{--                        @csrf--}}
{{--                        <div class="form-group row gap-3">--}}
{{--                            <div class="col">--}}
{{--                                <input class="form-control" type="date" name="date">--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <button type="submit" class="btn btn-primary text-nowrap">Котировки по дате</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}

{{--                <a class="nav-link" href="{{route('test.today')}}">--}}
{{--                    <button type="button" class="btn btn-primary text-nowrap">Котировки за сегодня</button></a>--}}

{{--            </div>--}}

{{--            <div class="navbar-nav align-items-center">--}}
{{--                @auth--}}
{{--                    <a class="nav-link" aria-current="page" href="#">Профиль</a>--}}
{{--                    <a class="nav-link" aria-current="page" href="{{route('logout')}}">Выйти</a>--}}
{{--                @endauth--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}


<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex align-items-center">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{route('actives.index')}}" class="link text-decoration-none text-black fw-bold flogo logo-dark">
                        <h3>Capital Space</h3>
                    </a>

{{--                    <a href="{{route('actives.index')}}" class="logo logo-light">--}}
{{--                        Capital Space--}}
{{--                    </a>--}}
                </div>
                <div class="navbar-item">
                    <a class="nav-link active" aria-current="page" data-bs-toggle="modal" data-bs-target="#createActiveModal">
                        Добавить акцию</a>
                </div>
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
{{--                <form class="app-search d-none d-md-block">--}}
{{--                    <div class="position-relative">--}}
{{--                        <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">--}}
{{--                        <span class="mdi mdi-magnify search-widget-icon"></span>--}}
{{--                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>--}}
{{--                    </div>--}}
{{--                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">--}}
{{--                        <div data-simplebar="init" style="max-height: 320px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;"><div class="simplebar-content" style="padding: 0px;">--}}
{{--                                                <!-- item-->--}}
{{--                                                <div class="dropdown-header">--}}
{{--                                                    <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>--}}
{{--                                                </div>--}}

{{--                                                <div class="dropdown-item bg-transparent text-wrap">--}}
{{--                                                    <a href="index.html" class="btn btn-soft-secondary btn-sm rounded-pill">how to setup <i class="mdi mdi-magnify ms-1"></i></a>--}}
{{--                                                    <a href="index.html" class="btn btn-soft-secondary btn-sm rounded-pill">buttons <i class="mdi mdi-magnify ms-1"></i></a>--}}
{{--                                                </div>--}}
{{--                                                <!-- item-->--}}
{{--                                                <div class="dropdown-header mt-2">--}}
{{--                                                    <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>--}}
{{--                                                </div>--}}

{{--                                                <!-- item-->--}}
{{--                                                <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                                                    <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>--}}
{{--                                                    <span>Analytics Dashboard</span>--}}
{{--                                                </a>--}}

{{--                                                <!-- item-->--}}
{{--                                                <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                                                    <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>--}}
{{--                                                    <span>Help Center</span>--}}
{{--                                                </a>--}}

{{--                                                <!-- item-->--}}
{{--                                                <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                                                    <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>--}}
{{--                                                    <span>My account settings</span>--}}
{{--                                                </a>--}}

{{--                                                <!-- item-->--}}
{{--                                                <div class="dropdown-header mt-2">--}}
{{--                                                    <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>--}}
{{--                                                </div>--}}

{{--                                                <div class="notification-list">--}}
{{--                                                    <!-- item -->--}}
{{--                                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">--}}
{{--                                                        <div class="d-flex">--}}
{{--                                                            <img src="assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">--}}
{{--                                                            <div class="flex-grow-1">--}}
{{--                                                                <h6 class="m-0">Angela Bernier</h6>--}}
{{--                                                                <span class="fs-11 mb-0 text-muted">Manager</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </a>--}}
{{--                                                    <!-- item -->--}}
{{--                                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">--}}
{{--                                                        <div class="d-flex">--}}
{{--                                                            <img src="assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">--}}
{{--                                                            <div class="flex-grow-1">--}}
{{--                                                                <h6 class="m-0">David Grasso</h6>--}}
{{--                                                                <span class="fs-11 mb-0 text-muted">Web Designer</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </a>--}}
{{--                                                    <!-- item -->--}}
{{--                                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">--}}
{{--                                                        <div class="d-flex">--}}
{{--                                                            <img src="assets/images/users/avatar-5.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">--}}
{{--                                                            <div class="flex-grow-1">--}}
{{--                                                                <h6 class="m-0">Mike Bunch</h6>--}}
{{--                                                                <span class="fs-11 mb-0 text-muted">React Developer</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                            </div></div></div></div><div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="height: 0px; display: none;"></div></div></div>--}}

{{--                        <div class="text-center pt-3 pb-1">--}}
{{--                            <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
            </div>

            <div class="d-flex align-items-center">

{{--                <div class="dropdown d-md-none topbar-head-dropdown header-item">--}}
{{--                    <button type="button" class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                        <i class="bx bx-search fs-22"></i>--}}
{{--                    </button>--}}
{{--                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">--}}
{{--                        <form class="p-3">--}}
{{--                            <div class="form-group m-0">--}}
{{--                                <div class="input-group">--}}
{{--                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">--}}
{{--                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img id="header-lang-img" src="{{ \Vite::asset('resources/images/icons/countries/russia.svg') }}" alt="Header Language" height="20" class="rounded">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ru" title="Russian">
                            <img src="{{ \Vite::asset('resources/images/icons/countries/russia.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">русский</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                            <img src="{{ \Vite::asset('resources/images/icons/countries/us.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">English</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp" title="Spanish">
                            <img src="{{ \Vite::asset('resources/images/icons/countries/spain.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Española</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="gr" title="German">
                            <img src="{{ \Vite::asset('resources/images/icons/countries/germany.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Deutsche</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="it" title="Italian">
                            <img src="{{ \Vite::asset('resources/images/icons/countries/italy.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Italiana</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ch" title="Chinese">
                            <img src="{{ \Vite::asset('resources/images/icons/countries/china.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">中国人</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="fr" title="French">
                            <img src="{{ \Vite::asset('resources/images/icons/countries/french.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">français</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ar" title="Arabic">
                            <img src="{{ \Vite::asset('resources/images/icons/countries/us.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Arabic</span>
                        </a>
                    </div>
                </div>


                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle light-dark-mode">
                        <img src="{{Vite::asset('resources/images/icons/moon.svg')}}" alt="moon">
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{Vite::asset('resources/images/profile.jpg')}}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{$user->email}}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Пользователь</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{$user->email}}!</h6>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>
                        <a class="dropdown-item" href="#"><span class="badge bg-success-subtle text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
