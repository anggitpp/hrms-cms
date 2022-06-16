@extends('app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Data</h4>
            <div>
                <button type="reset" class="btn btn-primary mr-1" onclick="document.getElementById('form').submit();">
                    Submit
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">Cancel</a>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist" style="border-bottom: 1px solid; color: #DFDFDF;">
                @foreach($moduls as $key => $modul)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="home-tab" data-toggle="tab"
                           href="#{{ $modul->target }}"
                           aria-controls="{{ $modul->target }}" role="tab" aria-selected="true">{{ $modul->name }}</a>
                    </li>
                @endforeach
            </ul>
            <form class="form form-vertical" id="form" method="POST"
                  action="{{ route('settings.accesses.update', $group->id) }}">
                @method('PATCH')
                <div class="tab-content">
                    @foreach($moduls as $key => $modul)
                        <div role="{{ $loop->first ? 'tabpanel' : 'tab-pane' }}"
                             class="tab-pane {{ $loop->first ? 'active' : '' }}"
                             id="{{ $modul->target }}" aria-labelledby="{{ $modul->target }}-tab"
                             aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                            <ul class="nav nav-pills">
                                @foreach($modul->submodul as $k => $submoduls)
                                    <li class="nav-item">
                                        <a
                                            class="nav-link{{ $loop->first ? ' active' : '' }}"
                                            data-toggle="pill"
                                            href="#{{ $modul->target."-".$submoduls->id }}"
                                            aria-expanded="true">
                                            {{ $submoduls->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($modul->submodul as $k => $submoduls)
                                    <div
                                        role="tabpanel"
                                        class="tab-pane{{ $loop->first ? ' active' : '' }}"
                                        id="{{ $modul->target."-".$submoduls->id }}"
                                        aria-labelledby="{{ $modul->target."-".$submoduls->id }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                        @foreach($submoduls->menu as $kmenu => $vmenu)
                                            <div class="table-responsive border rounded mt-1">
                                                <h6 class="py-1 mx-1 mb-0 font-medium-2">
                                                    {{ $vmenu->name }}
                                                    <i data-feather="lock" class="font-medium-3 mr-25"></i>
                                                    <span class="align-middle"></span>
                                                </h6>
                                                <table class="table table-striped table-borderless">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th width="*">Permission</th>
                                                        <th width="10%">Method</th>
                                                        <th width="10%">Param</th>
                                                        <th width="5%"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @csrf
                                                    @foreach($vmenu->menuAccess->where('type', NULL) as $kaccess => $vaccess)
                                                        <tr>
                                                            <td>{{ $vaccess->name }}</td>
                                                            <td>{{ $vaccess->method }}</td>
                                                            <td>{{ $vaccess->param }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           value="{{ $key }}"
                                                                           name="access[{{ $vmenu->id }}_{{ $vaccess->name }}]"
                                                                           id="access[{{ $vmenu->id }}_{{ $vaccess->name }}]"
                                                                        {{ !empty($menuAccesses[$vmenu->id][$vaccess->name]) ? "checked" : "" }}
                                                                    />
                                                                    <label class="custom-control-label"
                                                                           for="access[{{ $vmenu->id }}_{{ $vaccess->name }}]"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
@endsection
