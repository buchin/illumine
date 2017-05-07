<h2>Cache Management</h2>

<table class="widefat">
    <thead>
    <tr>
        <th class="row-title">
            Storage Type
        </th>
        <th>
            Disk Usage
        </th>
        <th>
            Management
        </th>
    </tr>
    </thead>
    <tbody>
    @if($config->get('session.enabled'))
        <tr>
            <td class="row-title">
                <label for="tablecell">
                    Session Storage
                </label>
            </td>
            <td>
                {!! $sizes['sessions'] !!}
            </td>
            <td>
                <a href="?page={{ str_slug($config->get('namespace')) }}&tab=cache&_flush=sessions"
                   class="button-primary">Flush</a>
            </td>
        </tr>
    @endif
    @if($config->get('cache.enabled'))
        <tr class="alternate">
            <td class="row-title">
                <label for="tablecell">
                    Object Cache
                </label>
            </td>
            <td>
                {!! $sizes['objects'] !!}
            </td>
            <td>
                <a href="?page={{ str_slug($config->get('namespace')) }}&tab=cache&_flush=objects"
                   class="button-primary">Flush</a>
            </td>
        </tr>
    @endif
    @if($config->get('routes.enabled') && $config->get('routes.cache'))
        <tr>
            <td class="row-title">
                <label for="tablecell">
                    Route Collection Cache
                </label>
            </td>
            <td>
                {!! $sizes['routes'] !!}
            </td>
            <td>
                <a href="?page={{ str_slug($config->get('namespace')) }}&tab=cache&_flush=routes"
                   class="button-primary">Flush</a>
            </td>
        </tr>
    @endif
    <tr class="alternate">
        <td class="row-title">
            <label for="tablecell">
                Blade View Cache
            </label>
        </td>
        <td>
            {!! $sizes['views'] !!}
        </td>
        <td>
            <a href="?page={{ str_slug($config->get('namespace')) }}&tab=cache&_flush=views" class="button-primary">Flush</a>
        </td>
    </tr>
    </tbody>
</table>

<p>
    <small>**Caches will regenerate themselves according to your configuration file.</small>
</p>



