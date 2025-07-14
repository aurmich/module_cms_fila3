<div class="flex flex-col justify-center items-center">
<!-- Call to Action Box -->
        <div class="mt-5">
            <h3 class="text-[#FF5F7E]">
                {!! $title !!}
            </h3>

            <div class="pt-5 flex flex-col lg:flex-row justify-center items-center">
                @foreach ($sections as $section)
                <!-- Card 1 -->
                <div class="w-64 h-44 bg-cover bg-[#FCD5D0] rounded-[25px] shadow-2xl m-5">
                    <div class="grid grid-cols-2">
                        <div class="flex justify-center">
                            <img class="h-44 px-2 pt-2" src="{{ $section['img'] }}" />
                        </div>
                        <a href="{{ $section['url'] }}">
                        <div class="flex flex-col items-center justify-center">
                            <span class="text-[#FF5F7E] text-xl lg:text-2xl">
                               {!! $section['title'] !!}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="#FF5F7E" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499" />
                            </svg>
                        </div>
                        </a>
                    </div>
                </div>
                @endforeach
                {{--  
                <!-- Card 2 -->
                <div class="w-64 h-44 bg-[#FCD5D0] rounded-[25px] shadow-2xl m-5">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex justify-center">
                            <img class="h-44 p-2" src="/img/dentist.png" />
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <span class="text-[#FF5F7E] text-xl lg:text-2xl">
                                Vai <br /> alla <br /> guida
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="#FF5F7E" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499" />
                            </svg>
                        </div>
                    </div>
                </div>
                --}}
            </div>
        </div>
    </div>