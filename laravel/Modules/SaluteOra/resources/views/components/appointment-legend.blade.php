<div class="p-4 space-y-4">
    <p class="text-sm text-gray-600 dark:text-gray-400">
        {{ __('saluteora::appointment.legend.description') }}
    </p>

    <div class="space-y-2">
        <h4 class="font-medium text-gray-900 dark:text-white">
            {{ __('saluteora::appointment.legend.types') }}
        </h4>
        
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 rounded-full" style="background-color: #34D399;"></div>
            <span class="text-sm">{{ __('saluteora::appointment.legend.availability') }}</span>
        </div>
        
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 rounded-full" style="background-color: #F59E0B;"></div>
            <span class="text-sm">{{ __('saluteora::appointment.legend.pending') }}</span>
        </div>
        
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 rounded-full" style="background-color: #3B82F6;"></div>
            <span class="text-sm">{{ __('saluteora::appointment.legend.confirmed') }}</span>
        </div>
        
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 rounded-full" style="background-color: #10B981;"></div>
            <span class="text-sm">{{ __('saluteora::appointment.legend.completed') }}</span>
        </div>
        
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 rounded-full" style="background-color: #EF4444;"></div>
            <span class="text-sm">{{ __('saluteora::appointment.legend.cancelled') }}</span>
        </div>
    </div>

    <div class="space-y-2">
        <h4 class="font-medium text-gray-900 dark:text-white">
            {{ __('saluteora::appointment.legend.icons') }}
        </h4>
        
        <div class="flex items-center space-x-2">
            <span class="text-lg">🟢</span>
            <span class="text-sm">{{ __('saluteora::appointment.legend.availability_icon') }}</span>
        </div>
        
        <div class="flex items-center space-x-2">
            <span class="text-lg">⏳</span>
            <span class="text-sm">{{ __('saluteora::appointment.legend.pending_icon') }}</span>
        </div>
        
        <div class="flex items-center space-x-2">
            <span class="text-lg">✅</span>
            <span class="text-sm">{{ __('saluteora::appointment.legend.confirmed_icon') }}</span>
        </div>
        
        <div class="flex items-center space-x-2">
            <span class="text-lg">✓</span>
            <span class="text-sm">{{ __('saluteora::appointment.legend.completed_icon') }}</span>
        </div>
        
        <div class="flex items-center space-x-2">
            <span class="text-lg">❌</span>
            <span class="text-sm">{{ __('saluteora::appointment.legend.cancelled_icon') }}</span>
        </div>
    </div>

    <div class="pt-2 mt-4 border-t border-gray-200 dark:border-gray-700">
        <h4 class="font-medium text-gray-900 dark:text-white">
            {{ __('saluteora::appointment.legend.instructions') }}
        </h4>
        
        <ul class="pl-4 mt-2 space-y-1 list-disc">
            <li class="text-sm">
                {{ __('saluteora::appointment.legend.instruction_add') }}
            </li>
            <li class="text-sm">
                {{ __('saluteora::appointment.legend.instruction_edit') }}
            </li>
            <li class="text-sm">
                {{ __('saluteora::appointment.legend.instruction_delete') }}
            </li>
            <li class="text-sm">
                {{ __('saluteora::appointment.legend.instruction_approve') }}
            </li>
        </ul>
    </div>
</div>
