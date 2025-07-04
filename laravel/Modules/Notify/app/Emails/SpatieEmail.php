<?php

declare(strict_types=1);

namespace Modules\Notify\Emails;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Datas\MetatagData;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\MailTemplate;
use Illuminate\Mail\Mailables\Attachment;
use Spatie\MailTemplates\TemplateMailable;
use Spatie\MailTemplates\Interfaces\MailTemplateInterface;

use function Safe\file_get_contents;

/**
 * @see https://github.com/spatie/laravel-database-mail-templates
 */
class SpatieEmail extends TemplateMailable
{
    // use our custom mail template model
    /** @var class-string<MailTemplateInterface> */
    protected static  $templateModelClass = MailTemplate::class;
    public string $slug;
     /** @var array<int, Attachment> */
    protected array $customAttachments = [];

    public array $data=[];

    

    public function __construct(Model $record, string $slug)
    {
        $this->slug = Str::slug($slug);
        
        MailTemplate::firstOrCreate([
            'mailable' => SpatieEmail::class,
            'slug' => $this->slug,
        ],[
            'subject' => 'Benvenuto, {{ first_name }}',
            'html_template' => '<p>Gentile {{ first_name }} {{ last_name }},</p><p>La tua registrazione  è in attesa di approvazione. Ti contatteremo presto.</p>',
            'text_template' => 'Gentile {{ first_name }} {{ last_name }}, la tua registrazione  è in attesa di approvazione. Ti contatteremo presto.'
        ]);
        
        $data=$record->toArray();
        $this->data['login_url']=route('login');
        $this->data['site_url']=url('/');

        $this->data['logo_header']=MetatagData::make()->getBrandLogo();
        $this->data=array_merge($this->data,$data);
        $this->setAdditionalData($this->data);
        

    }

    public function mergeData(array $data): self
    {
        $this->data=array_merge($this->data,$data);
        $this->setAdditionalData($this->data);
        $params=implode(',',array_keys($this->data));
        MailTemplate::where(['slug'=>$this->slug,'mailable'=>SpatieEmail::class])->update(['params'=>$params]);
        return $this;
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
        $xot=XotData::make();
        $pub_theme=$xot->pub_theme;
        $pubThemePath=base_path('Themes/'.$pub_theme.'');

        //$pathToLayout = module_path('Notify','resources/mail-layouts/base.html');
        $pathToLayout = $pubThemePath.'/resources/mail-layouts/base.html';
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
