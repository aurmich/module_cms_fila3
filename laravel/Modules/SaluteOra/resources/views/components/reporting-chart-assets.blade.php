{{-- 
    Componente per caricare gli asset necessari per i grafici del modulo Reporting.
    Questo componente include tutti gli script JS e CSS necessari per rendere i grafici
    utilizzati nel modulo Reporting.
--}}
<div>
    {{-- Script per i grafici --}}
    <script src="{{ asset('modules/reporting/js/chart.min.js') }}" defer></script>
    <script src="{{ asset('modules/reporting/js/chartjs-plugin-datalabels.min.js') }}" defer></script>
    
    {{-- Stili per i grafici --}}
    <link rel="stylesheet" href="{{ asset('modules/reporting/css/chart-styles.css') }}">
    
    {{-- Script di inizializzazione per i grafici --}}
    <script>
        // Configurazione globale per i grafici
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Chart !== 'undefined') {
                // Registrazione del plugin datalabels se esiste
                if (typeof ChartDataLabels !== 'undefined') {
                    Chart.register(ChartDataLabels);
                }
                
                // Impostazioni globali predefinite
                Chart.defaults.font.family = "'Inter', 'Helvetica', 'Arial', sans-serif";
                Chart.defaults.color = '#6b7280';
                Chart.defaults.scale.grid.color = 'rgba(107, 114, 128, 0.1)';
            }
        });
    </script>
</div>
