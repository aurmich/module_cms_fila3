<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Mail;

use Webmozart\Assert\Assert;
use Illuminate\Mail\Mailable;
use Modules\Notify\Datas\SmtpData;
use Modules\Notify\Datas\EmailData;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;
use Modules\Xot\Actions\Export\PdfByModelAction;

class SendMailByRecordAction
{
    use QueueableAction;

    /**
     * Invia una mail utilizzando un record come dati.
     *
     * @param Model  $record    Il record da utilizzare come dati per la mail
     * @param string $mailClass La classe Mailable da utilizzare
     */
    public function execute(Model $record, string $mailClass): void
    {
        
        Assert::classExists($mailClass);
        // Expected an implementation of "Illuminate\Mail\Mailable". Got: "Modules\Performance\Mail\SchedaMail"
        // Assert::implementsInterface($mailClass, Mailable::class);

        // Utilizziamo il container per istanziare la classe Mailable
        // in modo che possa ricevere le dipendenze necessarie
        // @var Mailable $mail 
        // $mail = app($mailClass, ['record' => $record]);
        //Mail::send($mail);
        //dddx(Mail::to($record)->send(new $mailClass($record)));
        //$res=Mail::to('marco.sottana@gmail.com')->send($mail);
         $data = [
            'to' => $record->email,
            'subject' => $record->option('mail_oggetto'),
            'body_html' => $record->option('mail_testo'),
            'attachments' => [
                app(PdfByModelAction::class)->execute(model: $record, out: 'path')
            ],
        ];
        $emailData = EmailData::from($data);
        SmtpData::make()->send($emailData);
        
        $record->myLogs()->create([
            'act' => 'sendMail',
            'handle' => authId(),
        ]);
    }
}
