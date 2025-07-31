<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};
use Filament\Notifications\Notification;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Actions\Action;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Livewire\Volt\Component;
use Modules\Tenant\Services\TenantService;
use Modules\Cms\Models\Page;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

/** @var array */
//$middleware=TenantService::config('middleware');
//$base_middleware=Arr::get($middleware,'base',[]);

$base_middleware=[];

name('pages.view');
/*
if(isset($slug)){
    $middleware=Page::getMiddlewareBySlug($slug);
    middleware($middleware);
}
*/
middleware(PageSlugMiddleware::class);

new class extends Component
{
    public string $slug;
};
?>
<x-layouts.marketing>

    <div
        x-data="{loggedIn:true}"
        class="max-w-[calc(100%-30px)] sm:max-w-[calc(100%-80px)] lg:max-w-[996px] mx-auto pb-12 font-roboto"
        >
        @if($page)
            <div class="py-10">
                <h1 class="text-[2rem] mb-4 font-roboto font-semibold text-neutral-5">
                    {{ $page->title }}
                </h1>
            </div>

            {{-- {{ dddx([
                $_theme->showPageSidebarContent($page->title),
                $_theme->showPageContent($page->title),
                $page->sidebar_blocks,
                $page->content_blocks
                ]) }} --}}
            {{-- {{ dddx($page->content_blocks) }} --}}
            @if(!empty($page->sidebar_blocks))
                <div class="grid grid-cols-1 lg:grid-cols-[21.25rem,1fr] gap-4">
                    <div class="space-y-6">
                        {{ $_theme->showPageSidebarContent($page->slug) }}
                    </div>

                    {{ $_theme->showPageContent($page->slug) }}
                </div>

            @else
                {{-- what is the css to make the whole block unsplit? --}}
                <div>
                    {{ $_theme->showPageContent($page->slug) }}
                </div>
            @endif
        @else
            <div class="flex flex-col items-center justify-center py-8 space-y-4">
                <div>
                    <img class="max-w-lg" src="https://error404.fun/img/full-preview/1x/3.png" alt="">
                </div>
                <div class="space-y-2 text-center">
                    <h2 class="text-2xl font-bold md:text-4xl lg:text-6xl">Whooops!</h2>
                    <p class="text-gray-400">{{ __('pub_theme::404.no_article') }}</p>
                </div>
            </div>
        @endif
    </div>
</x-layouts.marketing>
