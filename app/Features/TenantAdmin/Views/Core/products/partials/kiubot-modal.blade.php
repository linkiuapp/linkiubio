{{-- Modal de comparación KiuBot --}}
<div 
    x-show="showModal"
    x-cloak
    @keydown.escape.window="closeModal()"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div 
        x-show="showModal"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm"
        @click="closeModal()"
    ></div>

    {{-- Modal Content --}}
    <div 
        x-show="showModal"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 overflow-x-hidden overflow-y-auto pointer-events-none"
    >
        <div class="min-h-screen px-4 flex items-center justify-center pointer-events-none">
            <div 
                @click.stop
                class="relative w-full max-w-6xl bg-white rounded-xl shadow-2xl pointer-events-auto"
            >
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-blue-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">KiuBot - Descripción Mejorada</h3>
                            <p class="text-sm text-gray-600">Compara el texto original con la versión mejorada</p>
                        </div>
                    </div>
                    <button 
                        type="button"
                        @click="closeModal()"
                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/50 transition-colors"
                    >
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Body - Comparación lado a lado --}}
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Original --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                <h4 class="font-semibold text-gray-700">Texto Original</h4>
                            </div>
                            <div class="h-64 p-4 bg-gray-50 border border-gray-200 rounded-lg overflow-y-auto">
                                <p class="text-sm text-gray-700 whitespace-pre-wrap" x-text="originalText"></p>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                <span x-text="originalText?.length || 0"></span> caracteres
                            </div>
                        </div>

                        {{-- Mejorado --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-2 h-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full"></div>
                                <h4 class="font-semibold text-black-300">
                                    Texto Mejorado por KiuBot
                                </h4>
                            </div>
                            <div class="h-64 p-4 bg-gradient-to-br from-purple-50 to-blue-50 border-2 border-purple-200 rounded-lg overflow-y-auto">
                                <p class="text-sm text-gray-800 whitespace-pre-wrap font-medium" x-text="improvedText"></p>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                <span x-text="improvedText?.length || 0"></span> caracteres
                            </div>
                        </div>
                    </div>

                    {{-- Info adicional --}}
                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-blue-900">
                                <p class="font-medium">KiuBot ha mejorado tu descripción</p>
                                <ul class="mt-1 space-y-1 text-xs">
                                    <li>Ortografía y gramática corregidas</li>
                                    <li>Texto más atractivo y persuasivo</li>
                                    <li>Tono profesional optimizado para ecommerce</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer - Acciones --}}
                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <button 
                        type="button"
                        @click="regenerate()"
                        class="inline-flex items-center gap-2 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-blue-600 hover:bg-gradient-to-br shadow-xl shadow-indigo-500/50 inset-shadow-lg inset-shadow-indigo-500/50 font-medium rounded-full text-sm px-4 py-2.5 text-center leading-5"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Regenerar
                    </button>

                    <div class="flex items-center gap-3">
                        <button 
                            type="button"
                            @click="closeModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="button"
                            @click="useImprovedText()"
                            class="inline-flex items-center gap-2 text-white bg-gradient-to-r from-green-500 via-green-600 to-emerald-600 hover:bg-gradient-to-br shadow-xl shadow-green-500/50 inset-shadow-lg inset-shadow-green-500/50 font-medium rounded-full text-sm px-4 py-2.5 text-center leading-5"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Usar Este Texto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

