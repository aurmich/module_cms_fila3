<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

<<<<<<< HEAD
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Section as SectionModel;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;
=======
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
>>>>>>> bc33217 (.)

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
<<<<<<< HEAD
    public null|string $name = null;
    public null|string $class = null;
    public null|string $id = null;
    public null|string $tpl = null;

=======
    public ?string $name = null;
    public ?string $class = null;
    public ?string $id = null;
    public ?string $tpl = null;
>>>>>>> bc33217 (.)
    /**
     * Create a new component instance.
     *
     * @param string $slug Unique identifier for the section
     * @param string|null $class Additional CSS classes
     * @param string|null $id Custom ID for the section
     */
    public function __construct(
        string $slug,
<<<<<<< HEAD
        null|string $class = null,
        null|string $id = null,
        null|string $tpl = null,
=======
        ?string $class = null,
        ?string $id = null,
        ?string $tpl = null
>>>>>>> bc33217 (.)
    ) {
        $this->slug = $slug;
        $this->class = $class;
        $this->id = $id;
        $this->tpl = $tpl;
        $this->blocks = SectionModel::getBlocksBySlug($this->slug);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): ViewContract
    {
<<<<<<< HEAD
        $view = 'pub_theme::components.sections.' . $this->slug;
        if ($this->tpl) {
            $view .= '.' . $this->tpl;
        }
        if (!view()->exists($view)) {
            throw new \Exception('View ' . $view . ' not found');
=======
        $view='pub_theme::components.sections.'.$this->slug;
        if($this->tpl){
            $view.='.'.$this->tpl;
        }
        if(!view()->exists($view)){
            throw new \Exception('View '.$view.' not found');
>>>>>>> bc33217 (.)
        }
        return view($view);
    }
}
