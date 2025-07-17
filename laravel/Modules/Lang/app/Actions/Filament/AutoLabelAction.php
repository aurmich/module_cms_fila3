<?php

declare(strict_types=1);

namespace Modules\Lang\Actions\Filament;

use ReflectionClass;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Webmozart\Assert\Assert;
use Filament\Tables\Columns\Column;
use Filament\Forms\Components\Field;
use Filament\Tables\Filters\BaseFilter;
use Modules\Lang\Actions\SaveTransAction;
use Filament\Forms\Components\Wizard\Step;
use Modules\Xot\Actions\GetTransKeyAction;
use Spatie\QueueableAction\QueueableAction;
use Filament\Tables\Actions\Action as TableAction;

class AutoLabelAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     * return number of input added.
     *
     * @param Field|BaseFilter|Column|Step|Action|TableAction $component
     *
     * @return Field|BaseFilter|Column|Step|Action|TableAction
     */
    public function execute($component,string $type = 'label')
    {
        $backtrace = debug_backtrace();
        $backtrace_slice = array_slice($backtrace, 2);
        $class = Arr::first($backtrace_slice, function ($item) use($component){
            if($item['function'] == 'execute'){
                return false;
            }
            
           if(isset($item['object']) && Str::startsWith($item['object']::class, 'Modules\\') && $item['object'] != $component  ){
              return true;
            }

            if(isset($item['class']) && Str::startsWith($item['class'], 'Modules\\') ){
                $reflection_class = new ReflectionClass($item['class'] );
                if (!$reflection_class->isAbstract()) {
                    return true;
                }
                
            }
            return false;
        });
       
        if (is_array($class)) {
            $object_class = null;
            if(isset($class['object'])){
                $object_class = $class['object']::class;
            }
            if(isset($class['class']) && $object_class == null){
                $object_class = $class['class'];
            }
            if(is_null($object_class)){
                throw new \Exception('No object class found');
            }
            $trans_key = app(GetTransKeyAction::class)->execute($object_class);
        } else {
            $trans_key = 'lang::txt';
        }

        
        if ($component instanceof Step) {
            Assert::string($val = $component->getLabel());
            $label_tkey = $trans_key.'.steps.'.$val.'';
        } else {
            Assert::string($val = $component->getName());
            $label_tkey = $trans_key.'.fields.'.$val.'';
        }

        if ($component instanceof Action) {
            $label_tkey = $trans_key.'.actions.'.$val.'';
        }

        $label_key = $label_tkey.'.'.Str::snake($type);

        if(Str::startsWith($label_key,'media::attachments_schema')){
            dddx([
                'message'=>'preso',
                'label_key'=>$label_key,
                'label_tkey'=>$label_tkey,
                'val'=>$val,
                'type'=>$type,
                'component'=>$component,
                'class'=>$class,
                'backtrace'=>$backtrace,
            ]);
        }

        $label = trans($label_key);
        if (is_string($label) && $label_key == $label) { //se non esiste la traduzione, la salvo
            
            app(SaveTransAction::class)->execute($label_key, $val);
        }
        if (is_string($label) && $label_key != $label) { //se esiste la traduzione, la aggiorno
            /*
            if ($label_key == $label) {
                $label_value = $val;
                $label_key1 = $label_tkey;
                $label1 = trans($label_key1);
                if ($label_key1 != $label1) {
                    $label_value = $label1;
                }

                app(SaveTransAction::class)->execute($label_key, $label_value);
            }
            */
            if (method_exists($component, $type)) {
                $component->{$type}($label);
            }
            
            if (method_exists($component, 'tooltip')) {
                $component->tooltip($label);
            }
        }
        if (!is_string($label)) {
            $component->label('FIX:'.$label_key);
        }

        return $component;
    }
}
