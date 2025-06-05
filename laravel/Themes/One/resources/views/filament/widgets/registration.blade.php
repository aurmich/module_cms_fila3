<x-filament-widgets::widget>
    <x-filament::section>
        <div class="max-w-4xl mx-auto">
            <form wire:submit.prevent="register" class="space-y-6">
                {{ $this->form }}
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
