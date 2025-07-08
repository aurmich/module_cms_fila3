<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Illuminate\View\Component;
use Modules\Xot\Datas\XotData;
use Modules\Cms\Datas\BlockData;
use Illuminate\Support\Facades\Blade;
use Modules\Cms\Models\Section as SectionModel;
use Illuminate\Contracts\View\View as ViewContract;

/**
 * Section Component.
 *
 * Renders a reusable section of the site using the Section model.
 *
 * @property string $slug The unique identifier for the section
 * @property string|null $view Custom view path for rendering
 * @property array $data Additional data to pass to the view
 */
class Section extends Component
{
    public string $slug;
    public array $blocks = [];
    public ?string $name = null;
    public ?string $class = null;
    public ?string $id = null;

    /**
     * Create a new component instance.
     *
     * @param string $slug Unique identifier for the section
     * @param string|null $class Additional CSS classes
     * @param string|null $id Custom ID for the section
     */
    public function __construct(
        string $slug,
        ?string $class = null,
        ?string $id = null
    ) {
        $this->slug = $slug;
        $this->class = $class;
        $this->id = $id;

        $where = ['slug' => $slug];
        $update = [
            'title' => $slug,
            'blocks' => [],
            'attributes' => [
                'class' => $class,
                'id' => $id
            ]
        ];

        Assert::isInstanceOf(
            $section = SectionModel::firstOrCreate($where, $update),
            SectionModel::class,
            '['.__LINE__.']['.__FILE__.']'
        );

        //Assert::string($name = $section->getTranslation('name', app()->getLocale()));
        //$this->name = $name;
        $this->name = $section->name;

        $blocks = $section->blocks;

        if(!is_array($blocks)){
            $primary_lang=XotData::make()->primary_lang;
            $blocks = $section->getTranslation('blocks',$primary_lang);
        }
        
        
        if(!is_array($blocks)){
            $blocks = [];
        }

        $this->blocks = BlockData::collect($blocks);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): ViewContract
    {
        $view='pub_theme::components.sections.'.$this->slug;
        if(!view()->exists($view)){
            throw new \Exception('View '.$view.' not found');
        }
        return view($view);
    }
}
