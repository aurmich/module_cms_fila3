<div class="w-full">
    <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">{{ $documentTitle }}</h3>
        <a
            href="{{ $pdfUrl }}"
            target="_blank"
            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
        >
            <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4 mr-1" />
            Apri in nuova finestra
        </a>
    </div>

    <div class="border rounded-lg overflow-hidden" style="height: 600px;">
        <iframe
            src="{{ $pdfUrl }}"
            class="w-full h-full"
            title="PDF Viewer - {{ $documentTitle }}"
            frameborder="0"
        >
            <div class="flex items-center justify-center h-full bg-gray-50">
                <div class="text-center">
                    <x-heroicon-o-document-text class="mx-auto h-12 w-12 text-gray-400" />
                    <p class="mt-2 text-sm text-gray-600">Il tuo browser non supporta la visualizzazione di PDF inline.</p>
                    <p class="mt-1">
                        <a href="{{ $pdfUrl }}" target="_blank" class="text-primary-600 hover:text-primary-500">
                            Clicca qui per aprire il PDF in una nuova finestra
                        </a>
                    </p>
                </div>
            </div>
        </iframe>
    </div>
</div>