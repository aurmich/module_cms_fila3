@foreach($blocks as $block)
    @include($block->view,$block->data)
@endforeach

