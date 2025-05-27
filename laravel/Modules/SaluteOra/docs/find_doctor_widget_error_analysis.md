# Analisi dell'errore di interpretazione del FindDoctorAndAppointmentWidget

## Contesto dell'errore
Il widget `FindDoctorAndAppointmentWidget` è stato implementato in modo diverso rispetto a quanto documentato nei file di riferimento:
- `/docs/images/9.md`
- `/docs/images/9.blade.php`
- `/docs/images/9.html`

## Errori identificati

1. **Struttura del form non allineata con la documentazione**
   - La documentazione mostrava un form con campi specifici per Regione, Città e CAP
   - L'implementazione attuale usa un campo generico `location` invece dei campi specifici

2. **Mancanza di localizzazione corretta**
   - I campi non seguono la struttura corretta per la localizzazione
   - Manca l'uso di `LangServiceProvider` per la gestione delle traduzioni

3. **Architettura del wizard non ottimale**
   - Il wizard è stato implementato con step generici invece di seguire il flusso documentato
   - Manca la gestione corretta degli stati tra gli step

4. **Namespace errato**
   - Il widget usa `Modules\SaluteOra\App\Filament` invece di `Modules\SaluteOra\Filament`

5. **Estensione diretta di Filament**
   - Il widget estende `\Filament\Widgets\Widget` invece di `XotBaseWidget`

6. **Struttura del wizard non ottimale**
   - Gli step del wizard sono definiti direttamente nel metodo `getFormSchema()`
   - Manca la separazione degli step in metodi dedicati
   - Violazione del principio del clean code

## Correzioni effettuate

1. **Struttura del form**
   - Implementati i campi specifici (Regione, Provincia, Città, CAP)
   - Aggiunta la gestione delle dipendenze tra i campi
   - Implementato il wizard con step ben definiti

2. **Localizzazione**
   - Creati i file di traduzione in `Modules/SaluteOra/lang/{it,en}/find_doctor_widget.php`
   - Rimosso l'uso di `->label()` e `__()`
   - Implementato il formato corretto per i campi

3. **Namespace e estensione**
   - Corretto il namespace in `Modules\SaluteOra\Filament\Widgets\Patient`
   - Esteso `XotBaseWidget` invece di `\Filament\Widgets\Widget`

4. **Modelli e migrazioni**
   - Creati i modelli `Region`, `Province`, `City`, `Cap`
   - Implementate le relazioni tra i modelli
   - Create le migrazioni per le tabelle

5. **Struttura del wizard**
   - Separati gli step del wizard in metodi dedicati
   - Implementato il pattern "Single Responsibility"
   - Migliorata la manutenibilità del codice

## Come evitare errori simili in futuro

1. **Documentazione**
   - Prima di implementare qualsiasi widget, studiare attentamente la documentazione esistente
   - Verificare la presenza di file di riferimento (.md, .blade.php, .html)
   - Analizzare la struttura dei dati e il flusso utente documentato

2. **Localizzazione**
   - Utilizzare sempre `LangServiceProvider` per la gestione delle traduzioni
   - Seguire il formato corretto per i campi: `'field_name' => ['label' => 'Label Text']`
   - Non usare direttamente `->label()` o `__()` nei componenti

3. **Struttura del form**
   - Implementare esattamente i campi documentati
   - Mantenere la coerenza con il design system esistente
   - Verificare la validazione e le dipendenze tra i campi

4. **Best Practices**
   - Estendere sempre `XotBaseWidget` per i widget
   - Utilizzare i componenti Filament in modo consistente
   - Implementare la gestione degli errori e il feedback utente

5. **Struttura del wizard**
   - Separare sempre gli step del wizard in metodi dedicati
   - Seguire il principio "Single Responsibility"
   - Mantenere il codice pulito e manutenibile
   - Documentare la struttura del wizard nella documentazione del modulo

## Note aggiuntive

- La documentazione è la fonte di verità per l'implementazione
- Mantenere la coerenza con il design system esistente
- Seguire le best practices di Filament e del modulo Xot
- Aggiornare regolarmente la documentazione quando si fanno modifiche
- Separare gli step del wizard in metodi dedicati per migliorare la manutenibilità

# Analisi errori FindDoctorAndAppointmentWidget.php

## 1. Uso errato di ->label() e ->placeholder()
- **Errore:** Uso di ->label() e ->placeholder() nei componenti Filament.
- **Causa:** In SaluteOra/Xot, la localizzazione è gestita automaticamente tramite LangServiceProvider e i file di lingua del modulo. Non bisogna mai usare ->label(), ->placeholder() o stringhe tradotte direttamente nei componenti.
- **Soluzione:** Rimuovere tutte le chiamate a ->label() e ->placeholder(). Usare solo la chiave campo (es. 'specialization', 'location', ecc.).
- **Best practice:** Vedi anche: ../../Xot/docs/filament_widget_regole.md

## 2. Uso errato di ->options(AppointmentType::class)
- **Errore:** Passare direttamente l'enum PHP come opzione a Select.
- **Causa:** Gli enum PHP nativi non sono supportati direttamente da Filament per le opzioni. Serve un metodo statico custom che restituisca un array associativo.
- **Soluzione:** Implementare un metodo statico asSelectArray() nell'enum e usarlo: ->options(AppointmentType::asSelectArray())
- **Best practice:** Documentare sempre l'uso degli enum nei form in enums_best_practices.md

## 3. Replicazione di trait/interfacce/metodi della base
- **Errore:** Replicare trait, interfacce o metodi già presenti in XotBaseWidget.
- **Causa:** Non aver studiato la classe base prima di estendere.
- **Soluzione:** Rimuovere ogni implementazione/uso di trait/interfacce/metodi già presenti nella base. Studiare sempre la base prima di estendere.
- **Best practice:** Vedi anche: ../../Xot/docs/filament_widget_regole.md

## 4. Gestione errata degli step del wizard
- **Errore:** Restituzione di null o componenti non validi negli step del wizard.
- **Causa:** Ogni step deve restituire sempre un array di componenti Filament validi, mai null.
- **Soluzione:** Verificare che ogni metodo get*Step() restituisca sempre un array di componenti validi.

## 5. Simulazione dati e logica incompleta
- **Errore:** Metodi come createAppointment e sendConfirmation sono placeholder e non implementano la logica reale.
- **Causa:** Codice incompleto o lasciato come TODO.
- **Soluzione:** Implementare la logica reale o documentare chiaramente che si tratta di stub temporanei.

## 6. Altri errori comuni
- **Uso di costanti enum non esistenti:** Es: AppointmentType::CHECKUP se non esiste il case CHECKUP.
- **Uso di metodi statici non esistenti sugli enum:** Es: AppointmentType::getOptions().
- **Montaggio errato del widget come componente Livewire:** Non usare @livewire(FindDoctorAndAppointmentWidget::class) nelle blade.

---

## Best Practice
- Studiare sempre la classe base XotBaseWidget prima di estendere.
- Non replicare mai trait/interfacce/metodi già presenti nella base.
- Usare solo chiavi campo nei form component, senza label/placeholder manuali.
- Usare sempre metodi statici custom per le opzioni degli enum.
- Documentare ogni errore e soluzione nella cartella docs del modulo.
- Aggiornare le regole in .mdc per Cursor e Windsurf.

---

**Ultimo aggiornamento:** {{DATA}} 