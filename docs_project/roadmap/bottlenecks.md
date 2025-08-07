# Colli di Bottiglia del Modulo Patient

## Panoramica
Questo documento identifica i principali colli di bottiglia nel modulo Patient e fornisce una guida passo-passo per risolverli. Il modulo Patient gestisce i dati dei pazienti, le cartelle cliniche, gli appuntamenti e le interazioni con i medici, elementi critici per le performance dell'applicazione.

## 1. Gestione Cartelle Cliniche [Priorità: ALTA]

### Problema
Caricamento inefficiente delle cartelle cliniche con eccessivo utilizzo di memoria e query N+1 per i dati correlati.

### Impatto
- Tempi di caricamento pagina elevati
- Utilizzo memoria eccessivo
- Timeout nelle richieste con cartelle complesse

### Soluzione Passo-Passo

1. **Analisi delle Query Cartelle Cliniche**
   ```bash
   php artisan patient:analyze-medical-records
   ```

2. **Implementare Lazy Loading e Paginazione**
   ```php
   // Prima
   public function showMedicalRecord($patientId)
   {
       $patient = Patient::with('medicalRecords', 'medicalRecords.treatments', 'medicalRecords.diagnoses', 'medicalRecords.attachments')->findOrFail($patientId);
       
       return view('patient::medical-records.show', compact('patient'));
   }
   
   // Dopo
   public function showMedicalRecord($patientId)
   {
       $patient = Patient::findOrFail($patientId);
       
       // Carica solo i record principali con paginazione
       $medicalRecords = $patient->medicalRecords()
           ->orderBy('created_at', 'desc')
           ->paginate(10);
       
       return view('patient::medical-records.show', [
           'patient' => $patient,
           'medicalRecords' => $medicalRecords
       ]);
   }
   ```

3. **Ottimizzare le Query con Select Specifici**
   ```php
   // Prima
   $treatments = $medicalRecord->treatments;
   
   // Dopo
   $treatments = $medicalRecord->treatments()
       ->select(['id', 'medical_record_id', 'name', 'dosage', 'start_date', 'end_date'])
       ->get();
   ```

4. **Implementare Caching Selettivo**
   ```php
   public function getMedicalRecordSummary($recordId)
   {
       return cache()->remember("medical_record_summary_{$recordId}", now()->addHours(24), function () use ($recordId) {
           $record = MedicalRecord::findOrFail($recordId);
           
           return [
               'id' => $record->id,
               'created_at' => $record->created_at,
               'doctor_name' => $record->doctor->name,
               'diagnosis_count' => $record->diagnoses->count(),
               'treatment_count' => $record->treatments->count(),
               'last_updated' => $record->updated_at
           ];
       });
   }
   ```

5. **Implementare Caricamento Asincrono dei Dettagli**
   ```php
   // resources/js/medical-records.js
   document.addEventListener('DOMContentLoaded', function() {
       const recordTabs = document.querySelectorAll('.record-tab');
       
       recordTabs.forEach(tab => {
           tab.addEventListener('click', function(e) {
               e.preventDefault();
               
               const recordId = this.getAttribute('data-record-id');
               const target = this.getAttribute('data-target');
               
               // Mostra loading
               document.querySelector(target).innerHTML = '<div class="loading">Caricamento...</div>';
               
               // Carica i dettagli
               fetch(`/api/medical-records/${recordId}/details`)
                   .then(response => response.json())
                   .then(data => {
                       document.querySelector(target).innerHTML = data.html;
                   });
           });
       });
   });
   ```

6. **Ottimizzare la Struttura del Database**
   ```php
   // database/migrations/xxxx_xx_xx_optimize_medical_records_table.php
   public function up()
   {
       Schema::table('medical_records', function (Blueprint $table) {
           // Aggiunge indici per migliorare le performance
           $table->index('patient_id');
           $table->index('doctor_id');
           $table->index('created_at');
           
           // Aggiunge colonne di summary per ridurre join
           $table->unsignedInteger('diagnosis_count')->default(0);
           $table->unsignedInteger('treatment_count')->default(0);
           $table->unsignedInteger('attachment_count')->default(0);
       });
   }
   ```

## 2. Gestione Appuntamenti [Priorità: ALTA]

### Problema
Sistema di prenotazione appuntamenti inefficiente con conflitti di orario e calcoli ripetitivi di disponibilità.

### Impatto
- Latenza nelle richieste di prenotazione
- Conflitti di orario
- Overhead di calcolo per le disponibilità

### Soluzione Passo-Passo

1. **Analisi del Sistema di Prenotazione**
   ```bash
   php artisan patient:analyze-appointments
   ```

2. **Implementare Caching delle Disponibilità**
   ```php
   // app/Services/AppointmentService.php
   public function getDoctorAvailability($doctorId, $date)
   {
       $cacheKey = "doctor_{$doctorId}_availability_{$date}";
       
       return cache()->remember($cacheKey, now()->addHours(1), function () use ($doctorId, $date) {
           // Calcolo originale della disponibilità
           $workingHours = $this->getWorkingHours($doctorId, $date);
           $bookedSlots = $this->getBookedTimeSlots($doctorId, $date);
           
           return $this->calculateAvailableSlots($workingHours, $bookedSlots);
       });
   }
   ```

3. **Implementare Invalidazione Cache Intelligente**
   ```php
   // app/Observers/AppointmentObserver.php
   public function saved(Appointment $appointment)
   {
       // Invalida solo la cache per il giorno specifico
       $date = $appointment->appointment_date->format('Y-m-d');
       cache()->forget("doctor_{$appointment->doctor_id}_availability_{$date}");
   }
   ```

4. **Ottimizzare la Logica di Prenotazione con Lock**
   ```php
   // app/Services/AppointmentService.php
   public function bookAppointment($patientId, $doctorId, $date, $timeSlot)
   {
       // Usa un lock per prevenire race conditions
       return Cache::lock("appointment_booking_{$doctorId}_{$date}_{$timeSlot}", 10)->get(function () use ($patientId, $doctorId, $date, $timeSlot) {
           // Verifica disponibilità
           if (!$this->isTimeSlotAvailable($doctorId, $date, $timeSlot)) {
               throw new AppointmentNotAvailableException("Lo slot orario selezionato non è più disponibile");
           }
           
           // Crea appuntamento
           $appointment = new Appointment();
           $appointment->patient_id = $patientId;
           $appointment->doctor_id = $doctorId;
           $appointment->appointment_date = $date;
           $appointment->start_time = $timeSlot;
           $appointment->end_time = Carbon::parse($timeSlot)->addMinutes(30)->format('H:i');
           $appointment->status = 'scheduled';
           $appointment->save();
           
           // Invalida cache
           $dateStr = Carbon::parse($date)->format('Y-m-d');
           cache()->forget("doctor_{$doctorId}_availability_{$dateStr}");
           
           return $appointment;
       });
   }
   ```

5. **Implementare Prenotazione in Batch**
   ```php
   // app/Jobs/ProcessAppointmentBatch.php
   public function handle()
   {
       $appointments = $this->appointments;
       $results = [];
       
       DB::transaction(function () use ($appointments, &$results) {
           foreach ($appointments as $appointmentData) {
               try {
                   $results[] = $this->appointmentService->bookAppointment(
                       $appointmentData['patient_id'],
                       $appointmentData['doctor_id'],
                       $appointmentData['date'],
                       $appointmentData['time_slot']
                   );
               } catch (Exception $e) {
                   $results[] = [
                       'error' => true,
                       'message' => $e->getMessage(),
                       'data' => $appointmentData
                   ];
               }
           }
       });
       
       return $results;
   }
   ```

6. **Ottimizzare la Visualizzazione Calendario**
   ```php
   // app/Http/Controllers/CalendarController.php
   public function index(Request $request)
   {
       $startDate = Carbon::parse($request->input('start_date', now()));
       $endDate = Carbon::parse($request->input('end_date', now()->addDays(30)));
       
       // Carica solo gli appuntamenti nel range di date
       $appointments = Appointment::whereBetween('appointment_date', [
               $startDate->format('Y-m-d'),
               $endDate->format('Y-m-d')
           ])
           ->select(['id', 'patient_id', 'doctor_id', 'appointment_date', 'start_time', 'end_time', 'status'])
           ->with([
               'patient:id,name,surname,email',
               'doctor:id,name,surname,specialty'
           ])
           ->get();
       
       return view('calendar.index', compact('appointments', 'startDate', 'endDate'));
   }
   ```

## 3. Gestione Documenti e Allegati [Priorità: MEDIA]

### Problema
Caricamento e visualizzazione inefficiente di documenti e allegati con problemi di memoria per file di grandi dimensioni.

### Impatto
- Timeout durante il caricamento di file grandi
- Utilizzo memoria eccessivo
- Lentezza nella visualizzazione di documenti

### Soluzione Passo-Passo

1. **Analisi della Gestione Documenti**
   ```bash
   php artisan patient:analyze-attachments
   ```

2. **Implementare Caricamento Chunked**
   ```php
   // resources/js/file-upload.js
   const chunkSize = 1024 * 1024; // 1MB per chunk
   
   function uploadLargeFile(file, url, onProgress, onComplete) {
       const totalChunks = Math.ceil(file.size / chunkSize);
       let currentChunk = 0;
       
       function uploadNextChunk() {
           const start = currentChunk * chunkSize;
           const end = Math.min(start + chunkSize, file.size);
           const chunk = file.slice(start, end);
           
           const formData = new FormData();
           formData.append('file', chunk);
           formData.append('name', file.name);
           formData.append('chunk', currentChunk);
           formData.append('chunks', totalChunks);
           
           fetch(url, {
               method: 'POST',
               body: formData
           })
           .then(response => response.json())
           .then(data => {
               currentChunk++;
               const progress = Math.min(100, Math.round((currentChunk / totalChunks) * 100));
               onProgress(progress);
               
               if (currentChunk < totalChunks) {
                   uploadNextChunk();
               } else {
                   onComplete(data);
               }
           });
       }
       
       uploadNextChunk();
   }
   ```

3. **Implementare Streaming per Download**
   ```php
   // app/Http/Controllers/AttachmentController.php
   public function download($id)
   {
       $attachment = Attachment::findOrFail($id);
       
       // Verifica permessi
       $this->authorize('view', $attachment);
       
       $path = storage_path('app/' . $attachment->file_path);
       
       if (!file_exists($path)) {
           abort(404);
       }
       
       // Stream il file invece di caricarlo in memoria
       return response()->stream(
           function () use ($path) {
               $stream = fopen($path, 'rb');
               fpassthru($stream);
               fclose($stream);
           },
           200,
           [
               'Content-Type' => $attachment->mime_type,
               'Content-Disposition' => 'attachment; filename="' . $attachment->original_name . '"',
           ]
       );
   }
   ```

4. **Implementare Generazione Thumbnail Asincrona**
   ```php
   // app/Jobs/GenerateDocumentThumbnail.php
   public function handle()
   {
       $attachment = $this->attachment;
       
       if (!in_array($attachment->mime_type, ['application/pdf', 'image/jpeg', 'image/png'])) {
           return;
       }
       
       $path = storage_path('app/' . $attachment->file_path);
       $thumbnailPath = 'thumbnails/' . $attachment->id . '.jpg';
       
       if ($attachment->mime_type === 'application/pdf') {
           // Usa Imagick per generare thumbnail dalla prima pagina
           $imagick = new Imagick();
           $imagick->readImage($path . '[0]');
           $imagick->setImageFormat('jpg');
           $imagick->thumbnailImage(200, 200, true);
           Storage::put('public/' . $thumbnailPath, $imagick->getImageBlob());
       } else {
           // Usa Intervention Image per le immagini
           $img = Image::make($path);
           $img->fit(200, 200);
           Storage::put('public/' . $thumbnailPath, $img->encode('jpg'));
       }
       
       // Aggiorna il record
       $attachment->thumbnail_path = $thumbnailPath;
       $attachment->save();
   }
   ```

5. **Ottimizzare lo Storage con Policy di Retention**
   ```php
   // app/Console/Commands/CleanupTemporaryFiles.php
   public function handle()
   {
       $this->info('Pulizia file temporanei in corso...');
       
       // Elimina file temporanei più vecchi di 24 ore
       $tempFiles = Storage::files('temp');
       $count = 0;
       
       foreach ($tempFiles as $file) {
           $lastModified = Storage::lastModified($file);
           if (Carbon::createFromTimestamp($lastModified)->addHours(24)->isPast()) {
               Storage::delete($file);
               $count++;
           }
       }
       
       $this->info("Eliminati {$count} file temporanei.");
       
       // Elimina thumbnail orfane
       $this->cleanupOrphanedThumbnails();
   }
   ```

6. **Implementare Visualizzazione Progressiva**
   ```php
   // resources/js/document-viewer.js
   class ProgressiveDocumentViewer {
       constructor(container, documentUrl) {
           this.container = container;
           this.documentUrl = documentUrl;
           this.pageNum = 1;
           this.pdfDoc = null;
           this.pageRendering = false;
           this.pageNumPending = null;
           this.scale = 1.0;
           
           this.init();
       }
       
       async init() {
           this.container.innerHTML = '<div class="loading">Caricamento documento...</div>';
           
           try {
               // Carica solo la prima pagina inizialmente
               const loadingTask = pdfjsLib.getDocument(this.documentUrl);
               this.pdfDoc = await loadingTask.promise;
               
               this.renderPage(this.pageNum);
               this.setupControls();
           } catch (error) {
               this.container.innerHTML = `<div class="error">Errore nel caricamento: ${error.message}</div>`;
           }
       }
       
       // Altri metodi per la gestione del documento
   }
   ```

## 4. Ricerca Pazienti [Priorità: MEDIA]

### Problema
Ricerca inefficiente dei pazienti con performance scadenti su database di grandi dimensioni.

### Impatto
- Tempi di risposta lunghi per le ricerche
- Utilizzo CPU elevato
- Timeout per ricerche complesse

### Soluzione Passo-Passo

1. **Analisi delle Query di Ricerca**
   ```bash
   php artisan patient:analyze-search-queries
   ```

2. **Implementare Indici Full-Text**
   ```php
   // database/migrations/xxxx_xx_xx_add_fulltext_indexes.php
   public function up()
   {
       Schema::table('patients', function (Blueprint $table) {
           // Aggiungi indici FULLTEXT per migliorare le ricerche
           DB::statement('ALTER TABLE patients ADD FULLTEXT search_index (name, surname, fiscal_code, email)');
       });
   }
   ```

3. **Ottimizzare le Query di Ricerca**
   ```php
   // Prima
   $patients = Patient::where('name', 'like', "%{$search}%")
       ->orWhere('surname', 'like', "%{$search}%")
       ->orWhere('fiscal_code', 'like', "%{$search}%")
       ->orWhere('email', 'like', "%{$search}%")
       ->paginate(20);
   
   // Dopo
   $patients = Patient::whereRaw("MATCH(name, surname, fiscal_code, email) AGAINST(? IN BOOLEAN MODE)", [$search])
       ->paginate(20);
   ```

4. **Implementare Ricerca Elastica**
   ```php
   // Installare Laravel Scout con Elasticsearch
   composer require laravel/scout elasticsearch/elasticsearch
   
   // app/Models/Patient.php
   use Laravel\Scout\Searchable;
   
   class Patient extends Model
   {
       use Searchable;
       
       public function toSearchableArray()
       {
           return [
               'id' => $this->id,
               'name' => $this->name,
               'surname' => $this->surname,
               'fiscal_code' => $this->fiscal_code,
               'email' => $this->email,
               'birth_date' => $this->birth_date,
               'address' => $this->address,
               'city' => $this->city,
               'phone' => $this->phone
           ];
       }
   }
   ```

5. **Implementare Ricerca Suggerimenti**
   ```php
   // app/Http/Controllers/PatientSearchController.php
   public function suggestions(Request $request)
   {
       $search = $request->input('q');
       
       if (strlen($search) < 3) {
           return response()->json([]);
       }
       
       $suggestions = cache()->remember("patient_suggestions_{$search}", now()->addMinutes(30), function () use ($search) {
           return Patient::search($search)
               ->take(10)
               ->get(['id', 'name', 'surname', 'fiscal_code'])
               ->map(function ($patient) {
                   return [
                       'id' => $patient->id,
                       'text' => "{$patient->name} {$patient->surname} ({$patient->fiscal_code})"
                   ];
               });
       });
       
       return response()->json($suggestions);
   }
   ```

6. **Implementare Ricerca Avanzata con Filtri**
   ```php
   // app/Services/PatientSearchService.php
   public function search(array $filters)
   {
       $query = Patient::query();
       
       // Applica filtri base
       if (!empty($filters['search'])) {
           $query->whereRaw("MATCH(name, surname, fiscal_code, email) AGAINST(? IN BOOLEAN MODE)", [$filters['search']]);
       }
       
       // Filtri avanzati
       if (!empty($filters['age_from']) && !empty($filters['age_to'])) {
           $from = Carbon::now()->subYears($filters['age_to']);
           $to = Carbon::now()->subYears($filters['age_from'])->endOfDay();
           $query->whereBetween('birth_date', [$from, $to]);
       }
       
       if (!empty($filters['city'])) {
           $query->where('city', $filters['city']);
       }
       
       if (!empty($filters['doctor_id'])) {
           $query->whereHas('appointments', function ($q) use ($filters) {
               $q->where('doctor_id', $filters['doctor_id']);
           });
       }
       
       // Ordinamento
       $sortField = $filters['sort_by'] ?? 'created_at';
       $sortDir = $filters['sort_dir'] ?? 'desc';
       $query->orderBy($sortField, $sortDir);
       
       return $query->paginate($filters['per_page'] ?? 20);
   }
   ```

## Conclusione

Questi colli di bottiglia rappresentano le aree più critiche per l'ottimizzazione del modulo Patient. Implementando le soluzioni proposte, è possibile ottenere miglioramenti significativi nelle performance dell'applicazione, specialmente per quanto riguarda la gestione delle cartelle cliniche, gli appuntamenti e la ricerca dei pazienti.

## Collegamenti Bidirezionali

- [Roadmap Principale](../roadmap.md)
- [Documentazione Cartelle Cliniche](../medical-records.md)
- [Documentazione Appuntamenti](../appointments.md)
- [Gestione Documenti](../documents.md)

## Collegamenti tra versioni di bottlenecks.md
* [bottlenecks.md](laravel/Modules/Gdpr/docs/performance/bottlenecks.md)
* [bottlenecks.md](laravel/Modules/Xot/docs/bottlenecks.md)
* [bottlenecks.md](laravel/Modules/Xot/docs/performance/bottlenecks.md)
* [bottlenecks.md](laravel/Modules/Xot/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](laravel/Modules/User/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](laravel/Modules/UI/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](laravel/Modules/Lang/docs/performance/bottlenecks.md)
* [bottlenecks.md](laravel/Modules/Job/docs/performance/bottlenecks.md)
* [bottlenecks.md](laravel/Modules/Media/docs/performance/bottlenecks.md)
* [bottlenecks.md](laravel/Modules/Patient/docs/roadmap/bottlenecks.md)

