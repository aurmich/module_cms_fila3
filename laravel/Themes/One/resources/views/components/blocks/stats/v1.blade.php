@props([
    'title',
    'stats' => []
])

<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $title }}</h2>
            @if(isset($description))
                <p class="mt-6 text-lg leading-8 text-gray-600">{{ $description }}</p>
            @endif
        </div>
        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
            <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-3">
                @foreach($stats as $stat)
                    <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                        <dt class="text-base leading-7 text-gray-600">{{ $stat['label'] }}</dt>
                        <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                            {{ $stat['number'] }}
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</div>
