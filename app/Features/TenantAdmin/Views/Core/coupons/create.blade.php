<x-tenant-admin-layout :store="$store">
    @section('title', 'Nuevo Cupón')

    @section('content')
    <div class="max-w-4xl mx-auto space-y-6" x-data="couponForm()" x-init="init()">
        {{-- Encabezado --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('tenant.admin.coupons.index', $store->slug) }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-800">Nuevo cupón</h1>
        </div>

        {{-- Estado de uso --}}
        {{-- COMPONENT: AlertSoft | props:{type:info, message:"Estás usando ..."} --}}
        <x-alert-soft
            type="info"
            :message="'Estás usando ' . $currentCount . ' de ' . $maxCoupons . ' cupones disponibles en tu plan ' . $store->plan->name . '.'"
        />
        {{-- End COMPONENT: AlertSoft --}}

        {{-- Formulario --}}
        <form action="{{ route('tenant.admin.coupons.store', $store->slug) }}" method="POST">
            @csrf

            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-6 space-y-8">
                    {{-- Información básica --}}
                    <section class="space-y-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-with-label
                                    label="Nombre del cupón"
                                    name="name"
                                    id="coupon-name"
                                    placeholder="Ej: Descuento de bienvenida"
                                    container-class="w-full"
                                    maxlength="120"
                                    required
                                    x-model="form.name"
                                    value="{{ old('name') }}"
                                />
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-input-with-label
                                    label="Código del cupón (opcional)"
                                    name="code"
                                    id="coupon-code"
                                    placeholder="Ej: BIENVENIDA20"
                                    container-class="w-full"
                                    x-model="form.code"
                                    x-on:input="form.code = (form.code || '').toUpperCase()"
                                    value="{{ old('code') }}"
                                />
                                @error('code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <x-textarea-with-label
                            label="Descripción (opcional)"
                            textarea-name="description"
                            textarea-id="coupon-description"
                            container-class="w-full"
                            rows="3"
                            placeholder="Comparte un mensaje que explique el beneficio del cupón"
                            x-model="form.description"
                        >{{ old('description') }}</x-textarea-with-label>
                    </section>

                    {{-- Descuento y alcance --}}
                    <section class="space-y-4">
                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <x-select-with-label
                                    label="Aplicar a"
                                    name="type"
                                    :selected="old('type', 'global')"
                                    :options="collect(\App\Features\TenantAdmin\Models\Coupon::TYPES)->prepend('Selecciona una opción', '')"
                                    x-model="form.type"
                                    class="w-full"
                                />
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-select-with-label
                                    label="Tipo de descuento"
                                    name="discount_type"
                                    :selected="old('discount_type', 'percentage')"
                                    :options="collect(\App\Features\TenantAdmin\Models\Coupon::DISCOUNT_TYPES)->prepend('Selecciona una opción', '')"
                                    x-model="form.discountType"
                                    class="w-full"
                                />
                                @error('discount_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-input-with-label
                                    label="Valor del descuento"
                                    type="number"
                                    name="discount_value"
                                    id="discount-value"
                                    container-class="w-full"
                                    placeholder="Ingresa el valor"
                                    step="0.01"
                                    min="0.01"
                                    x-bind:max="form.discountType === 'percentage' ? 100 : null"
                                    required
                                    x-model.number="form.discountValue"
                                    value="{{ old('discount_value') }}"
                                />
                                <p class="mt-1 text-xs text-gray-500" x-text="form.discountType === 'percentage' ? 'Ingresa el porcentaje de descuento (0 a 100).' : 'Ingresa el monto en pesos que se descontará.'"></p>
                                @error('discount_value')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div x-show="form.discountType === 'percentage'" x-cloak>
                                <x-input-with-label
                                    label="Descuento máximo ($)"
                                    type="number"
                                    name="max_discount_amount"
                                    id="max-discount-amount"
                                    container-class="w-full"
                                    placeholder="Ej: 50000"
                                    step="100"
                                    min="0"
                                    value="{{ old('max_discount_amount') }}"
                                />
                                @error('max_discount_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-input-with-label
                                    label="Compra mínima ($)"
                                    type="number"
                                    name="min_purchase_amount"
                                    id="min-purchase-amount"
                                    container-class="w-full"
                                    placeholder="Ej: 30000"
                                    step="100"
                                    min="0"
                                    value="{{ old('min_purchase_amount') }}"
                                />
                                @error('min_purchase_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    {{-- Aplicabilidad --}}
                    <section class="space-y-4" x-show="form.type !== 'global'" x-cloak>
                        <div x-show="form.type === 'categories'">
                            <p class="text-sm font-medium text-gray-600">Selecciona las categorías en las que se aplicará el cupón.</p>
                            <div class="max-h-60 space-y-2 overflow-y-auto pr-1">
                                @foreach($categories as $category)
                                    <div class="rounded-xl border border-gray-200 p-3 hover:bg-gray-50">
                                        <x-checkbox-with-description
                                            :checkbox-id="'category-'.$category->id"
                                            checkbox-name="categories[]"
                                            :checked="in_array($category->id, old('categories', []))"
                                            :title="$category->name"
                                            description=""
                                            value="{{ $category->id }}"
                                        />
                                    </div>
                                @endforeach
                            </div>
                            @error('categories')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div x-show="form.type === 'products'" x-cloak>
                            <p class="text-sm font-medium text-gray-600">Selecciona los productos donde el cupón será válido.</p>
                            <div class="max-h-60 space-y-2 overflow-y-auto pr-1">
                                @foreach($products as $product)
                                    <div class="rounded-xl border border-gray-200 p-3 hover:bg-gray-50">
                                        <x-checkbox-with-description
                                            :checkbox-id="'product-'.$product->id"
                                            checkbox-name="products[]"
                                            :checked="in_array($product->id, old('products', []))"
                                            :title="$product->name"
                                            :description="'$'.number_format($product->price, 0, ',', '.')"
                                            value="{{ $product->id }}"
                                        />
                                    </div>
                                @endforeach
                            </div>
                            @error('products')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>

                    {{-- Restricciones y límites --}}
                    <section class="space-y-6">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-with-label
                                    label="Límite total de usos (opcional)"
                                    type="number"
                                    name="max_uses"
                                    id="max-uses"
                                    container-class="w-full"
                                    placeholder="Ej: 100"
                                    min="1"
                                    value="{{ old('max_uses') }}"
                                />
                                @error('max_uses')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-input-with-label
                                    label="Usos por cliente (opcional)"
                                    type="number"
                                    name="uses_per_session"
                                    id="uses-per-session"
                                    container-class="w-full"
                                    placeholder="Ej: 1"
                                    min="1"
                                    value="{{ old('uses_per_session') }}"
                                />
                                @error('uses_per_session')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-with-label
                                    label="Fecha de inicio (opcional)"
                                    type="datetime-local"
                                    name="start_date"
                                    id="start-date"
                                    container-class="w-full"
                                    value="{{ old('start_date') }}"
                                />
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-input-with-label
                                    label="Fecha de fin (opcional)"
                                    type="datetime-local"
                                    name="end_date"
                                    id="end-date"
                                    container-class="w-full"
                                    value="{{ old('end_date') }}"
                                />
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800">Restricciones horarias</h4>
                                    <p class="text-xs text-gray-500">Limita el uso del cupón a días y horarios específicos.</p>
                                </div>
                                <button type="button" class="text-sm font-semibold text-blue-600 hover:text-blue-700" @click.prevent="showTimeRestrictions = !showTimeRestrictions">
                                    <span x-text="showTimeRestrictions ? 'Ocultar' : 'Configurar'"></span>
                                </button>
                            </div>
                            <div x-show="showTimeRestrictions" x-transition class="mt-4 space-y-4" x-cloak>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Días permitidos</p>
                                    <div class="grid grid-cols-2 gap-2 md:grid-cols-4">
                                        @php
                                            $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                        @endphp
                                        @foreach($days as $index => $day)
                                            <label class="flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50">
                                                <input type="checkbox"
                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                    name="days_of_week[]"
                                                    value="{{ $index }}"
                                                    @checked(is_array(old('days_of_week')) && in_array($index, old('days_of_week')))
                                                >
                                                <span class="text-gray-700">{{ $day }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <x-input-with-label
                                            label="Hora de inicio"
                                            type="time"
                                            name="start_time"
                                            id="start-time"
                                            container-class="w-full"
                                            value="{{ old('start_time') }}"
                                        />
                                        @error('start_time')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <x-input-with-label
                                            label="Hora de fin"
                                            type="time"
                                            name="end_time"
                                            id="end-time"
                                            container-class="w-full"
                                            value="{{ old('end_time') }}"
                                        />
                                        @error('end_time')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="border-t border-gray-200 p-6 space-y-6">
                    {{-- Configuración rápida --}}
                    <section class="flex justify-between gap-4 md:grid-cols-3">
                        <div class="col-span-1 flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            <x-switch-basic switch-id="is-active" switch-name="is_active" value="1" :checked="(bool) old('is_active', true)" />
                            <div>
                                <p class="text-sm font-medium text-gray-800">Activar al guardar</p>
                                <p class="text-xs text-gray-500">El cupón estará disponible inmediatamente.</p>
                            </div>
                        </div>
                        <div class="col-span-1 flex items-center gap-3">
                            <input type="hidden" name="is_public" value="0">
                            <x-switch-basic switch-id="is-public" switch-name="is_public" value="1" :checked="(bool) old('is_public')" />
                            <div>
                                <p class="text-sm font-medium text-gray-800">Cupón público</p>
                                <p class="text-xs text-gray-500">Visible en la tienda para todos los clientes.</p>
                            </div>
                        </div>
                        <div class="col-span-1 flex items-center gap-3">
                            <input type="hidden" name="is_automatic" value="0">
                            <x-switch-basic switch-id="is-automatic" switch-name="is_automatic" value="1" :checked="(bool) old('is_automatic')" />
                            <div>
                                <p class="text-sm font-medium text-gray-800">Aplicación automática</p>
                                <p class="text-xs text-gray-500">El sistema aplicará el cupón sin código.</p>
                            </div>
                        </div>
                    </section>

                    {{-- Vista previa --}}
                    <section>
                        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col gap-1">
                                    <span class="text-sm font-semibold text-gray-900" x-text="form.name || 'Nombre del cupón'"></span>
                                    <span class="text-xs font-mono uppercase tracking-wide text-gray-500" x-text="form.code || 'CÓDIGO-AUTO'"></span>
                                </div>
                                <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700" x-text="previewScope"></span>
                            </div>
                            <div class="mt-4 text-2xl font-semibold text-blue-600">
                                <span x-show="isPercentage" x-text="(form.discountValue || 0) + '%'" x-cloak></span>
                                <span x-show="!isPercentage" x-text="currencyValue" x-cloak></span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Descuento estimado sobre el subtotal elegible.</p>
                        </div>
                    </section>

                    {{-- Acciones --}}
                    <section class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div class="flex gap-3 md:order-2">
                            <x-button-icon 
                                type="solid" 
                                color="dark" 
                                icon="check" 
                                text="Crear cupón" 
                                html-type="submit" 
                            />
                            <a href="{{ route('tenant.admin.coupons.index', $store->slug) }}">
                                <x-button-base type="outline" color="error" text="cancelar" />
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 md:order-1">Revisa la configuración antes de guardar.</p>
                    </section>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function couponForm() {
            return {
                form: {
                    name: @js(old('name')),
                    code: @js(old('code')),
                    description: @js(old('description')),
                    type: @js(old('type', 'global')),
                    discountType: @js(old('discount_type', 'percentage')),
                    discountValue: @js(old('discount_value', '')),
                },
                showTimeRestrictions: {{ (old('days_of_week') || old('start_time') || old('end_time')) ? 'true' : 'false' }},

                init() {
                    if (this.form.code) {
                        this.form.code = this.form.code.toUpperCase();
                    }
                },

                get previewScope() {
                    switch (this.form.type) {
                        case 'categories':
                            return 'Categorías';
                        case 'products':
                            return 'Productos';
                        default:
                            return 'Global';
                    }
                },

                get isPercentage() {
                    return this.form.discountType === 'percentage';
                },

                get currencyValue() {
                    const amount = parseFloat(this.form.discountValue || 0);
                    return amount > 0 ? `$${amount.toLocaleString('es-CO')}` : '$0';
                },
            };
        }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 