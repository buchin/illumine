<h2>Routing Details</h2>
<table class="widefat illumine-table-scrollable">
    <thead>
    <tr>
        <th class="row-title">
            Uri / Name
        </th>
        <th class="row-title">
            Protocol / Methods
        </th>
        <th class="row-title">
            Action / Middleware
        </th>
    </tr>
    </thead>
    <tbody>

    <?php $count = count($routes->getRoutes()); ?>
    @foreach($routes->getRoutes() as $key => $route)

        @if(!empty($route))
            <tr @if($count % 2 == 0) class="alternate" @endif>

                <td>
                    <code>{!! $route->uri() !!}</code><br>
                    @if(!empty($route->getName()))
                        Name:<strong> {{ $route->getName() }}</strong>
                    @else
                        -
                    @endif
                </td>
                <td>
                    <strong>@if($route->secure()) HTTPS @else HTTP @endif</strong><br>
                    @foreach($route->methods() as $index =>  $method)
                        @if($index > 0) | @endif {{ $method }}
                    @endforeach
                </td>
                <td>
                    <strong>{{ $route->getActionName() }}</strong><br>
                    @foreach($route->middleware() as $index => $middleware)

                        @if($index < (count($route->middleware()) - 1)) &#9507; @else &#9495; @endif {{ $middleware }}
                        <br/>
                    @endforeach
                </td>
            </tr>
        @endif
        <?php  $count--; ?>
    @endforeach
    </tbody>
</table>

