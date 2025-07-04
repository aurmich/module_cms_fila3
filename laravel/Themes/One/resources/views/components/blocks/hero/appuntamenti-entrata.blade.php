<?php
use Livewire\Volt\Component;
use Modules\SaluteOra\Models\Appointment;
$user=auth()->user();
$appointments = Appointment::all();

new class extends Component {
    public $count = 0;

    public function with(): array
    {
        return [
            'user' => auth()->user(),
            'appointments' => Appointment::paginate(10),
        ];
    }
 
    public function increment()
    {
        $this->count++;
    }
}
?>

<div>
    
    <!-- Back button -->
    <div class="w-full flex justify-start">
        {{-- DA AGGIORNARE URL --}}
        <a href="/it">
            <div class="cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" class="size-9">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </div>
        </a>
    </div>

    <!-- Page title -->
    <div class="p-10">
        <div class="w-full flex justify-center">
            <h1 class="text-center">Appuntamenti in Entrata</h1>
        </div>
    </div>
    {{--  
    @each('pub_theme::appointment.doctor-pending-item', $appointments, 'appointment','pub_theme::appointment.doctor-pending-empty')
    --}}
      <div>
    @livewire(\Modules\SaluteOra\Filament\Widgets\DoctorAppointmentsWidget::class, ['doctor_id' => $user->id,'state' => 'pending'])
    </div>
    
</div>
