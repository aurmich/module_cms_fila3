@props(['title', 'description' => null, 'stats' => []])

<div class="mx-auto max-w-2xl lg:text-center">
    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $title }}</h2>
    @if ($description)
        <p class="mt-6 text-lg leading-8 text-gray-600">{{ $description }}</p>
    @endif
</div>

<div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
        @foreach ($stats as $stat)
            <div class="flex flex-col">
                <dt class="text-base leading-7 text-gray-600">{{ $stat['label'] ?? '' }}</dt>
                <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                    {{ $stat['value'] ?? '0' }}
                </dd>
            </div>
        @endforeach
    </dl>
</div>
