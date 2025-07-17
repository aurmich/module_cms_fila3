<div class="w-full flex flex-col justify-center items-center">
    <div class="w-full flex justify-center p-10">
        <h1>{{ $title }}</h1>
    </div>

@foreach ($sections as $section)
    <div class="w-full lg:w-2/4 grid grid-cols-1 lg:grid-cols-2 gap-4 justify-center items-center p-10">
        <div class="flex justify-center">
            <a href="{{ $section['url'] }}">
                <img class="{{ $section['img_class'] }}" src="{{ $section['img'] }}" />
            </a>
        </div>
            <span class="ml-0 lg:ml-5 text-lg">
            {{ $section['description'] }}
            </span>
    </div>
@endforeach
</div>