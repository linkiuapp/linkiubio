<x-tenant-admin-layout :store="$store">
    @section('title', 'Detalles del Slider')

    @section('content')
    <div
        class="max-w-5xl mx-auto"
        x-data="(() => ({
            sliderIsActive: {{ json_encode((bool) $slider->is_active) }},
            sliderIsScheduled: {{ json_encode((bool) $slider->is_scheduled) }},
            toggleLoading: false,
            successMessage: '',
            errorMessage: '',
            toggleUrl: {{ json_encode(route('tenant.admin.sliders.toggle-status', [$store->slug, $slider->id])) }},
            csrfToken: {{ json_encode(csrf_token()) }},

            async toggleStatus() {
                if (this.toggleLoading) {
                    return;
                }

                this.toggleLoading = true;
                this.successMessage = '';
                this.errorMessage = '';

                try {
                    const response = await fetch(this.toggleUrl, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    });

                    if (!response.ok) {
                        throw new Error('Respuesta no válida del servidor');
                    }

                    const data = await response.json();

                    if (data && data.success) {
                        this.sliderIsActive = !!data.is_active;
                        this.successMessage = data.message || 'Estado actualizado correctamente.';
                    } else {
                        this.errorMessage = (data && data.message) ? data.message : 'No se pudo actualizar el estado.';
                    }
                } catch (error) {
                    console.error('Error al cambiar estado del slider:', error);
                    this.errorMessage = 'Ocurrió un error al actualizar el estado. Intenta nuevamente.';
                } finally {
                    this.toggleLoading = false;
                }
            }
        }))()"
    >
        <x-card-base size="lg" shadow="sm">
            <template x-if="successMessage">
                <div
                    class="mb-4"
                    x-cloak
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-2"
                    x-init="setTimeout(() => show = false, 5000)"
                >
                    <x-alert-bordered type="success" title="Actualización exitosa">
                        <span x-text="successMessage"></span>
                    </x-alert-bordered>
                </div>
            </template>

            <template x-if="errorMessage">
                <div
                    class="mb-4"
                    x-cloak
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-2"
                    x-init="setTimeout(() => show = false, 5000)"
                >
                    <x-alert-bordered type="error" title="No se pudo completar la acción">
                        <span x-text="errorMessage"></span>
                    </x-alert-bordered>
                </div>
            </template>

            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('tenant.admin.sliders.index', $store->slug) }}">
                        <x-button-icon type="ghost" color="secondary" icon="arrow-left" text="" />
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-800">Detalles del Slider</h1>
                        <p class="text-sm text-gray-500">Visualiza la configuración actual del slider</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('tenant.admin.sliders.edit', [$store->slug, $slider->id]) }}">
                        <x-button-icon type="solid" color="dark" icon="edit" text="Editar" />
                    </a>
                    <div class="relative flex items-center gap-2">
                        <x-button-base
                            type="outline"
                            color="warning"
                            text="Desactivar"
                            icon-position="left"
                            class="inline-flex items-center gap-2"
                            x-show="sliderIsActive"
                            x-cloak
                            x-bind:disabled="toggleLoading"
                            @click="toggleStatus"
                        >
                            <x-slot:icon>
                                <i data-lucide="toggle-left" class="size-4"></i>
                            </x-slot:icon>
                        </x-button-base>

                        <x-button-base
                            type="outline"
                            color="success"
                            text="Activar"
                            icon-position="left"
                            class="inline-flex items-center gap-2"
                            x-show="!sliderIsActive"
                            x-cloak
                            x-bind:disabled="toggleLoading"
                            @click="toggleStatus"
                        >
                            <x-slot:icon>
                                <i data-lucide="toggle-right" class="size-4"></i>
                            </x-slot:icon>
                        </x-button-base>

                        <span
                            x-show="toggleLoading"
                            x-cloak
                            class="text-xs text-gray-500"
                        >Procesando…</span>
                    </div>
                </div>
            </div>

            <template x-if="!sliderIsActive">
                <div class="mb-6" x-cloak>
                    <x-alert-soft type="warning" message="Este slider está desactivado y no se mostrará en tu tienda." />
                </div>
            </template>

            <template x-if="sliderIsActive && sliderIsScheduled">
                <div class="mb-6" x-cloak>
                    <x-alert-soft type="info" message="Este slider cuenta con programación activa." />
                </div>
            </template>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-6">
                    <!-- Información general -->
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">
                        <h2 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i data-lucide="info" class="size-4 text-blue-500"></i>
                            Información General
                        </h2>
                        <dl class="space-y-2">
                            <div class="flex justify-between text-sm text-gray-600">
                                <dt>Nombre</dt>
                                <dd class="font-medium text-gray-900">{{ $slider->name }}</dd>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <dt>Orden</dt>
                                <dd class="font-medium text-gray-900">#{{ $slider->sort_order }}</dd>
                            </div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <dt>Estado</dt>
                                <div class="flex items-center gap-2">
                                    <template x-if="sliderIsActive">
                                        <x-badge-soft type="success" text="Activo" />
                                    </template>
                                    <template x-if="!sliderIsActive">
                                        <x-badge-soft type="error" text="Inactivo" />
                                    </template>
                                </div>
                            </div>
                            @if($slider->description)
                                <div class="pt-3 border-t border-gray-200">
                                    <dt class="text-xs font-semibold text-gray-500">Descripción</dt>
                                    <dd class="mt-1 text-sm text-gray-700">{{ $slider->description }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Configuración de enlace -->
                    <div class="rounded-xl border border-gray-200 bg-white p-5">
                        <h2 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i data-lucide="link" class="size-4 text-blue-500"></i>
                            Configuración de enlace
                        </h2>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Tipo</span>
                                @php
                                    $badgeType = match($slider->url_type) {
                                        'internal' => 'primary',
                                        'external' => 'info',
                                        default => 'secondary'
                                    };
                                    $badgeText = match($slider->url_type) {
                                        'internal' => 'Enlace interno',
                                        'external' => 'Enlace externo',
                                        default => 'Sin enlace'
                                    };

                                    $displayUrl = $slider->url;
                                    if ($slider->url && $slider->url_type === 'internal') {
                                        $displayUrl = url($store->slug . '/' . ltrim($slider->url, '/'));
                                    }
                                @endphp
                                <x-badge-soft :type="$badgeType" :text="$badgeText" />
                            </div>
                            @if($slider->url)
                                <div class="pt-2 border-t border-gray-200">
                                    <span class="text-xs font-semibold text-gray-500 block mb-1">URL</span>
                                    <a href="{{ $displayUrl }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-700 break-all inline-flex items-center gap-1">
                                        {{ $slider->url_type === 'internal' ? $displayUrl : $slider->url }}
                                        <i data-lucide="external-link" class="size-3.5"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Programación -->
                    <div class="rounded-xl border border-gray-200 bg-white p-5">
                        <h2 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i data-lucide="calendar" class="size-4 text-blue-500"></i>
                            Programación
                        </h2>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Estado</span>
                                <x-badge-soft :type="$slider->is_scheduled ? 'warning' : 'success'" :text="$slider->is_scheduled ? 'Programado' : 'Siempre activo'" />
                            </div>

                            @if($slider->is_scheduled)
                                <div class="flex justify-between">
                                    <span>Tipo de programación</span>
                                    <x-badge-soft :type="$slider->is_permanent ? 'success' : 'warning'" :text="$slider->is_permanent ? 'Permanente' : 'Con fecha fin'" />
                                </div>

                                <div class="grid grid-cols-1 gap-3">
                                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                        @if($slider->start_date)
                                            <div>
                                                <span class="text-xs font-semibold text-gray-500 block mb-1">Fecha inicio</span>
                                                <p class="text-sm text-gray-700">{{ optional($slider->start_date)->format('d/m/Y') }}</p>
                                            </div>
                                        @endif
                                        @if($slider->end_date)
                                            <div>
                                                <span class="text-xs font-semibold text-gray-500 block mb-1">Fecha fin</span>
                                                <p class="text-sm text-gray-700">{{ optional($slider->end_date)->format('d/m/Y') }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                        @if($slider->start_time)
                                            <div>
                                                <span class="text-xs font-semibold text-gray-500 block mb-1">Hora inicio</span>
                                                <p class="text-sm text-gray-700">{{ optional($slider->start_time)->format('H:i') }}</p>
                                            </div>
                                        @endif
                                        @if($slider->end_time)
                                            <div>
                                                <span class="text-xs font-semibold text-gray-500 block mb-1">Hora fin</span>
                                                <p class="text-sm text-gray-700">{{ optional($slider->end_time)->format('H:i') }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if($slider->scheduled_days && count(array_filter($slider->scheduled_days)) > 0)
                                        <div>
                                            <span class="text-xs font-semibold text-gray-500 block mb-2">Días activos</span>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach(['monday' => 'L', 'tuesday' => 'M', 'wednesday' => 'X', 'thursday' => 'J', 'friday' => 'V', 'saturday' => 'S', 'sunday' => 'D'] as $day => $label)
                                                    @if($slider->scheduled_days[$day] ?? false)
                                                        <x-badge-soft type="primary" :text="$label" />
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="space-y-6">
                    <div class="rounded-xl border border-gray-200 bg-white p-5">
                        <h2 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i data-lucide="image" class="size-4 text-blue-500"></i>
                            Imagen del slider
                        </h2>
                        @if($slider->image_path)
                            <div class="relative overflow-hidden rounded-lg border border-gray-200">
                                <img src="{{ Storage::disk('public')->url($slider->image_path) }}" alt="{{ $slider->name }}" class="w-full h-56 object-cover">
                                <div class="absolute bottom-3 right-3">
                                    <x-badge-soft type="info" text="420x200px" />
                                </div>
                            </div>
                        @else
                            <x-empty-state 
                                title="Sin imagen"
                                description="Este slider aún no tiene una imagen cargada."
                                svg="slider-empty.svg">
                                <x-slot:action>
                                    <x-button-base type="outline" color="secondary" text="Agregar imagen" />
                                </x-slot:action>
                            </x-empty-state>
                        @endif
                    </div>
                </div>
            </div>
        </x-card-base>
    </div>
    @endsection
</x-tenant-admin-layout> 