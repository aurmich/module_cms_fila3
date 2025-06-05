# Colli di Bottiglia e Soluzioni - Modulo Dental

## Panoramica
Questo documento identifica i principali colli di bottiglia nel modulo Dental e fornisce soluzioni dettagliate passo per passo per risolverli.

## 1. Performance delle Query sui Trattamenti

### Problema
Le query sui trattamenti dentali, specialmente quando filtrate per paziente, dottore e tipo di trattamento, possono diventare lente con l'aumentare del volume dei dati.

### Impatto
- Rallentamento delle pagine di visualizzazione trattamenti
- Tempi di risposta elevati nella dashboard
- Esperienza utente degradata

### Soluzione Passo-Passo

1. **Ottimizzare gli Indici della Tabella Trattamenti**

```php
// Crea una migrazione per ottimizzare la tabella treatments
php artisan make:migration optimize_dental_treatments_table

// Implementazione
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptimizeDentalTreatmentsTable extends Migration
{
    public function up()
    {
        Schema::table('dental_treatments', function (Blueprint $table) {
            // Aggiungi indici composti per migliorare le performance delle query più comuni
            $table->index(['patient_id', 'doctor_id', 'type']);
            $table->index(['status', 'scheduled_at']);
            $table->index(['created_at']);
        });
    }
    
    public function down()
    {
        Schema::table('dental_treatments', function (Blueprint $table) {
            $table->dropIndex(['patient_id', 'doctor_id', 'type']);
            $table->dropIndex(['status', 'scheduled_at']);
            $table->dropIndex(['created_at']);
        });
    }
}
```

2. **Implementare Caching per le Query Frequenti**

```php
// In Modules\Dental\app\Repositories\TreatmentRepository.php
namespace Modules\Dental\app\Repositories;

use Illuminate\Support\Facades\Cache;
use Modules\Dental\app\Models\Treatment;

class TreatmentRepository
{
    public function getTreatmentsByPatient($patientId)
    {
        $cacheKey = "patient_treatments_{$patientId}";
        
        return Cache::remember($cacheKey, 300, function () use ($patientId) {
            return Treatment::with(['doctor', 'procedures'])
                ->where('patient_id', $patientId)
                ->orderBy('scheduled_at', 'desc')
                ->get();
        });
    }
    
    public function getDoctorSchedule($doctorId, $date)
    {
        $cacheKey = "doctor_schedule_{$doctorId}_{$date->format('Y-m-d')}";
        
        return Cache::remember($cacheKey, 300, function () use ($doctorId, $date) {
            return Treatment::where('doctor_id', $doctorId)
                ->whereDate('scheduled_at', $date)
                ->orderBy('scheduled_at')
                ->get();
        });
    }
}
```

3. **Ottimizzare le Relazioni Eloquent**

```php
// In Modules\Dental\app\Models\Treatment.php
namespace Modules\Dental\app\Models;

use Modules\Xot\Models\XotBaseModel;

class Treatment extends XotBaseModel
{
    // Definisci relazioni con eager loading predefinito
    protected $with = ['procedures'];
    
    // Definisci relazioni che potrebbero essere caricate in modo differito
    public function doctor()
    {
        return $this->belongsTo(Doctor::class)->withDefault();
    }
    
    public function patient()
    {
        return $this->belongsTo(Patient::class)->withDefault();
    }
    
    // Definisci uno scope per ottimizzare le query comuni
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'scheduled')
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at');
    }
}
```

## 2. Generazione Inefficiente dei Preventivi

### Problema
La generazione di preventivi complessi con molti trattamenti e opzioni può essere lenta e consumare molte risorse.

### Impatto
- Tempi di attesa lunghi per i pazienti
- Carico elevato sul server durante i picchi di utilizzo
- Possibili timeout nelle richieste

### Soluzione Passo-Passo

1. **Implementare Generazione Asincrona dei Preventivi**

```php
// In Modules\Dental\app\Jobs\GenerateQuoteJob.php
namespace Modules\Dental\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Dental\app\Models\Quote;
use Modules\Dental\app\Services\QuoteService;

class GenerateQuoteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $quoteId;
    protected $options;

    public function __construct($quoteId, $options = [])
    {
        $this->quoteId = $quoteId;
        $this->options = $options;
    }

    public function handle(QuoteService $quoteService)
    {
        $quote = Quote::findOrFail($this->quoteId);
        $quoteService->generateQuoteDetails($quote, $this->options);
        
        // Notifica il completamento
        event(new QuoteGeneratedEvent($quote));
    }
}
```

2. **Ottimizzare i Calcoli dei Preventivi**

```php
// In Modules\Dental\app\Services\QuoteService.php
namespace Modules\Dental\app\Services;

use Modules\Dental\app\Models\Quote;

class QuoteService
{
    public function generateQuoteDetails(Quote $quote, array $options = [])
    {
        // Usa una singola query per caricare tutti i dati necessari
        $treatments = $quote->treatments()
            ->with(['procedures', 'materials'])
            ->get();
            
        // Usa collection methods per calcoli efficienti
        $subtotal = $treatments->sum(function ($treatment) {
            return $treatment->procedures->sum('price') + 
                   $treatment->materials->sum('price');
        });
        
        // Applica sconti e calcola il totale in memoria
        $discount = $options['discount'] ?? 0;
        $total = $subtotal * (1 - ($discount / 100));
        
        // Aggiorna il preventivo con una singola query
        $quote->update([
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'generated_at' => now(),
            'status' => 'completed'
        ]);
        
        return $quote;
    }
}
```

3. **Implementare Caching dei Risultati**

```php
// In Modules\Dental\app\Http\Controllers\QuoteController.php
namespace Modules\Dental\app\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Modules\Dental\app\Models\Quote;
use Modules\Dental\app\Jobs\GenerateQuoteJob;

class QuoteController extends Controller
{
    public function generate($quoteId)
    {
        $quote = Quote::findOrFail($quoteId);
        
        // Dispatch job per generazione asincrona
        GenerateQuoteJob::dispatch($quoteId, request()->all());
        
        return response()->json([
            'message' => 'La generazione del preventivo è stata avviata',
            'status' => 'processing'
        ]);
    }
    
    public function show($quoteId)
    {
        $quote = Quote::findOrFail($quoteId);
        
        // Usa caching per i dati del preventivo
        $quoteData = Cache::remember("quote_data_{$quoteId}", 3600, function () use ($quote) {
            return [
                'details' => $quote->load(['treatments.procedures', 'treatments.materials']),
                'summary' => [
                    'subtotal' => $quote->subtotal,
                    'discount' => $quote->discount,
                    'total' => $quote->total,
                ]
            ];
        });
        
        return response()->json($quoteData);
    }
}
```

## 3. Lentezza nella Visualizzazione del Calendario Appuntamenti

### Problema
Il calendario degli appuntamenti diventa lento quando si visualizzano periodi estesi o quando ci sono molti dottori.

### Impatto
- Interattività ridotta nell'interfaccia del calendario
- Tempi di caricamento lunghi quando si cambia vista
- Utilizzo elevato di memoria nel browser

### Soluzione Passo-Passo

1. **Implementare Caricamento Paginato e Lazy**

```php
// In Modules\Dental\app\Http\Controllers\AppointmentController.php
namespace Modules\Dental\app\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Dental\app\Models\Appointment;

class AppointmentController extends Controller
{
    public function getAppointments(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $doctorIds = $request->input('doctor_ids', []);
        
        $query = Appointment::query()
            ->whereBetween('scheduled_at', [$start, $end]);
            
        if (!empty($doctorIds)) {
            $query->whereIn('doctor_id', $doctorIds);
        }
        
        // Limita i campi restituiti per ridurre il payload
        return $query->select([
            'id', 'patient_id', 'doctor_id', 'scheduled_at', 
            'duration', 'status', 'title'
        ])->get();
    }
}
```

2. **Ottimizzare il Rendering Frontend**

```javascript
// In resources/js/components/DentalCalendar.js
import { ref, onMounted } from 'vue';
import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

export default {
    setup() {
        const calendarEl = ref(null);
        let calendar = null;
        
        onMounted(() => {
            calendar = new Calendar(calendarEl.value, {
                plugins: [timeGridPlugin, interactionPlugin],
                initialView: 'timeGridWeek',
                // Usa lazy loading degli eventi
                events: function(info, successCallback, failureCallback) {
                    axios.get('/api/dental/appointments', {
                        params: {
                            start: info.startStr,
                            end: info.endStr,
                            doctor_ids: selectedDoctors.value
                        }
                    })
                    .then(response => {
                        successCallback(response.data);
                    })
                    .catch(error => {
                        failureCallback(error);
                    });
                },
                // Limita il rendering solo agli eventi visibili
                eventMaxStack: 3,
                // Usa virtual scrolling per performance migliori
                scrollTime: '08:00:00',
                height: 'auto',
                // Ottimizza per dispositivi mobili
                themeSystem: 'bootstrap5',
                stickyHeaderDates: true,
                // Migliora la performance disabilitando animazioni complesse
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                }
            });
            
            calendar.render();
        });
        
        return { calendarEl };
    }
};
```

3. **Implementare Caching e Prefetching Intelligente**

```php
// In Modules\Dental\app\Services\AppointmentService.php
namespace Modules\Dental\app\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Dental\app\Models\Appointment;

class AppointmentService
{
    public function getAppointmentsForCalendar($start, $end, $doctorIds = [])
    {
        $cacheKey = "appointments_" . md5($start . $end . implode(',', $doctorIds));
        
        return Cache::remember($cacheKey, 300, function () use ($start, $end, $doctorIds) {
            $query = Appointment::whereBetween('scheduled_at', [$start, $end]);
            
            if (!empty($doctorIds)) {
                $query->whereIn('doctor_id', $doctorIds);
            }
            
            return $query->select([
                'id', 'patient_id', 'doctor_id', 'scheduled_at', 
                'duration', 'status', 'title'
            ])->get();
        });
    }
    
    public function prefetchUpcomingAppointments($doctorId)
    {
        // Prefetch dei prossimi 7 giorni per migliorare l'esperienza utente
        $start = now()->startOfDay();
        $end = now()->addDays(7)->endOfDay();
        
        $this->getAppointmentsForCalendar($start, $end, [$doctorId]);
    }
}
```

## Collegamenti Bidirezionali

- [README Dental](./README.md)
- [Roadmap](./roadmap.md)
- [Struttura del Modulo](./structure.md)

## Collegamenti tra versioni di bottlenecks.md
* [bottlenecks.md](../../../../bashscripts/docs/bottlenecks.md)
* [bottlenecks.md](../../Chart/docs/bottlenecks.md)
* [bottlenecks.md](../../Chart/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Gdpr/docs/bottlenecks.md)
* [bottlenecks.md](../../Gdpr/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../User/docs/bottlenecks.md)
* [bottlenecks.md](../../User/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../UI/docs/bottlenecks.md)
* [bottlenecks.md](../../UI/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Lang/docs/bottlenecks.md)
* [bottlenecks.md](../../Lang/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Job/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Media/docs/bottlenecks.md)
* [bottlenecks.md](../../Media/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Activity/docs/bottlenecks.md)
* [bottlenecks.md](../../Patient/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Cms/docs/bottlenecks.md)

