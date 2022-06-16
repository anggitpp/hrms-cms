@php
    $route = Route::current()->getName();
    list($modul, $menu, $action) = explode(".",$route);

    $arrAction = array(
        "index" => "View",
        "create" => "Create Data",
        "edit" => "Edit Data",
    );

    list($modulName, $modulIcon, $modulTarget) = explode("|", $accessed[$modul]['modul']);
@endphp
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">{{ ucwords($arrMenu['name']) }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ ucwords($modulName) }}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">{{ ucwords($arrMenu['name']) }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $arrAction[$action] ?? ucwords($action) }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
