## Regole di naming per le azioni

- Le azioni che operano su una chiave specifica devono utilizzare la forma `By<Key>` (es. `UpdateRestiPondByValutatoreIdAction`).
- Il namespace corretto per Filament è sempre `Modules\<nome modulo>\Filament`, anche se i file risiedono in `app/Filament`.
- Esempio pratico: vedi la correzione e il ragionamento in [Azioni Organizzativa (Performance)](../../Performance/docs/azioni_organizzativa.md).

### Collegamenti
- [Azioni Organizzativa (Performance)](../../Performance/docs/azioni_organizzativa.md)

## Regole sui Model
- Nei moduli, i model devono **sempre** estendere `BaseModel` e **mai** direttamente `Model`.
- Il codice deve essere scritto già conforme agli standard richiesti da phpstan livello 10.
- Evitare duplicazioni di model: vedi la discussione e i rischi nella [documentazione Performance](../../Performance/docs/azioni_organizzativa.md#duplicazione-tra-organizzativatotvalutatore-e-organizzativatotvalutatoreid). 