@foreach($blocks as $block)
    {{--
    <x-dynamic-component component="blocks.ticket-list.agid" />
    --}}
<<<<<<< HEAD
    @include($block->view,$block->data)
=======
    @include($block['data']['view'],$block['data'])
>>>>>>> feb96d7 (.)
@endforeach

