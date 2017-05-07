<h2>Configuration Details</h2>
<table class="widefat">
    <thead>
    <tr>
        <th class="row-title">
            Key
        </th>
        <th>
            Value(s)
        </th>
    </tr>
    </thead>
    <tbody>
    @php $count = count($config->all()); @endphp

    @foreach($config->all() as $key => $items)
        @if(count($items))
            <tr @if($count % 2 == 0) class="alternate" @endif>

                <td class="row-title">
                    <label for="tablecell">
                        {{$key}}
                    </label>
                </td>
                <td>
                    @if(is_array($items)  || $key == 'view')
                        @foreach($items as $key2 => $items2)
                            @if(is_array($items2))

                                @if($key2 != 'lottery')

                                    <strong>{{ $key2 }}: </strong><br/>
                                    @foreach($items2 as $key3 => $items3)

                                        @if(is_array($items3))

                                            &nbsp;&nbsp;&nbsp;<strong>{{ $key3 }}: </strong><br/>

                                            @php
                                                $index = 0; //Set Index
                                            @endphp

                                            @foreach($items3 as $key4 => $items4)

                                                @if(!is_null($items4))
                                                    &nbsp;&nbsp;&nbsp; @if($index < (count($items4))) &#9507; @else
                                                        &#9495; @endif <strong>{{ $key4 }}: </strong> {{$items4}}<br/>
                                                @endif

                                                @php
                                                    $index++; //Increment
                                                @endphp

                                            @endforeach
                                        @elseif(is_bool($items3))
                                            <strong>{{ $key3 }}: </strong>
                                            {{var_export($items3, true)}}
                                        @elseif(!is_null($items3))
                                            <strong>{{ $key3 }}: </strong>
                                            {{$items3}}<br/>
                                        @endif

                                    @endforeach
                                @else
                                    <strong>{{ $key2 }}: </strong>
                                    {{$items2[0]}} ~ {{$items2[1]}} <br/>
                                @endif


                            @elseif(is_bool($items2))
                                <strong>{{ $key2 }}: </strong>
                                {{var_export($items2, true)}} <br/>
                            @elseif(!is_null($items2))
                                <strong>{{ $key2 }}: </strong>
                                {{$items2}}<br/>
                            @endif

                        @endforeach

                    @elseif(is_bool($items))
                        {{var_export($items, true)}}
                    @else
                        {{$items}}
                    @endif
                </td>
            </tr>
        @endif
        @php
            $count--;
        @endphp
    @endforeach
    </tbody>
</table>


