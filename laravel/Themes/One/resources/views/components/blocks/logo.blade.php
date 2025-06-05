@props([
    'src' => null,
    'alt' => '',
    'width' => null,
    'height' => null,
    'icon' => null,
    'size' => 'h-12 w-auto',
    'url' => null,
    'title' => null,
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 p-4 flex items-center space-x-3']) }}>
    @if($icon)
        <x-filament::icon :name="$icon" :class="$size" class="text-primary-600 dark:text-primary-400" />
    @elseif($src)
        <img src="{{ $_theme->asset($src) }}" alt="{{ $alt }}" @if($width) width="{{ $width }}" @endif @if($height) height="{{ $height }}" @endif class="{{ $size }}" />
    @endif

    @if($title || $description)
        <div class="flex flex-col">
            @if($title)
                <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $title }}</span>
            @endif
            @if($description)
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $description }}</span>
            @endif
        </div>
    @endif
</div>
