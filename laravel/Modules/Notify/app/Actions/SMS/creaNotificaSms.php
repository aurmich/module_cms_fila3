<?php

private function creaNotificaSms($tipoNotifica, $messaggio, $datetime, $entitaDestinatarioNotifica, $ruoloDestinatarioNotifica, $destinatarioId, $telefonoDestinatario, $entitaCoinvolte) {
    $tipoNotificaEntity = $this->tipoNotificaRepository->findOneBy(['nome' => $tipoNotifica]);
    if (!$tipoNotificaEntity) {throw new \Exception('Tipo notifica non trovata!');}

    try {
        //https://agiletelecom.com/developers-area/
        $smsNumber = $this->controllaNumeroTelefonico($telefonoDestinatario);

        [ $testoMessaggioFormat, $numeroCaratteri, $numeroSms ] = $this->formatSmsMessage($messaggio);

        $data = [
            "smsTEXT" => $testoMessaggioFormat,
            "smsNUMBER" => (getenv('APP_ENV') == "dev" ? $this->container->getParameter('app.staff.phone_number') : $smsNumber),
            "smsGATEWAY" => "H", // M = Qualità standard, H = Qualità Alta
            "smsUSER" => getenv('SMS_GATEWAY_USERNAME'),
            "smsPASSWORD" => getenv('SMS_GATEWAY_PASSWORD')
        ];

        $headers = [
            "Accept-Encoding" => "gzip, deflate",
            "Cache-Control" => "no-cache",
            "Connection" => "keep-alive",
        ];

        $client = new Client([
            'base_uri' => getenv('SMS_GATEWAY_BASE_URI'),
            'timeout' => 2.0,
            'form_params' => $data,
            'headers' => $headers,
        ]);

        $connection = $client->request('POST', getenv('SMS_GATEWAY_RELATIVE_PATH'));

        if ($connection->getStatusCode() != 200) {
            $esitoNotificaSms = "Errore di comunicazione " . $connection->getStatusCode();
        } else {
            preg_match('/<body.*>(.+)<\/body>/s', $connection->getBody(), $matches);
            $esitoNotificaSms = $matches[1];
            if (strpos($esitoNotificaSms, 'Ok') !== false) {
                $esitoNotificaSms = "Ok";
            } else {
                $esitoNotificaSms = str_replace("\n", "", $esitoNotificaSms);
                $esitoNotificaSms = substr($esitoNotificaSms, 1);
            }
        }
    } catch (\Exception $exception) {
        $esitoNotificaSms = "Errore interno: " . $exception->getMessage() . " at " . $exception->getFile() . ":" . $exception->getLine();
    }

    $notifica = new Notifica();

    //esitoNotificaSms
    $notifica->setEsitoNotificaSms($esitoNotificaSms);

    if ($esitoNotificaSms == 'Ok') {
        $notifica->setSmsInviati($numeroSms);
    }

    //data
    $notifica->setData($datetime);

    //tipoNotifica
    $notifica->setTipoNotifica($tipoNotificaEntity);

    //entitaDestinatarioNotifica
    if (!is_null($entitaDestinatarioNotifica)) {
        $entitaDestinatarioNotificaEntity = $this->entitaDestinatarioNotificaRepository->findOneBy(['nome' => $entitaDestinatarioNotifica]);
        if (!$entitaDestinatarioNotificaEntity) {
            throw new \Exception('Entita destinatario notifica non trovato!');
        }
        $notifica->setEntitaDestinatarioNotifica($entitaDestinatarioNotificaEntity);
    }

    //ruoloDestinatarioNotifica
    $ruoloDestinatarioNotificaEntity = $this->ruoloDestinatarioNotificaRepository->findOneBy(['nome' => $ruoloDestinatarioNotifica]);
    if (!$ruoloDestinatarioNotificaEntity) {throw new \Exception('Ruolo destinatario notifica non trovato! ' . $ruoloDestinatarioNotifica);}
    $notifica->setRuoloDestinatarioNotifica($ruoloDestinatarioNotificaEntity);

    //destinatarioId
    if (!is_null($destinatarioId)) {
        $notifica->setDestinatarioId($destinatarioId);
    }

    //telefonoDestinatario
    $notifica->setTelefonoDestinatario($smsNumber ?? $telefonoDestinatario);

    //entita
    foreach ($entitaCoinvolte as $entitaCoinvolta) {
        if ($entitaCoinvolta instanceof Utente) {
            $notifica->setUtente($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof Relatore) {
            $notifica->setRelatore($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof Corso) {
            $notifica->setCorso($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof Attestato) {
            $notifica->setAttestato($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof Partecipante) {
            $notifica->setPartecipante($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof Sezione) {
            $notifica->setSezione($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof Fattura) {
            $notifica->setFattura($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof Evento) {
            $notifica->setEvento($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof Classe) {
            $notifica->setClasse($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof ResponsabileScientifico) {
            $notifica->setResponsabileScientifico($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof Incontro) {
            $notifica->setIncontro($entitaCoinvolta);
        } else if ($entitaCoinvolta instanceof ProgrammazioneNotifiche) {
            $notifica->setProgrammazioneNotifiche($entitaCoinvolta);
        }
    }

    $this->entityManager->persist($notifica);
    $this->entityManager->flush();
}

private function controllaNumeroTelefonico($numero) {
    //Remove any parentheses and the numbers they contain:
    $numero = preg_replace("/\([0-9]+?\)/", "", $numero);
    //Strip spaces and non-numeric characters:
    $numero = preg_replace("/[^0-9]/", "", $numero);
    //Strip out leading zeros:
    $numero = ltrim($numero, '0');
    //Look up the country dialling code for this number:
    $pfx = "39";
    //Check if the number doesn't already start with the correct dialling code:
    if (!preg_match('/^'.$pfx.'/', $numero)) {
        $numero = $pfx.$numero;
    }
    $numero = "+$numero";
    return $numero;
}

private function formatSmsMessage($testoMessaggio) {
    //eseguo sanitize
    $testoMessaggioFormat = str_replace(
      [ "à", "è", "é", "ì", "ò", "ù", "À", "È", "É", "Ì", "Ò", "Ù", "€" ],
      [ "a'", "e'", "e'", "i'", "o'", "u'", "A'", "E'", "E'", "I'", "O'", "U'", "EUR" ],
      $testoMessaggio
    );

    //conto il numero di caratteri considerando doppi i caratteri speciali
    $numeroCaratteri = mb_strlen($testoMessaggioFormat);
    $specialChars = ['^', '{', '}', '[', ']', '~', '\\', '|']; // non inserisco in specialChars "\n" in quanto già di suo è lungo 2 caratteri
    $specialCharsEscaped = ['\^', '{', '}', '\[', '\]', '~', '\\\\', '\|'];
    foreach ($specialChars as $indexSpecialChar => $specialChar) {
        $testoMessaggioSplitted = preg_split("/$specialCharsEscaped[$indexSpecialChar]/", $testoMessaggioFormat, -1, PREG_SPLIT_NO_EMPTY);
        $numeroSpecialChars = ($testoMessaggioSplitted !== false ? sizeof($testoMessaggioSplitted) - 1 : 0);
        if (str_starts_with($testoMessaggioFormat, $specialChar)) {
            $numeroSpecialChars++;
        }
        if (str_ends_with($testoMessaggioFormat, $specialChar)) {
            $numeroSpecialChars++;
        }
        $numeroCaratteri += $numeroSpecialChars * 2 - $numeroSpecialChars;
    }

    //conto il numero di sms inviati
    if ($numeroCaratteri <= 160) {
        $numeroSms = 1;
    } else {
        //se sono messaggi concatenati, ognuno è di 153 caratteri
        $numeroSms = intval($numeroCaratteri / 153);
        if (($numeroCaratteri % 153) > 0) {
            $numeroSms++;
        }
    }

    $result = [
        $testoMessaggioFormat,
        $numeroCaratteri,
        $numeroSms
    ];

    return $result;
}