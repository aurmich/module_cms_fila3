<div class="space-y-6">
    <!-- Header con info paziente -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center space-x-3">
            <x-heroicon-o-user-circle class="h-8 w-8 text-blue-500" />
            <div>
                <h3 class="font-medium text-blue-900">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
                <p class="text-sm text-blue-600">
                    Nato il {{ $patient->date_of_birth?->format('d/m/Y') }}
                    @if($patient->phone) • Tel: {{ $patient->phone }} @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Griglia documenti -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($attachments as $type)
            @php
                $hasAttachment = $patient->hasAttachment($type);
                $label = $labels[$type];
                $isRequired = in_array($type, ['health_card', 'identity_document']);
            @endphp

            <div class="border rounded-lg p-4 {{ $hasAttachment ? 'border-green-200 bg-green-50' : ($isRequired ? 'border-red-200 bg-red-50' : 'border-gray-200 bg-gray-50') }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        @if($hasAttachment)
                            <x-heroicon-o-document-check class="h-8 w-8 text-green-500" />
                        @elseif($isRequired)
                            <x-heroicon-o-exclamation-triangle class="h-8 w-8 text-red-500" />
                        @else
                            <x-heroicon-o-document-minus class="h-8 w-8 text-gray-400" />
                        @endif

                        <div>
                            <h3 class="font-medium text-gray-900 flex items-center">
                                {{ $label }}
                                @if($isRequired)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Obbligatorio
                                    </span>
                                @endif
                            </h3>
                            <p class="text-sm {{ $hasAttachment ? 'text-green-600' : ($isRequired ? 'text-red-600' : 'text-gray-500') }}">
                                @if($hasAttachment)
                                    Documento allegato
                                @elseif($isRequired)
                                    Documento obbligatorio mancante
                                @else
                                    Documento opzionale non allegato
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($hasAttachment)
                        <button
                            onclick="window.open('{{ $patient->getAttachmentUrl($type) }}', '_blank')"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                        >
                            <x-heroicon-o-eye class="h-4 w-4 mr-1" />
                            Visualizza
                        </button>
                    @endif
                </div>

                @if($hasAttachment)
                    @php $media = $patient->getFirstMedia($type); @endphp
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>{{ $media->file_name }}</span>
                            <span>{{ number_format($media->size / 1024, 1) }} KB</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-500 mt-1">
                            <span>Caricato il {{ $media->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

</div>