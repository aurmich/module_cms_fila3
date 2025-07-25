# Regole per l'Implementazione di Provider SMS in SaluteOra

## Architettura Standard

L'implementazione di provider SMS in SaluteOra segue questi principi architetturali obbligatori:

1. **Configurazione Provider**
   - SEMPRE aggiungere la configurazione al file esistente `config/sms.php` nella sezione `drivers`
   - SEMPRE utilizzare variabili d'ambiente con valori di default sensati
   - SEMPRE verificare la documentazione ufficiale del provider per gli URL corretti

2. **Data Transfer Objects**
   - SEMPRE utilizzare `spatie/laravel-data` per i DTO
   - SEMPRE posizionare i DTO nella cartella `app/Datas` del modulo (NON usare `app/DTOs` o `app/Data`)
   - SEMPRE utilizzare namespace corretto `Modules\NomeModulo\App\Datas`
   - SEMPRE definire chiaramente tutti i parametri richiesti e opzionali

3. **Queueable Actions**
   - SEMPRE implementare l'invio SMS tramite `spatie/laravel-queueable-action`
   - SEMPRE posizionare le actions nella cartella `app/Actions/SMS` del modulo
   - SEMPRE includere logging adeguato per successi, errori e avvertimenti
   - SEMPRE gestire correttamente le eccezioni
   - MAI utilizzare Service Pattern tradizionale per l'invio SMS

4. **Notification Channels**
   - SEMPRE creare un channel dedicato che utilizzi l'action sottostante
   - SEMPRE posizionare i channel nella cartella `app/Channels` del modulo
   - SEMPRE verificare che la gestione dei notifiable sia corretta

## Endpoint API Verificati

Provider SMS supportati da SaluteOra con endpoint verificati:

- **Twilio**: `https://api.twilio.com/2010-04-01/Accounts/{account_sid}/Messages.json`
- **Vonage/Nexmo**: `https://rest.nexmo.com/sms/json`
- **SMSHosting**: `https://api.smshosting.it/rest/api/sms/send`
- **Netfun**: `https://v2.smsviainternet.it/api/rest/v1/sms-batch.json`
- **Telcob**: `https://api.telcob.com/sms/v1/send`

## Errori Comuni da Evitare

1. **MAI** utilizzare URL errati o inventati
2. **MAI** creare strutture DTO personalizzate (usare sempre `spatie/laravel-data`)
3. **MAI** duplicare configurazioni in più file
4. **MAI** ignorare la struttura esistente del progetto
5. **MAI** utilizzare il pattern Service invece di Queueable Actions
