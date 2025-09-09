<?php

namespace Modules\Cms\Filament\Forms\Components;

<<<<<<< HEAD
=======
use Webmozart\Assert\Assert;
>>>>>>> b4e4106 (.)
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
<<<<<<< HEAD
=======
        Assert::isInstanceOf($attachment, Attachment::class);
>>>>>>> b4e4106 (.)
        $data=[
            'title'=>$attachment->title,
            'description'=>$attachment->description,
            'asset'=>$attachment->asset(),
        ];
        $view='pub_theme::filament.forms.components.download-attachment-place-holder';
<<<<<<< HEAD
=======
        //*@phpstan-ignore-next-line
        if(!view()->exists($view)){
            throw new \Exception("View $view does not exist");
        }
>>>>>>> b4e4106 (.)
        $out=view($view,$data);
        
        return new HtmlString($out->render());
    }

    
}
