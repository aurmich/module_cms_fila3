<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Continua la tua registrazione su SaluteOra</title>
</head>
<body>
    <h1>Ciao {{ $doctor->full_name }},</h1>
    <p>La tua richiesta di registrazione come odontoiatra su SaluteOra è stata approvata. Puoi ora continuare il processo di registrazione cliccando sul link sottostante:</p>
    <p><a href="{{ $continuationUrl }}">Continua la registrazione</a></p>
    <p>Questo link sarà valido per 7 giorni. Se hai domande o hai bisogno di assistenza, contattaci.</p>
    <p>Grazie,</p>
    <p>Il team di SaluteOra</p>
</body>
</html>
