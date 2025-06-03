@props([
    'section' => null,
    'blocks' => [],
    'class' => ''
])

@php
    $locale = app()->getLocale();
    $componentsBlocks = is_array($blocks) && isset($blocks[$locale]) ? $blocks[$locale] : $blocks;
@endphp

<footer {{ $attributes->merge([
    'class' => 'bg-[#1A467F] text-white' . ($section['attributes']['class'] ?? '') . ' ' . $class,
    'id' => ($section['attributes']['id'] ?? '')
]) }}>
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-12">
            <!-- Colonna Logo e Descrizione -->
            <div class="space-y-6 flex-col justify-center">
                <img src="/img/saluteOra-new-logo.png" alt="{{ config('app.name') }}" class="h-24 w-auto">
                <p class="text-medium text-white">
                    Promuoviamo la salute orale delle gestanti attraverso prevenzione e assistenza specialistica Test.
                </p>
            </div>

            <!-- Colonne Dinamiche dai Blocchi -->
            @if($section && isset($section->blocks[app()->getLocale()]))
                @foreach($section->blocks[app()->getLocale()] as $block)
                    @if($block->type === 'navigation')
                        <div>
                            <h3 class="text-lg font-semibold mb-6">{{ $block->data['title'] }}</h3>
                            <ul class="space-y-4">
                                @foreach($block->data['items'] as $item)
                                    <li>
                                        <a href="{{ url($item['url']) }}" class="text-sm hover:text-primary-400 transition-colors">
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif

            <!-- Colonna Newsletter -->
            <div>
                <h3 class="text-lg font-semibold mb-6">Newsletter</h3>
                <p class="text-sm text-white mb-4">
                    Iscriviti per ricevere aggiornamenti e consigli sulla salute orale.
                </p>
                <form class="space-y-4 flex flex-col justify-center">
                    <input type="email" placeholder="La tua email" class="input input-bordered w-full bg-neutral-focus text-black" />
                    <div class="flex justify-center">
                        <button type="submit" class="rounded-md bg-[#0D9488] w-auto px-3.5 py-2.5 text-xl font-semibold text-white">Iscriviti</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Copyright e Link Legali -->
        <div class="mt-12 pt-8 border-t border-neutral-focus">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-center md:text-left">
                    <p class="text-sm text-white">&copy; {{ date('Y') }} {{ config('app.name') }}. Tutti i diritti riservati.</p>
                </div>
                <div class="text-center md:text-right space-x-4">
                    <a href="{{ url('privacy') }}" class="text-[#0D9488] text-sm hover:text-primary-400 transition-colors">Privacy Policy</a>
                    <a href="{{ url('terms') }}" class="text-[#0D9488] text-sm hover:text-primary-400 transition-colors">Termini e Condizioni</a>
                    <a href="{{ url('cookies') }}" class="text-[#0D9488] text-sm hover:text-primary-400 transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>