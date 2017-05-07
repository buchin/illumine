<div class="wrap">
    <div id="icon-options-general" class="icon32"></div>
    <h1>
        <strong>Illumine</strong> > {{ $config->get('namespace') }}
    </h1>
    @yield('content')
</div>

<style type="text/css">
    /* No Need to Enqueue, Inline is Faster */
    .illumine-list-group {
        padding: 0;
        margin: 0;
        box-shadow: 0 1px 2px #ccc;
    }

    .illumine-list-group li.active a {
        background: #0073aa;
        color: #fff;
    }

    .illumine-list-group li {
        padding: 0;
        margin: 0;
        border-bottom: 1px solid #eee;
    }

    .illumine-list-group li:last-of-type {
        overflow: hidden;
        border: none;
    }

    .illumine-list-group li a,
    .illumine-list-group li h6 {
        display: block;
        padding: 0 20px;
        line-height: 35px;
        margin: 0;
        font-size: 14px;
        background-color: #f9f9f9;
    }

    .illumine-list-group li h6 {
        font-size: 15px;
    }

    @media (max-width: 782px) {

        .illumine-table-scrollable {
            overflow-x: auto;
            display: inline-block;
            width: auto;
            max-width: 100%;
        }

        .illumine-table-scrollable > * > tr > th,
        .illumine-table-scrollable > * > tr > td {
            white-space: nowrap;
            display: table-cell;
        }
    }

</style>