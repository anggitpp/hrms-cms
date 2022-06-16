@php
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
    list($modul, $menu, $action) = explode(".",$route);
    $action2 = "";
    if(substr_count($route, '.') > 2)
        list($modul, $menu, $action, $action2) = explode(".",$route);
    $targetModul = str_replace('/','',$prefix);
@endphp

<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('app-assets/images/logo/logo.png') }}" width="180"/>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="main-menu-content" style="margin-top: 80px;">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @foreach($accessed[$modul]['submodul'] as $key => $value)
                <li class="navigation-header">
                    <span data-i18n="Apps &amp; Pages">{{ $value }}</span>
                    <i data-feather="more-horizontal"></i>
                </li>
                @foreach($accessed[$modul]['menu'][$key] as $k => $menu)
                    @php
                        list($menuName, $menuTarget, $menuIcon) = explode('|', $menu);
                    @endphp
                    @if(!empty($accessed[$modul]['childMenus']))
                        @if(in_array($k, array_keys($accessed[$modul]['childMenus'])))
                            <li class="nav-item">
                                <a class="d-flex align-items-center" href="#">
                                    <i class="{{ $menuIcon ?? 'fa fa-folder' }}"></i>
                                    <span class="menu-title text-truncate" data-i18n="Invoice">{{ $menuName }}</span>
                                </a>
                                <ul class="menu-content">
                                    @foreach($accessed[$modul]['childMenus'][$k] as $ksub => $vsub)
                                        @php
                                            list($childName, $childTarget, $childIcon) = explode('|', $vsub);
                                            $routeMenu = $action2 ? $targetModul.'.'.$menuTarget.'.'.$action.'.'.$action2 : $targetModul.'.'.$menuTarget.'.'.$action;
                                        @endphp
                                        <li {{ $route == $routeMenu ? 'class=active' : '' }}>
                                            <a class="d-flex align-items-center" href="{{ route($targetModul.'.'.$childTarget.'.index') }}">
                                                <i class="{{ empty($childIcon) ? 'fa fa-folder' : $childIcon }}"></i>
                                                <span class="menu-title text-truncate" data-i18n="Chat">
                                                {{ $childName }}
                                            </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @else
                        @php
                            $routeMenu = $action2 ? $targetModul.'.'.$menuTarget.'.'.$action.'.'.$action2 : $targetModul.'.'.$menuTarget.'.'.$action;
                        @endphp
                        <li class="{{ $route == $routeMenu ? 'active' : '' }} nav-item">
                            <a class="d-flex align-items-center" href="{{ route($targetModul.'.'.$menuTarget.'.index') }}">
                                <i class="{{ empty($menuIcon) ? 'fa fa-folder' : $menuIcon }}"></i>
                                <span class="menu-title text-truncate" data-i18n="Chat">
                                    {{ $menuName }}
                                </span>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endforeach
        </ul>
        <br clear="all"/>
        <br clear="all"/>
        <br clear="all"/>
        <br clear="all"/>
        <br clear="all"/>
        <br clear="all"/>
        <br clear="all"/>
        <br clear="all"/>
    </div>

</div>
