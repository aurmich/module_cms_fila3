<div class="p-4 bg-white rounded-lg shadow">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">
            {{ __('find_doctor_widget.title') }}
        </h3>
        <div class="flex items-center">
            <x-heroicon-o-user-plus class="w-5 h-5 text-primary-500" />
        </div>
    </div>

    <div class="space-y-4">
        {{ $this->form }}
    </div>
</div>
