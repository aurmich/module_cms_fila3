<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('saluteora::widgets.studio_overview.title') }}
        </x-slot>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            @foreach ($stats as $key => $value)
                <x-filament::card>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('saluteora::widgets.studio_overview.stats.' . $key) }}
                            </h3>
                            <p class="text-3xl font-semibold text-gray-900 dark:text-white">
                                {{ $value }}
                            </p>
                        </div>
                        <div class="rounded-full bg-primary-50 p-3 dark:bg-primary-500/10">
                            @switch($key)
                                @case('total')
                                    <x-heroicon-o-building-office class="h-6 w-6 text-primary-500 dark:text-primary-400" />
                                    @break
                                @case('active')
                                    <x-heroicon-o-check-circle class="h-6 w-6 text-success-500 dark:text-success-400" />
                                    @break
                                @case('inactive')
                                    <x-heroicon-o-x-circle class="h-6 w-6 text-danger-500 dark:text-danger-400" />
                                    @break
                                @case('cities')
                                    <x-heroicon-o-map class="h-6 w-6 text-warning-500 dark:text-warning-400" />
                                    @break
                                @case('doctors')
                                    <x-heroicon-o-user-group class="h-6 w-6 text-info-500 dark:text-info-400" />
                                    @break
                                @case('appointments')
                                    <x-heroicon-o-calendar class="h-6 w-6 text-success-500 dark:text-success-400" />
                                    @break
                            @endswitch
                        </div>
                    </div>
                </x-filament::card>
            @endforeach
        </div>

        @if (count($citiesData) > 0)
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ __('saluteora::widgets.studio_overview.chart.title') }}
                </h3>
                <div class="mt-4 h-80">
                    <div x-data="{
                        chart: null,
                        init() {
                            this.chart = new ApexCharts(this.$refs.chart, {
                                chart: {
                                    type: 'pie',
                                    height: 300,
                                },
                                series: {{ json_encode(array_values($citiesData)) }},
                                labels: {{ json_encode(array_keys($citiesData)) }},
                                colors: [
                                    '#3b82f6', '#ef4444', '#10b981', '#f59e0b', 
                                    '#6366f1', '#84cc16', '#ec4899', '#14b8a6'
                                ],
                                legend: {
                                    position: 'bottom',
                                },
                                responsive: [{
                                    breakpoint: 480,
                                    options: {
                                        chart: {
                                            height: 300
                                        },
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }]
                            });
                            this.chart.render();
                        }
                    }" wire:ignore>
                        <div x-ref="chart"></div>
                    </div>
                </div>
            </div>
        @else
            <div class="mt-6 rounded-lg border border-dashed border-gray-300 p-8 text-center dark:border-gray-700">
                <p class="text-gray-500 dark:text-gray-400">
                    {{ __('saluteora::widgets.studio_overview.chart.empty') }}
                </p>
            </div>
        @endif
    </x-filament::section>
</x-filament::widget>