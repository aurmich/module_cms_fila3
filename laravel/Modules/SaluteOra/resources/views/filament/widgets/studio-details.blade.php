<div class="p-4 mt-4 bg-gray-50 rounded-lg">
    <h3 class="text-lg font-medium text-gray-900">{{ $studio->name ?? 'Nessuno studio selezionato' }}</h3>
    
    @if($studio)
        @if($studioAddress = $this->studioAddress)
            <div class="mt-2 text-sm text-gray-600">
                <p>{{ $studioAddress }}</p>
            </div>
        @endif
        
        @if($studio->phone)
            <div class="mt-2 text-sm text-gray-600">
                <span class="font-medium">Telefono:</span> {{ $studio->phone }}
            </div>
        @endif
        
        @if($studio->email)
            <div class="mt-1 text-sm text-gray-600">
                <span class="font-medium">Email:</span> {{ $studio->email }}
            </div>
        @endif
        
        @if($studio->website)
            <div class="mt-1 text-sm text-gray-600">
                <span class="font-medium">Sito web:</span> 
                <a href="{{ $studio->website }}" target="_blank" class="text-primary-600 hover:underline">
                    {{ $studio->website }}
                </a>
            </div>
        @endif
        
        @if($doctors->isNotEmpty())
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700">Medici in questo studio:</h4>
                <ul class="mt-2 space-y-1">
                    @foreach($doctors as $doctor)
                        <li class="text-sm text-gray-600">
                            {{ $doctor->full_name }}
                            @if($doctor->specializations->isNotEmpty())
                                <span class="text-xs text-gray-500">
                                    ({{ $doctor->specializations->pluck('name')->implode(', ') }})
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif
</div>
