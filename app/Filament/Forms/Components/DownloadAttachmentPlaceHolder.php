<?php

namespace Modules\Cms\Filament\Forms\Components;

use Webmozart\Assert\Assert;
use Illuminate\Support\HtmlString;
use Modules\Cms\Models\Attachment;
use Filament\Forms\Components\Placeholder;

class DownloadAttachmentPlaceHolder extends Placeholder
{
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->label('')
         ->content(fn() => $this->generateContent())
         ->columnSpanFull();
    }

    protected function generateContent(): HtmlString
    {
        $name=$this->getName();
        $attachment = Attachment::firstWhere('slug', $name);   
        Assert::isInstanceOf($attachment, Attachment::class);
        $data=[
            'title'=>$attachment->title,
            'description'=>$attachment->description,
            'asset'=>$attachment->asset(),
        ];
        $view='pub_theme::filament.forms.components.download-attachment-place-holder';
        $out=view($view,$data);
        
        return new HtmlString($out->render());
    }

    
}
