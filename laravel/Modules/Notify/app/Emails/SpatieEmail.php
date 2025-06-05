<?php

declare(strict_types=1);

namespace Modules\Notify\Emails;

use Illuminate\Support\Arr;
use Modules\Xot\Datas\MetatagData;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\MailTemplate;
use Illuminate\Mail\Mailables\Attachment;
use Spatie\MailTemplates\TemplateMailable;

/**
 * @see https://github.com/spatie/laravel-database-mail-templates
 */
class SpatieEmail extends TemplateMailable
{
    // use our custom mail template model
    protected static $templateModelClass = MailTemplate::class;
    public string $slug;
     /** @var array<int, Attachment> */
     protected array $customAttachments = [];

    public function __construct(Model $record, string $slug)
    {
        $data=$record->toArray();
        $this->setAdditionalData($data);
        $this->slug = $slug;

    }

    public function getHtmlLayout(): string
    {
        //$pathToLayout = storage_path('mail-layouts/main.html');

        //return file_get_contents($pathToLayout);
        /**
         * In your application you might want to fetch the layout from an external file or Blade view.
         *
         * External file: `return file_get_contents(storage_path('mail-layouts/main.html'));`
         *
         * Blade view: `return view('mailLayouts.main', $data)->render();`
         */
        //$pathToLayout = module_path('Notify','resources/mail-layouts/base/responsive.html');
        //dddx(MetatagData::make()->toArray());


        $pathToLayout = module_path('Notify','resources/mail-layouts/base.html');
        return file_get_contents($pathToLayout);

        //return '<header>Site name!</header>{{{ body }}}<footer>Copyright 2018</footer>';
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Add attachments to the email
     *
     * @param array<int, array<string, string>> $attachments Array of attachment data
     * @return self
     */
    public function addAttachments(array $attachments): self
    {
        $attachmentObjects = [];
        
        foreach ($attachments as $item) {
            if (!isset($item['path']) || !file_exists($item['path'])) {
                continue;
            }
            
            $attachment = Attachment::fromPath($item['path']);
            
            if (isset($item['as'])) {
                $attachment = $attachment->as($item['as']);
            }
            
            if (isset($item['mime'])) {
                $attachment = $attachment->withMime($item['mime']);
            }
            
            $attachmentObjects[] = $attachment;
        }
        
        $this->customAttachments = $attachmentObjects;
        
        return $this;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return $this->customAttachments;
    }
}
