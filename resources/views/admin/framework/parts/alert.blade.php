@if(isset($alertMessage) || isset($messages))
    <div class="notice notice-{{ (isset($alertClass) ? $alertClass : 'info') }} is-dismissible">
        @if (count($messages) > 0)
            <ul style="text-align: left;">
                @foreach ($messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span>
        </button>
    </div>
@endif