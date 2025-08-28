<?php

declare(strict_types=1);

use Modules\Notify\Models\MailTemplate;

describe('MailTemplate Business Logic', function () {
    test('mail template extends spatie mail template', function () {
        expect(MailTemplate::class)->toBeSubclassOf(\Spatie\MailTemplates\Models\MailTemplate::class);
    });

    test('mail template has slug trait for url-friendly names', function () {
        $traits = class_uses(MailTemplate::class);
        
        expect($traits)->toHaveKey(\Spatie\Sluggable\HasSlug::class);
    });

    test('mail template has translations trait', function () {
        $traits = class_uses(MailTemplate::class);
        
        expect($traits)->toHaveKey(\Spatie\Translatable\HasTranslations::class);
    });

    test('mail template has soft deletes trait', function () {
        $traits = class_uses(MailTemplate::class);
        
        expect($traits)->toHaveKey(\Illuminate\Database\Eloquent\SoftDeletes::class);
    });

    test('mail template can store template content', function () {
        $mailTemplate = new MailTemplate();
        $mailTemplate->name = 'Welcome Email';
        $mailTemplate->subject = 'Welcome to our platform';
        $mailTemplate->html_template = '<h1>Welcome!</h1>';
        
        expect($mailTemplate->name)->toBe('Welcome Email');
        expect($mailTemplate->subject)->toBe('Welcome to our platform');
        expect($mailTemplate->html_template)->toBe('<h1>Welcome!</h1>');
    });

    test('mail template can link to mailable class', function () {
        $mailTemplate = new MailTemplate();
        $mailTemplate->mailable = 'App\\Mail\\WelcomeMail';
        
        expect($mailTemplate->mailable)->toBe('App\\Mail\\WelcomeMail');
    });

    test('mail template has version tracking', function () {
        $mailTemplate = new MailTemplate();
        $mailTemplate->version = 2;
        
        expect($mailTemplate->version)->toBe(2);
    });

    test('mail template can store optional text template', function () {
        $mailTemplate = new MailTemplate();
        $mailTemplate->text_template = 'Welcome! This is plain text.';
        
        expect($mailTemplate->text_template)->toBe('Welcome! This is plain text.');
    });

    test('mail template can be queried by mailable', function () {
        $mailable = \Mockery::mock(\Illuminate\Contracts\Mail\Mailable::class);
        $query = MailTemplate::forMailable($mailable);
        
        expect($query)->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);
    });

    test('mail template has creator and updater tracking', function () {
        $mailTemplate = new MailTemplate();
        $mailTemplate->created_by = 'user-1';
        $mailTemplate->updated_by = 'user-2';
        
        expect($mailTemplate->created_by)->toBe('user-1');
        expect($mailTemplate->updated_by)->toBe('user-2');
    });
});