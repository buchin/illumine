@extends('admin.framework.layout')
@section('content')

    <h2 class="nav-tab-wrapper">
        <a href="?page={{ $request->get('page') }}&tab=docs"
           class="nav-tab @if(!$request->has('tab') || $request->get('tab') == 'docs') nav-tab-active @endif">Documentation</a>
        <a href="?page={{ $request->get('page') }}&tab=config"
           class="nav-tab @if($request->get('tab') == 'config') nav-tab-active @endif">Config</a>
        @if($config->get('routes.enabled'))<a href="?page={{ $request->get('page') }}&tab=routes"
                                              class="nav-tab @if($request->get('tab') == 'routes') nav-tab-active @endif">Routes</a>@endif
        <a href="?page={{ $request->get('page') }}&tab=cache"
           class="nav-tab @if($request->get('tab') == 'cache') nav-tab-active @endif">Cache</a>
    </h2>
    <div id="poststuff">
        @include('admin.framework.parts.alert')
        @include('admin.framework.tabs.'.($request->get('tab') ? $request->get('tab') : 'docs'))
        <br class="clear">
    </div>
@endsection