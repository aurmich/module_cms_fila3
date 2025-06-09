@props(['url', 'name', 'icon' => 'heroicon-o-document-text'])

<a href="{{ $url }}" target="_blank" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-500">
    <x-dynamic-component :component="$icon" class="w-5 h-5" />
    <span>{{ $name }}</span>
</a>
