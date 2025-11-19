@extends('shared::layouts.admin')

@section('title', 'Migrar Verticales de Categorías')

@section('content')
<div class="container-fluid" x-data="verticalMigrationManager">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-body-large font-bold text-black-500">Migrar Verticales de Categorías</h1>
            <p class="text-body-regular text-black-300 mt-1">Asigna verticales a categorías que aún no lo tienen</p>
        </div>
        <a href="{{ route('superlinkiu.business-categories.index') }}" class="btn-secondary flex items-center gap-2">
            <x-solar-arrow-left-outline class="w-5 h-5" />
            Volver a Categorías
        </a>
    </div>

    @if(empty($suggestions))
        {{-- No hay categorías sin vertical --}}
        <div class="bg-success-50 border border-success-200 rounded-lg p-8 text-center">
            <x-solar-check-circle-outline class="w-16 h-16 text-success-300 mx-auto mb-4" />
            <h2 class="text-xl font-bold text-success-800 mb-2">¡Todo listo!</h2>
            <p class="text-success-700">Todas las categorías ya tienen vertical asignado.</p>
        </div>
    @else
        {{-- Formulario de migración --}}
        <form action="{{ route('superlinkiu.business-categories.apply-verticals') }}" method="POST" @submit="validateForm">
            @csrf

            {{-- Resumen --}}
            @php
                $clear = count(array_filter($suggestions, fn($s) => $s['status'] === 'clear'));
                $likely = count(array_filter($suggestions, fn($s) => $s['status'] === 'likely'));
                $ambiguous = count(array_filter($suggestions, fn($s) => $s['status'] === 'ambiguous'));
                $noMatch = count(array_filter($suggestions, fn($s) => $s['status'] === 'no_match' || $s['status'] === 'no_features'));
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <p class="text-xs font-medium text-gray-500 uppercase">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ count($suggestions) }}</p>
                </div>
                <div class="bg-success-50 border border-success-200 rounded-lg p-4">
                    <p class="text-xs font-medium text-success-600 uppercase">Claras (≥90%)</p>
                    <p class="text-2xl font-bold text-success-700">{{ $clear }}</p>
                </div>
                <div class="bg-warning-50 border border-warning-200 rounded-lg p-4">
                    <p class="text-xs font-medium text-warning-600 uppercase">Probables (≥60%)</p>
                    <p class="text-2xl font-bold text-warning-700">{{ $likely }}</p>
                </div>
                <div class="bg-error-50 border border-error-200 rounded-lg p-4">
                    <p class="text-xs font-medium text-error-600 uppercase">Revisar Manual</p>
                    <p class="text-2xl font-bold text-error-700">{{ $ambiguous + $noMatch }}</p>
                </div>
            </div>

            {{-- Lista de categorías --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($suggestions as $index => $suggestion)
                            @php
                                $category = $suggestion['category'];
                                $scores = $suggestion['suggestions'];
                                $topSuggestion = !empty($scores) ? reset($scores) : null;
                                $topVertical = !empty($scores) ? array_key_first($scores) : null;
                            @endphp

                            <div class="border border-gray-200 rounded-lg p-4 {{ $suggestion['status'] === 'clear' ? 'bg-success-50 border-success-200' : ($suggestion['status'] === 'likely' ? 'bg-warning-50 border-warning-200' : 'bg-gray-50') }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                                            @if($suggestion['status'] === 'clear')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                                    ✅ Sugerencia Clara
                                                </span>
                                            @elseif($suggestion['status'] === 'likely')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-100 text-warning-800">
                                                    ⚠️ Sugerencia Probable
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-error-100 text-error-800">
                                                    ❓ Requiere Revisión
                                                </span>
                                            @endif
                                        </div>

                                        @if($category->description)
                                            <p class="text-sm text-gray-600 mb-3">{{ $category->description }}</p>
                                        @endif

                                        @if(!empty($scores))
                                            <div class="mb-3">
                                                <p class="text-xs font-medium text-gray-700 mb-2">Sugerencias según features actuales:</p>
                                                <div class="space-y-2">
                                                    @foreach(array_slice($scores, 0, 3, true) as $verticalKey => $score)
                                                        @php
                                                            $verticalNames = [
                                                                'ecommerce' => 'Ecommerce',
                                                                'restaurant' => 'Restaurante',
                                                                'hotel' => 'Hotel',
                                                                'dropshipping' => 'Dropshipping'
                                                            ];
                                                        @endphp
                                                        <div class="flex items-center justify-between text-sm">
                                                            <span class="text-gray-700">{{ $verticalNames[$verticalKey] ?? $verticalKey }}</span>
                                                            <div class="flex items-center gap-2">
                                                                <div class="w-24 bg-gray-200 rounded-full h-2">
                                                                    <div class="bg-primary-300 h-2 rounded-full" style="width: {{ $score['percentage'] }}%"></div>
                                                                </div>
                                                                <span class="text-xs font-medium text-gray-600 w-12 text-right">{{ $score['percentage'] }}%</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-sm text-error-600 mb-3">{{ $suggestion['message'] }}</p>
                                        @endif
                                    </div>

                                    <div class="ml-4">
                                        <select 
                                            name="assignments[{{ $index }}][vertical]" 
                                            x-model="assignments[{{ $category->id }}]"
                                            required
                                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-200 focus:border-primary-200 min-w-[150px]">
                                            <option value="">Selecciona...</option>
                                            <option value="ecommerce">Ecommerce</option>
                                            <option value="restaurant">Restaurante</option>
                                            <option value="hotel">Hotel</option>
                                            <option value="dropshipping">Dropshipping</option>
                                        </select>
                                        <input type="hidden" name="assignments[{{ $index }}][category_id]" value="{{ $category->id }}">
                                        
                                        @if($topVertical)
                                            <button 
                                                type="button"
                                                @click="assignments[{{ $category->id }}] = '{{ $topVertical }}'"
                                                class="mt-2 text-xs text-primary-200 hover:text-primary-300">
                                                Usar sugerencia ({{ $topSuggestion['percentage'] }}%)
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-between items-center">
                    <p class="text-sm text-gray-600">
                        <span x-text="getSelectedCount()"></span> categorías con vertical seleccionado
                    </p>
                    <div class="flex gap-3">
                        <button type="button" @click="selectAllSuggestions()" class="btn-secondary">
                            Usar Todas las Sugerencias
                        </button>
                        <button type="submit" class="btn-primary" :disabled="getSelectedCount() === 0">
                            Aplicar Verticales
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('verticalMigrationManager', () => ({
        assignments: {},

        init() {
            // Inicializar assignments vacío
            @foreach($suggestions as $index => $suggestion)
                @if(!empty($suggestion['suggestions']))
                    @php
                        $topVertical = array_key_first($suggestion['suggestions']);
                    @endphp
                    // No preseleccionar, dejar que el usuario decida
                @endif
            @endforeach
        },

        getSelectedCount() {
            return Object.values(this.assignments).filter(v => v !== '' && v !== null).length;
        },

        selectAllSuggestions() {
            @foreach($suggestions as $index => $suggestion)
                @if(!empty($suggestion['suggestions']))
                    @php
                        $topVertical = array_key_first($suggestion['suggestions']);
                    @endphp
                    this.assignments[{{ $suggestion['category']->id }}] = '{{ $topVertical }}';
                @endif
            @endforeach
        },

        validateForm(event) {
            const selectedCount = this.getSelectedCount();
            if (selectedCount === 0) {
                event.preventDefault();
                alert('Por favor selecciona al menos un vertical para aplicar.');
                return false;
            }
            return true;
        }
    }));
});
</script>
@endsection

