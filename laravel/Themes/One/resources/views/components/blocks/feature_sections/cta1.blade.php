<div class="w-full flex flex-col justify-center items-center p-5">
    <div class="w-full lg:w-3/4 flex flex-col items-start">
        @foreach ($sections as $section)
            <div class="flex flex-col lg:flex-row items-baseline">
                <p class="pt-4">{{ $section['title'] }}</p>
                <a href="{{ $section['cta_link'] }}"><strong>{{ $section['cta_text'] }}</strong></a>
            </div>
        @endforeach
    </div>
</div>