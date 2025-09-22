<<<<<<< HEAD
<?php

declare(strict_types=1);

?>
@foreach($blocks as $block)
    @include($block->view,$block->data)
@endforeach
=======
@foreach($blocks as $block)
    @include($block->view,$block->data)
@endforeach

>>>>>>> bc33217 (.)
