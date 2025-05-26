declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Calendar;

use Livewire\Component;
use Modules\SaluteOra\Traits\HasFullCalendarConfig;

class Calendar extends Component
{
    use HasFullCalendarConfig;

    public function render()
    {
        return view('saluteora::livewire.calendar');
    }
}
