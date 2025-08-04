@foreach($blocks as $block)
    {{--
    <x-dynamic-component component="blocks.ticket-list.agid" />
    --}}
    @include($block->view,$block->data)
@endforeach

