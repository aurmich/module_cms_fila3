<?php

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\MailTemplates\Models\MailTemplate;

class MailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // IMPORTANTE: Usare SEMPRE la signature con chiavi nel primo array e dati nel secondo.
        // I template devono essere multilingua e identificati da uno slug.
        // La mailable deve essere SEMPRE SpatieEmail.

        MailTemplate::firstOrCreate([
            'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
            'slug' => 'registration_moderated',
        ], [
            'subject' => [
                'it' => 'Registrazione moderata, {{ first_name }}',
                'en' => 'Registration moderated, {{ first_name }}'
            ],
            'html_template' => [
                'it' => '<p>Ciao {{ first_name }},</p><p>La tua registrazione è stata moderata.</p>',
                'en' => '<p>Hello {{ first_name }},</p><p>Your registration has been moderated.</p>'
            ],
            'text_template' => [
                'it' => 'Ciao {{ first_name }}, La tua registrazione è stata moderata.',
                'en' => 'Hello {{ first_name }}, Your registration has been moderated.'
            ]
        ]);

        MailTemplate::firstOrCreate([
            'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
            'slug' => 'registration_completed',
        ], [
            'subject' => [
                'it' => 'Registrazione completata, {{ first_name }}',
                'en' => 'Registration completed, {{ first_name }}'
            ],
            'html_template' => [
                'it' => '<p>Ciao {{ first_name }},</p><p>La tua registrazione è stata completata con successo.</p>',
                'en' => '<p>Hello {{ first_name }},</p><p>Your registration has been completed successfully.</p>'
            ],
            'text_template' => [
                'it' => 'Ciao {{ first_name }}, La tua registrazione è stata completata con successo.',
                'en' => 'Hello {{ first_name }}, Your registration has been completed successfully.'
            ]
        ]);
    }
}
