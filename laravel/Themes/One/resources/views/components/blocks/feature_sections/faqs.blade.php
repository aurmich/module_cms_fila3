<div class="flex flex-col justify-center items-center">
<!-- Page title -->
    <div class="p-10 w-full flex justify-center">
        <h1 class="text-center">{{ $title }}</h1>
    </div>

    <!-- FAQ Content -->
    <div class="w-full lg:w-2/4 flex flex-col justify-center p-5">

        <!-- FAQ Item -->
        @foreach ($sections as $section)
        <div class="mt-5">
            <h3 class="text-[#272C4D]">{{ $section['title'] }}</h3>
            <p class="text-[#272C4D] pt-2">
                {!! $section['description'] !!}
            </p>
        </div>
        @endforeach
    </div>
</div>