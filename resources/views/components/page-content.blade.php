@foreach($blocks as $block)
    {{--
    <x-dynamic-component component="blocks.ticket-list.agid" />
    --}}
    @include($block['data']['view'],$block['data'])
@endforeach

