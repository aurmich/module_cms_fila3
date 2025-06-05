@props([
    'title' => 'Azioni Rapide',
    'columns' => 4,
    'links' => [],
])

@php
    // Mappatura delle classi per la griglia in base al numero di colonne
    $gridClasses = [
        1 => 'grid-cols-1',
        2 => 'grid-cols-1 md:grid-cols-2',
        3 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
    ][$columns] ?? 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4';
    
    // Assicuriamoci che links sia sempre un array
    $links = is_array($links) ? $links : [];
@endphp

<div class="bg-white py-12 sm:py-16">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        @if($title)
            <div class="mx-auto max-w-2xl text-center mb-12">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $title }}</h2>
            </div>
        @endif
        
        <div class="grid {{ $gridClasses }} gap-6 lg:gap-8">
            @foreach($links as $link)
                @php
                    $icon = $link['icon'] ?? null;
                    $title = $link['title'] ?? '';
                    $url = $link['url'] ?? '#';
                    $description = $link['description'] ?? null;
                    $badge = $link['badge'] ?? null;
                    $badgeColor = $link['badge_color'] ?? 'bg-blue-100 text-blue-800';
                @endphp
                
                <a href="{{ $url }}" class="group relative bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg border border-gray-100 hover:border-blue-200 transition-all duration-200 hover:shadow-md">
                    <div class="flex flex-col items-center text-center">
                        @if($icon)
                            <div class="inline-flex items-center justify-center rounded-lg bg-blue-50 p-3 ring-4 ring-white">
                                <i class="{{ $icon }} h-6 w-6 text-blue-600" aria-hidden="true"></i>
                            </div>
                        @endif
                        
                        <div class="mt-4">
                            <h3 class="text-base font-semibold text-gray-900">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ $title }}
                            </h3>
                            @if(isset($description))
                                <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
                            @endif
                        </div>
                        
                        @if(isset($badge))
                            <span class="mt-4 inline-flex items-center rounded-md px-2.5 py-0.5 text-sm font-medium {{ $badgeColor }}">
                                {{ $badge }}
                            </span>
                        @endif
                    </div>
                    <span class="pointer-events-none absolute right-6 top-6 text-gray-300 group-hover:text-blue-400" aria-hidden="true">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                        </svg>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>
