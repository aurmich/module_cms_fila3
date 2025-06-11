{{--
    View: user::filament.widgets.login
    Scopo: Widget di login Filament conforme a Windsurf/Xot
    Modifica liberamente questa struttura per UX custom
--}}
<div class="filament-widget-login space-y-6">
    <form wire:submit.prevent="save" class="space-y-4">
        {{ $this->form }}
        <button type="submit" class="w-full py-3 rounded bg-[#0D9488] text-white font-bold transition">{{ __('Accedi') }}</button>
    </form>
    <div class="text-center text-sm text-gray-500 mt-2">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="underline hover:text-blue-700">{{ __('Password dimenticata?') }}</a>
        @endif
    </div>
</div>
