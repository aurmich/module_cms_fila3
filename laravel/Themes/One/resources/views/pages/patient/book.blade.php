<?php
declare(strict_types=1);
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Volt\Component;
use function Laravel\Folio\{middleware, name};
use Livewire\Attributes\Validate;


//middleware(['guest']);
name('patient.book');

new class extends Component
{
    #[Validate('required')]
    public $type;

    //public function mount(string $type)
    //{
    //    $this->type = $type;
    //}

    // Logica del componente se necessaria
};

?>

<x-layouts.app>
    @volt('patient.book')
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-12">

        <!-- Card contenente il form di registrazione -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            @livewire(\Modules\SaluteOra\Filament\Widgets\Patient\FindDoctorAndAppointmentWidget::class, [])
        </div>

    </div>
    @endvolt
</x-layouts.app>
