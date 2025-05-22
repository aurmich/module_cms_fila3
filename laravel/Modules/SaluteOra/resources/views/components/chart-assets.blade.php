{{--
    Componente per il caricamento degli asset dei grafici
    Questo componente deve essere incluso in tutte le pagine che utilizzano i grafici
--}}

@push('scripts')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    {{-- Plugin per i colori personalizzati --}}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
    
    {{-- Plugin per le etichette --}}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    
    {{-- Script personalizzato per l'inizializzazione dei grafici --}}
    <script src="{{ \Nwidart\Modules\Facades\Module::asset('Reporting:js/charts.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ \Nwidart\Modules\Facades\Module::asset('Reporting:css/charts.css') }}" rel="stylesheet">
@endpush
