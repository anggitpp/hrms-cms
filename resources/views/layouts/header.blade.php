@php
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
    $prefix = str_replace('/','', $prefix);

@endphp
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
            <ul class="nav navbar-nav align-items-center ml-auto">
                @foreach($accessed as $key => $access)
                    @php
                        $firstMenu = reset($access['menu'][array_key_first($access['submodul'])]);
                        list($modulName, $modulIcon, $modulTarget) = explode('|', $access['modul']);
                        list($menuName, $menuTarget) = explode('|', $firstMenu);
                    @endphp
                    <li class="nav-item mr-25 pb-25">
                        <a class="nav-link dropdown-toggle align-items-center" href="{{ !empty($firstMenu) ? route($modulTarget.'.'.$menuTarget.'.index') : '#' }}">
                            <i class="{{ $modulIcon ?? 'fa fa-folder' }} mt-50 mr-25" style="{!! $prefix == $modulTarget ? 'color: '.$maincolor : '' !!}"
                               aria-hidden="true"></i>
                            <span class="selected-language mb-50" style="font-size: 15px; {{ $prefix == $modulTarget ? "color: ".$maincolor : '' }}">{{ $modulName }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-notification mr-25">
                <a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
                    <i class="ficon" data-feather="bell"></i>
                    {{--                    <span class="badge badge-pill badge-danger badge-up">5</span>--}}
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 mr-auto">Notifications</h4>
                            <div class="badge badge-pill badge-light-primary">0 New</div>
                        </div>
                    </li>
                    <li class="scrollable-container media-list">
                        <a class="d-flex" href="javascript:void(0)">
                            {{--                            <div class="media d-flex align-items-start">--}}
                            {{--                                <div class="media-left">--}}
                            {{--                                    <div class="avatar"><img src="{{ asset('app-assets/images/portrait/small/avatar-s-15.jpg') }}" alt="avatar" width="32" height="32"></div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="media-body">--}}
                            {{--                                    <p class="media-heading"><span class="font-weight-bolder">Congratulation Sam 🎉</span>winner!</p><small class="notification-text"> Won the monthly best seller badge.</small>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </a>
                    </li>
                    <li class="dropdown-menu-footer"><a class="btn btn-primary btn-block" href="javascript:void(0)">Read all notifications</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">{{ Auth::user()->name }}</span>
                        <span class="user-status">{{ Auth::user()->group->name }}</span>
                    </div>
                    <span class="avatar">
                        <img class="round" src="{{ Auth::user()->picture ? asset('storage/'.Auth::user()->picture) : asset('storage/uploads/images/nophoto.png') }}" alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="#"><i class="mr-50" data-feather="user"></i> Profile</a>
                    {{--                    <a class="dropdown-item" href="app-email.html"><i class="mr-50" data-feather="mail"></i> Inbox</a>--}}
                    {{--                    <a class="dropdown-item" href="app-todo.html"><i class="mr-50" data-feather="check-square"></i> Task</a>--}}
                    {{--                    <a class="dropdown-item" href="app-chat.html"><i class="mr-50" data-feather="message-square"></i> Chats</a>--}}
                    {{--                    <div class="dropdown-divider"></div>--}}
                    {{--                    <a class="dropdown-item" href="page-account-settings.html"><i class="mr-50" data-feather="settings"></i> Settings</a>--}}
                    {{--                    <a class="dropdown-item" href="page-pricing.html"><i class="mr-50" data-feather="credit-card"></i> Pricing</a>--}}
                    {{--                    <a class="dropdown-item" href="page-faq.html"><i class="mr-50" data-feather="help-circle"></i> FAQ</a>--}}
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="mr-50" data-feather="power"></i> Logout</a>
                </div>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>
