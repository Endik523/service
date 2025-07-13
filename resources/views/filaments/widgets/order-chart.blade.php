@php
    $chartData = $this->getData();
    $message = $chartData['metadata']['message'] ?? null;
    $chartId = 'orderChart-' . md5(serialize($chartData));
@endphp

<x-filament::widget>
    <x-filament::card>
        <div class="flex justify-between items-center px-4 py-3 bg-gray-800 rounded-t-lg border-b">
            <h2 class="text-lg font-bold text-gray-800">
                {{ $this->getHeading() }}
            </h2>
            <div class="flex space-x-2">
                @foreach($this->getFilters() as $property => $filter)
                   <select 
    wire:model.live="{{ $property }}"
    style="background-color: #1F2937 !important; color: white !important; border-color: #374151 !important;"
    class="text-sm rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500"
>

                        @foreach($filter['options'] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                @endforeach
            </div>
        </div>

        <div class="p-4">
            @if(empty($chartData['labels']))
                <div class="text-center py-8 text-gray-500">
                    {{ $message ?? 'Tidak ada data untuk ditampilkan' }}
                </div>
            @else
               <div wire:ignore 
                    x-data="{
                        chartInstance: null,
                        initChart() {
                            const ctx = document.getElementById('{{ $chartId }}');
                            if (!ctx) {
                                console.error('Canvas element not found');
                                return;
                            }
                            
                            if (this.chartInstance) {
                                this.chartInstance.destroy();
                            }

                            try {
                                this.chartInstance = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: @js($chartData['labels']),
                                        datasets: @js($chartData['datasets'])
                                    },
                                    options: @js($this->getOptions())
                                });
                            } catch (error) {
                                console.error('Chart initialization error:', error);
                            }
                        }
                    }"
                    x-init="() => {
                        // Initialize chart
                        $data.initChart();
                        
                        // Listen for Livewire updates
                        Livewire.hook('message.processed', (message) => {
                            if (message.component.id === $wire.__instance.id) {
                                $data.initChart();
                            }
                        });
                    }"
                    wire:key="chart-{{ $chartId }}">
                    <div class="chart-container" style="position: relative; height: 500px; width: 100%;">
                        <canvas id="{{ $chartId }}"></canvas>
                    </div>
                </div>

                <!-- Statistics Display -->
                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @isset($chartData['metadata']['statistics'])
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <div class="text-sm text-blue-600 font-medium">Rata-rata Historis</div>
                            <div class="text-lg font-bold text-blue-900">
                                {{ number_format($chartData['metadata']['statistics']['historical_avg'], 0) }}
                            </div>
                        </div>
                        <div class="bg-green-50 p-3 rounded-lg">
                            <div class="text-sm text-green-600 font-medium">Rata-rata Prediksi</div>
                            <div class="text-lg font-bold text-green-900">
                                {{ number_format($chartData['metadata']['statistics']['prediction_avg'], 0) }}
                            </div>
                        </div>
                        <div class="bg-yellow-50 p-3 rounded-lg">
                            <div class="text-sm text-yellow-600 font-medium">Total Historis</div>
                            <div class="text-lg font-bold text-yellow-900">
                                {{ number_format($chartData['metadata']['statistics']['total_historical_orders'], 0) }}
                            </div>
                        </div>
                        <div class="bg-purple-50 p-3 rounded-lg">
                            <div class="text-sm text-purple-600 font-medium">Total Prediksi</div>
                            <div class="text-lg font-bold text-purple-900">
                                {{ number_format($chartData['metadata']['statistics']['total_predicted_orders'], 0) }}
                            </div>
                        </div>
                    @endisset
                </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>
