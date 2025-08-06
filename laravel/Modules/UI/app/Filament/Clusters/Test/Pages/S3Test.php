<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Modules\Notify\Datas\EmailData;
use Aws\CloudFront\CloudFrontClient;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\ComponentContainer;
use Modules\UI\Filament\Clusters\Test;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Modules\Notify\Emails\EmailDataEmail;
use Modules\Xot\Filament\Pages\XotBasePage;

/**
 * @property ComponentContainer $form
 */
class S3Test extends XotBasePage
{
    
    protected static ?string $cluster = Test::class;

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'form',
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('sendEmail')
                ->submit('sendEmail'),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('attachment')
                ->disk('s3')
                ->directory('form-attachments')
                ->visibility('private'),
        ];
    }

    protected function fillForms(): void
    {
        $this->form->fill();
    }

    public function save(): void
    {
        //try {
            $filename='test1.txt';
            Storage::disk('s3')->put($filename, 'Hello World');
            $url = self::getSignedUrl($filename);
            dddx('S3 connection working!: '.$url);
        //} catch (\Exception $e) {
        //    dddx('Error: '.$e->getMessage());
        //}


        $data=$this->form->getState();
        $data = $this->form->getState();

        // Il file è già su S3: $data['attachment'] è il percorso
        $filePath = $data['attachment'];
    
        // Se serve l’URL pubblico (solo se il file è pubblico):
        $url = Storage::disk('s3')->url($filePath);
    
        // Se è privato, puoi generare un link temporaneo:
        $temporaryUrl = Storage::disk('s3')->temporaryUrl($filePath, now()->addMinutes(5));
    
        // Debug
        dddx([
            'path' => $filePath,
            'url' => $temporaryUrl,
        ]);
        Notification::make()
            ->success()
            ->title(__('Success'))
            ->send();
    }


    public static function getSignedUrl(string $key, int $expiry = 30): string
    {
        $cloudFront = new CloudFrontClient([
            'region' => env('CLOUDFRONT_REGION', 'eu-west-1'),
            'version' => 'latest'
        ]);

        return $cloudFront->getSignedUrl([
            'url' => env('CLOUDFRONT_RESOURCE_KEY_BASE_URL') . '/' . ltrim($key, '/'),
            'expires' => time() + ($expiry * 60),
            'key_pair_id' => env('CLOUDFRONT_KEYPAIR_ID'),
            'private_key' => self::formatPrivateKey(env('CLOUDFRONT_PRIVATE_KEY')),
        ]);
    }

    private static function formatPrivateKey(string $key): string
    {
        return str_replace('\n', "\n", $key);
    }
}
