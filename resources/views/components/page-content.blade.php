<<<<<<< HEAD
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
=======
@props(['blocks' => []])

@if(!empty($blocks))
    @foreach($blocks as $block)
        @if(isset($block->view) && view()->exists($block->view))
            @include($block->view, array_merge(['block' => $block], (array) ($block->data ?? [])))
        @else
            @if(config('app.debug'))
                <div class="alert alert-warning">
                    {{ __('cms::messages.block_view_not_found', ['view' => $block->view ?? 'undefined']) }}
                </div>
            @endif
        @endif
    @endforeach
@endif
>>>>>>> f1c9277 (.)

