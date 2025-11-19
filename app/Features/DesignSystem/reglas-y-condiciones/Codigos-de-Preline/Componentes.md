### 1. Reglas Importantes al momento de crear componente ###

- Recuerda aqui los pego en tal cual alla, pero no quiere decir que alla los vas ahcer en ingles, recuerda la regla, solo español
- No es necesario el darkmode - **Eliminar todas las clases `dark:` del código**
- Recuerda iconos de lucide 
```html
<i data-lucide="star" class="w-5 h-5"></i>
```
- Recuerda que funcionan es con HTML + Clases Tailwind básicas y no con las clases preline exactas - recrealas con clases tailwind
- **IMPORTANTE**: Mantener TODAS las clases de Preline exactas, solo:
  - ✅ Traducir textos al español
  - ✅ Eliminar clases `dark:`
  - ✅ Reemplazar SVG por iconos Lucide
  - ✅ **REGLAS DE BORDES**: Siempre usar `border border-gray-400` para todos los inputs. Los inputs con fondo gris mantienen `border-transparent`. Los estados de validación (error/success) mantienen sus colores específicos pero siempre con `border` explícito.
  - ✅ El resto de clases (incluyendo `hover:text-blue-70`, `focus:outline-hidden`, `hover:hover:text-blue-600`, etc.) se mantienen tal cual

### 2. Listado de input ###

**Reglas aplicadas:**
- ✅ Textos en español
- ✅ Sin clases `dark:`
- ✅ Iconos Lucide (reemplazando SVG)
- ✅ **Borders**: Siempre `border border-gray-400` (inputs con fondo gris mantienen `border-transparent`)
- ✅ Resto de clases Preline exactas (incluyendo `focus:ring-blue-500`, `disabled:opacity-50`, etc.)


Placeholder
Basic input example with placeholder.

<div class="max-w-sm space-y-3">
  <input type="text" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="This is placeholder">
</div>

Label
Basic input example with label.

<div class="max-w-sm">
  <label for="input-label" class="block text-sm font-medium mb-2 dark:text-white">Email</label>
  <input type="email" id="input-label" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="you@site.com">
</div>

Hidden label
<label> elements hidden using the .sr-only class

<div class="max-w-sm">
  <label for="input-email-label" class="sr-only">Email</label>
  <input type="email" id="input-email-label" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="you@site.com">
</div>

Basic
Basic input example.

<div class="max-w-sm space-y-3">
  <input type="text" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
</div>

Gray input
Example of a gray input style variant.

<div class="max-w-sm space-y-3">
  <div class="relative">
    <input type="email" class="peer py-2.5 sm:py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter name">
    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
      <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
      </svg>
    </div>
  </div>

  <div class="relative">
    <input type="password" class="peer py-2.5 sm:py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter password">
    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
      <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"></path>
        <circle cx="16.5" cy="7.5" r=".5"></circle>
      </svg>
    </div>
  </div>
</div>

Floating label
A placeholder is required on each <input> as our method uses the :placeholder-shown pseudo-element. Also note that the <input> must come first so we can utilize a sibling selector (e.g., ~).

<div class="max-w-sm space-y-3">
  <!-- Floating Input -->
  <div class="relative">
    <input type="email" id="hs-floating-input-email" class="peer p-4 block w-full border-gray-200 rounded-lg sm:text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600
    focus:pt-6
    focus:pb-2
    not-placeholder-shown:pt-6
    not-placeholder-shown:pb-2
    autofill:pt-6
    autofill:pb-2" placeholder="you@email.com">
    <label for="hs-floating-input-email" class="absolute top-0 start-0 p-4 h-full sm:text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent  origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
      peer-focus:scale-90
      peer-focus:translate-x-0.5
      peer-focus:-translate-y-1.5
      peer-focus:text-gray-500 dark:peer-focus:text-neutral-500
      peer-not-placeholder-shown:scale-90
      peer-not-placeholder-shown:translate-x-0.5
      peer-not-placeholder-shown:-translate-y-1.5
      peer-not-placeholder-shown:text-gray-500 dark:peer-not-placeholder-shown:text-neutral-500 dark:text-neutral-500">Email</label>
  </div>
  <!-- End Floating Input -->

  <!-- Floating Input -->
  <div class="relative">
    <input type="password" id="hs-floating-input-passowrd" class="peer p-4 block w-full border-gray-200 rounded-lg sm:text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600
    focus:pt-6
    focus:pb-2
    not-placeholder-shown:pt-6
    not-placeholder-shown:pb-2
    autofill:pt-6
    autofill:pb-2" placeholder="********">
    <label for="hs-floating-input-passowrd" class="absolute top-0 start-0 p-4 h-full sm:text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent  origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
      peer-focus:scale-90
      peer-focus:translate-x-0.5
      peer-focus:-translate-y-1.5
      peer-focus:text-gray-500 dark:peer-focus:text-neutral-500
      peer-not-placeholder-shown:scale-90
      peer-not-placeholder-shown:translate-x-0.5
      peer-not-placeholder-shown:-translate-y-1.5
      peer-not-placeholder-shown:text-gray-500 dark:peer-not-placeholder-shown:text-neutral-500 dark:text-neutral-500">Password</label>
  </div>
  <!-- End Floating Input -->

  <!-- Floating Input -->
  <div class="relative">
    <input type="email" id="hs-floating-gray-input-email" class="peer p-4 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600
    focus:pt-6
    focus:pb-2
    not-placeholder-shown:pt-6
    not-placeholder-shown:pb-2
    autofill:pt-6
    autofill:pb-2" placeholder="you@email.com">
    <label for="hs-floating-gray-input-email" class="absolute top-0 start-0 p-4 h-full sm:text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent  origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
      peer-focus:scale-90
      peer-focus:translate-x-0.5
      peer-focus:-translate-y-1.5
      peer-focus:text-gray-500 dark:peer-focus:text-neutral-500
      peer-not-placeholder-shown:scale-90
      peer-not-placeholder-shown:translate-x-0.5
      peer-not-placeholder-shown:-translate-y-1.5
      peer-not-placeholder-shown:text-gray-500 dark:peer-not-placeholder-shown:text-neutral-500 dark:text-neutral-500">Email</label>
  </div>
  <!-- End Floating Input -->

  <!-- Floating Input -->
  <div class="relative">
    <input type="password" id="hs-floating-gray-input-passowrd" class="peer p-4 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600
    focus:pt-6
    focus:pb-2
    not-placeholder-shown:pt-6
    not-placeholder-shown:pb-2
    autofill:pt-6
    autofill:pb-2" placeholder="********">
    <label for="hs-floating-gray-input-passowrd" class="absolute top-0 start-0 p-4 h-full sm:text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent  origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
      peer-focus:scale-90
      peer-focus:translate-x-0.5
      peer-focus:-translate-y-1.5
      peer-focus:text-gray-500 dark:peer-focus:text-neutral-500
      peer-not-placeholder-shown:scale-90
      peer-not-placeholder-shown:translate-x-0.5
      peer-not-placeholder-shown:-translate-y-1.5
      peer-not-placeholder-shown:text-gray-500 dark:peer-not-placeholder-shown:text-neutral-500 dark:text-neutral-500">Password</label>
  </div>
  <!-- End Floating Input -->

</div>

When there’s a value already defined, <label>s will automatically adjust to their floated position.

<div class="max-w-sm space-y-3">
  <!-- Floating Input -->
  <div class="relative">
    <input type="email" id="hs-floating-input-email-value" class="peer p-4 block w-full border-gray-200 rounded-lg sm:text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600
    focus:pt-6
    focus:pb-2
    not-placeholder-shown:pt-6
    not-placeholder-shown:pb-2
    autofill:pt-6
    autofill:pb-2" placeholder="you@email.com" value="preline@site.com">
    <label for="hs-floating-input-email-value" class="absolute top-0 start-0 p-4 h-full sm:text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent  origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
      peer-focus:scale-90
      peer-focus:translate-x-0.5
      peer-focus:-translate-y-1.5
      peer-focus:text-gray-500 dark:peer-focus:text-neutral-500
      peer-not-placeholder-shown:scale-90
      peer-not-placeholder-shown:translate-x-0.5
      peer-not-placeholder-shown:-translate-y-1.5
      peer-not-placeholder-shown:text-gray-500 dark:peer-not-placeholder-shown:text-neutral-500 dark:text-neutral-500">Email</label>
  </div>
  <!-- End Floating Input -->

  <!-- Floating Input -->
  <div class="relative">
    <input type="password" id="hs-floating-input-passowrd-value" class="peer p-4 block w-full border-gray-200 rounded-lg sm:text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600
    focus:pt-6
    focus:pb-2
    not-placeholder-shown:pt-6
    not-placeholder-shown:pb-2
    autofill:pt-6
    autofill:pb-2" placeholder="********" value="1234567890">
    <label for="hs-floating-input-passowrd-value" class="absolute top-0 start-0 p-4 h-full sm:text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent  origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
      peer-focus:scale-90
      peer-focus:translate-x-0.5
      peer-focus:-translate-y-1.5
      peer-focus:text-gray-500 dark:peer-focus:text-neutral-500
      peer-not-placeholder-shown:scale-90
      peer-not-placeholder-shown:translate-x-0.5
      peer-not-placeholder-shown:-translate-y-1.5
      peer-not-placeholder-shown:text-gray-500 dark:peer-not-placeholder-shown:text-neutral-500 dark:text-neutral-500">Password</label>
  </div>
  <!-- End Floating Input -->
</div>

Sizes
Inputs stacked small to large sizes.

<div class="max-w-sm space-y-3">
  <input type="text" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Small size">
  <input type="text" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Default size">
  <input type="text" class="p-3.5 sm:p-5 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Large size">
</div>


Readonly
Add the readonly boolean attribute on an input to prevent modification of the input’s value.


<div class="max-w-sm space-y-3">
  <input type="text" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Readonly input" readonly="">
</div>

Disabled
Add the disabled boolean attribute on an input to remove pointer events, and prevent focusing.

<div class="max-w-sm space-y-3">
  <input type="text" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Disabled input" disabled="">
  <input type="text" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Disabled readonly input" disabled="" readonly="">

  <div class="relative">
    <input type="email" class="peer py-2.5 sm:py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter name" disabled="">
    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
      <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
      </svg>
    </div>
  </div>

  <div class="relative">
    <input type="password" class="peer py-2.5 sm:py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter password" disabled="" readonly="">
    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
      <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"></path>
        <circle cx="16.5" cy="7.5" r=".5"></circle>
      </svg>
    </div>
  </div>

</div>


Helper text
Example of an input field with helper text for additional guidance.

<div class="max-w-sm">
  <label for="input-label-with-helper-text" class="block text-sm font-medium mb-2 dark:text-white">Email</label>
  <input type="email" id="input-label-with-helper-text" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="you@site.com" aria-describedby="hs-input-helper-text">
  <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500" id="hs-input-helper-text">We'll never share your details.</p>
</div>

Corner hint
Basic input example with a corner hint label.

<div class="max-w-sm">
  <div class="flex flex-wrap justify-between items-center gap-2">
    <label for="with-corner-hint" class="block text-sm font-medium mb-2 dark:text-white">Email</label>
    <span class="block mb-2 text-sm text-gray-500 dark:text-neutral-500">Optional</span>
  </div>
  <input type="email" id="with-corner-hint" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="you@site.com">
</div>

Validation states
It provides valuable, actionable feedback to your users with HTML5 form validation.

<div class="max-w-sm space-y-4">
  <div>
    <label for="hs-validation-name-error" class="block text-sm font-medium mb-2 dark:text-white">Email</label>
    <div class="relative">
      <input type="text" id="hs-validation-name-error" name="hs-validation-name-error" class="py-2.5 sm:py-3 px-4 block w-full border-red-500 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400" required="" aria-describedby="hs-validation-name-error-helper">
      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
        <svg class="shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" x2="12" y1="8" y2="12"></line>
          <line x1="12" x2="12.01" y1="16" y2="16"></line>
        </svg>
      </div>
    </div>
    <p class="text-sm text-red-600 mt-2" id="hs-validation-name-error-helper">Please enter a valid email address.</p>
  </div>

  <div>
    <label for="hs-validation-name-success" class="block text-sm font-medium mb-2 dark:text-white">Email</label>
    <div class="relative">
      <input type="text" id="hs-validation-name-success" name="hs-validation-name-success" class="py-2.5 sm:py-3 px-4 block w-full border-teal-500 rounded-lg sm:text-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400" required="" aria-describedby="hs-validation-name-success-helper">
      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
        <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
      </div>
    </div>
    <p class="text-sm text-teal-600 mt-2" id="hs-validation-name-success-helper">Looks good!</p>
  </div>
</div>


### 3. Listado de alerts ###

**Reglas aplicadas:**
- ✅ Textos en español
- ✅ Sin clases `dark:`
- ✅ Iconos Lucide (reemplazando SVG)
- ✅ Colores: `teal-500` y `teal-100/200` para success (no `green`)
- ✅ Resto de clases Preline exactas (incluyendo `hs-removing:`, `data-hs-remove-element`, `focus:outline-hidden`, etc.)

Solid color variants
These solid colors are ideal for creating a cohesive and polished appearance in any application.

<div class="mt-2 bg-gray-800 text-sm text-white rounded-lg p-4 dark:bg-white dark:text-neutral-800" role="alert" tabindex="-1" aria-labelledby="hs-solid-color-dark-label">
  <span id="hs-solid-color-dark-label" class="font-bold">Dark</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-gray-500 text-sm text-white rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-solid-color-secondary-label">
  <span id="hs-solid-color-secondary-label" class="font-bold">Secondary</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-blue-600 text-sm text-white rounded-lg p-4 dark:bg-blue-500" role="alert" tabindex="-1" aria-labelledby="hs-solid-color-info-label">
  <span id="hs-solid-color-info-label" class="font-bold">Info</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-teal-500 text-sm text-white rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-solid-color-success-label">
  <span id="hs-solid-color-success-label" class="font-bold">Success</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-red-500 text-sm text-white rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-solid-color-danger-label">
  <span id="hs-solid-color-danger-label" class="font-bold">Danger</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-yellow-500 text-sm text-white rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-solid-color-warning-label">
  <span id="hs-solid-color-warning-label" class="font-bold">Warning</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-white text-sm text-gray-600 rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-solid-color-light-label">
  <span id="hs-solid-color-light-label" class="font-bold">Light</span> alert! You should check in on some of those fields below.
</div>

Soft color variants
These gentle, muted tones create a subtle yet effective way to draw attention without overwhelming the user.Soft color variants
These gentle, muted tones create a subtle yet effective way to draw attention without overwhelming the user.

<div class="mt-2 bg-gray-100 border border-gray-200 text-sm text-gray-800 rounded-lg p-4 dark:bg-white/10 dark:border-white/20 dark:text-white" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-dark-label">
  <span id="hs-soft-color-dark-label" class="font-bold">Dark</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-gray-50 border border-gray-200 text-sm text-gray-600 rounded-lg p-4 dark:bg-white/10 dark:border-white/10 dark:text-neutral-400" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-secondary-label">
  <span id="hs-soft-color-secondary-label" class="font-bold">Secondary</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-blue-100 border border-blue-200 text-sm text-blue-800 rounded-lg p-4 dark:bg-blue-800/10 dark:border-blue-900 dark:text-blue-500" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-info-label">
  <span id="hs-soft-color-info-label" class="font-bold">Info</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-teal-100 border border-teal-200 text-sm text-teal-800 rounded-lg p-4 dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-success-label">
  <span id="hs-soft-color-success-label" class="font-bold">Success</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
  <span id="hs-soft-color-danger-label" class="font-bold">Danger</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-yellow-100 border border-yellow-200 text-sm text-yellow-800 rounded-lg p-4 dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-warning-label">
  <span id="hs-soft-color-warning-label" class="font-bold">Warning</span> alert! You should check in on some of those fields below.
</div>
<div class="mt-2 bg-white/10 border border-white/10 text-sm text-white rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-light-label">
  <span id="hs-soft-color-light-label" class="font-bold">Light</span> alert! You should check in on some of those fields below.
</div>

Bordered styles
Use a discovery message to signify an update to the UI or provide information around new features and onboarding.

<div class="space-y-5">
  <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30" role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
    <div class="flex">
      <div class="shrink-0">
        <!-- Icon -->
        <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
            <path d="m9 12 2 2 4-4"></path>
          </svg>
        </span>
        <!-- End Icon -->
      </div>
      <div class="ms-3">
        <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white">
          Successfully updated.
        </h3>
        <p class="text-sm text-gray-700 dark:text-neutral-400">
          You have successfully updated your email preferences.
        </p>
      </div>
    </div>
  </div>

  <div class="bg-red-50 border-s-4 border-red-500 p-4 dark:bg-red-800/30" role="alert" tabindex="-1" aria-labelledby="hs-bordered-red-style-label">
    <div class="flex">
      <div class="shrink-0">
        <!-- Icon -->
        <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800 dark:border-red-900 dark:bg-red-800 dark:text-red-400">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </span>
        <!-- End Icon -->
      </div>
      <div class="ms-3">
        <h3 id="hs-bordered-red-style-label" class="text-gray-800 font-semibold dark:text-white">
          Error!
        </h3>
        <p class="text-sm text-gray-700 dark:text-neutral-400">
          Your purchase has been declined.
        </p>
      </div>
    </div>
  </div>
</div>

Dismiss button
Requires JS
Note that this component requires the use of our Remove Element plugin, else you can skip this message if you are already using Preline UI as a package.

Use dismiss-alert to dismiss a content.

<div id="dismiss-alert" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-teal-50 border border-teal-200 text-sm text-teal-800 rounded-lg p-4 dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500" role="alert" tabindex="-1" aria-labelledby="hs-dismiss-button-label">
  <div class="flex">
    <div class="shrink-0">
      <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
        <path d="m9 12 2 2 4-4"></path>
      </svg>
    </div>
    <div class="ms-2">
      <h3 id="hs-dismiss-button-label" class="text-sm font-medium">
        File has been successfully uploaded.
      </h3>
    </div>
    <div class="ps-3 ms-auto">
      <div class="-mx-1.5 -my-1.5">
        <button type="button" class="inline-flex bg-teal-50 rounded-lg p-1.5 text-teal-500 hover:bg-teal-100 focus:outline-hidden focus:bg-teal-100 dark:bg-transparent dark:text-teal-600 dark:hover:bg-teal-800/50 dark:focus:bg-teal-800/50" data-hs-remove-element="#dismiss-alert">
          <span class="sr-only">Dismiss</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
</div>

Discovery
Use a discovery message to signify an update to the UI or provide information around new features and onboarding.

<div class="bg-white border border-gray-200 rounded-lg shadow-lg p-4 dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-discovery-label">
  <div class="flex">
    <div class="shrink-0">
      <svg class="shrink-0 size-4 text-blue-600 mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M12 16v-4"></path>
        <path d="M12 8h.01"></path>
      </svg>
    </div>
    <div class="ms-3">
      <h3 id="hs-discovery-label" class="text-gray-800 font-semibold dark:text-white">
        New version published
      </h3>
      <p class="mt-2 text-sm text-gray-700 dark:text-neutral-400">
        Chris Lynch published a new version of this page. Refresh to see the changes.
      </p>
    </div>
  </div>
</div>

Link on right
Use utility classes to quickly provide matching colored links within any alert.

<div class="bg-gray-50 border border-gray-200 text-sm text-gray-600 rounded-lg p-4 dark:bg-white/10 dark:border-white/10 dark:text-neutral-400" role="alert" tabindex="-1" aria-labelledby="hs-link-on-right-label">
  <div class="flex">
    <div class="shrink-0">
      <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M12 16v-4"></path>
        <path d="M12 8h.01"></path>
      </svg>
    </div>
    <div class="flex-1 md:flex md:justify-between ms-2">
      <p id="hs-link-on-right-label" class="text-sm">
        A new software update is available. See what's new in version 3.0.7
      </p>
      <p class="text-sm mt-3 md:mt-0 md:ms-6">
        <a class="text-gray-800 hover:text-gray-500 focus:outline-hidden focus:text-gray-500 font-medium whitespace-nowrap dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400" href="#">Details</a>
      </p>
    </div>
  </div>
</div>

Actions
More actionable alert example.

<div class="bg-blue-100 border border-blue-200 text-gray-800 rounded-lg p-4 dark:bg-blue-800/10 dark:border-blue-900 dark:text-white" role="alert" tabindex="-1" aria-labelledby="hs-actions-label">
  <div class="flex">
    <div class="shrink-0">
      <svg class="shrink-0 size-4 mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M12 16v-4"></path>
        <path d="M12 8h.01"></path>
      </svg>
    </div>
    <div class="ms-3">
      <h3 id="hs-actions-label" class="font-semibold">
        YouTube would like you to send notifications
      </h3>
      <div class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
        Notifications may include alerts, sounds and icon badges. These can be configured in Settings.
      </div>
      <div class="mt-4">
        <div class="flex gap-x-3">
          <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
            Don't allow
          </button>
          <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
            Allow
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

With list
Similarly you can use lists.

<div class="bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert" tabindex="-1" aria-labelledby="hs-with-list-label">
  <div class="flex">
    <div class="shrink-0">
      <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="m15 9-6 6"></path>
        <path d="m9 9 6 6"></path>
      </svg>
    </div>
    <div class="ms-4">
      <h3 id="hs-with-list-label" class="text-sm font-semibold">
        A problem has been occurred while submitting your data.
      </h3>
      <div class="mt-2 text-sm text-red-700 dark:text-red-400">
        <ul class="list-disc space-y-1 ps-5">
          <li>
            This username is already in use
          </li>
          <li>
            Email field can't be empty
          </li>
          <li>
            Please enter a valid phone number
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

With description
Alerts can also contain additional HTML elements like headings, paragraphs and icons.

<div class="bg-yellow-50 border border-yellow-200 text-sm text-yellow-800 rounded-lg p-4 dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500" role="alert" tabindex="-1" aria-labelledby="hs-with-description-label">
  <div class="flex">
    <div class="shrink-0">
      <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
        <path d="M12 9v4"></path>
        <path d="M12 17h.01"></path>
      </svg>
    </div>
    <div class="ms-4">
      <h3 id="hs-with-description-label" class="text-sm font-semibold">
        Cannot connect to the database
      </h3>
      <div class="mt-1 text-sm text-yellow-700">
        We are unable to save any progress at this time.
      </div>
    </div>
  </div>
</div><div class="bg-yellow-50 border border-yellow-200 text-sm text-yellow-800 rounded-lg p-4 dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500" role="alert" tabindex="-1" aria-labelledby="hs-with-description-label">
  <div class="flex">
    <div class="shrink-0">
      <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
        <path d="M12 9v4"></path>
        <path d="M12 17h.01"></path>
      </svg>
    </div>
    <div class="ms-4">
      <h3 id="hs-with-description-label" class="text-sm font-semibold">
        Cannot connect to the database
      </h3>
      <div class="mt-1 text-sm text-yellow-700">
        We are unable to save any progress at this time.
      </div>
    </div>
  </div>
</div>




### 3. Listado de bagde, label, chip ###

Solid color variants
The default form of solid color badges.

<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-800 text-white dark:bg-white dark:text-neutral-800">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-500 text-white">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-500 text-white">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-600 text-white dark:bg-blue-500">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-yellow-500 text-white">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-white text-gray-600">Badge</span>

Soft color variants
Predefined soft color badge styles.

<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-50 text-gray-500 dark:bg-white/10 dark:text-white">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500">Badge</span>
<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-white/10 text-white">Badge</span>

Max width
Simple example with truncate.

Avoid truncation wherever possible by using shorter text in badges. The truncated text is not focusable or accessible

<span class="max-w-40 truncate whitespace-nowrap inline-block py-1.5 px-3 rounded-lg text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">This content is a little bit longer.</span>

Badge with indicator
Use an indicator appearance to show indication.

<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
  <span class="size-1.5 inline-block rounded-full bg-blue-800 dark:bg-blue-500"></span>
  Badge
</span>

Working with icons
Use icon to show indication.

<div class="flex flex-col gap-y-2">
  <div class="inline-flex flex-wrap gap-2">
    <div>
      <span class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
          <path d="m9 12 2 2 4-4"></path>
        </svg>
        Connected
      </span>
    </div>

    <div>
      <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
          <path d="M12 9v4"></path>
          <path d="M12 17h.01"></path>
        </svg>
        Attention
      </span>
    </div>

    <div>
      <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full dark:bg-blue-500/10 dark:text-blue-500">
        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" x2="12" y1="2" y2="6"></line>
          <line x1="12" x2="12" y1="18" y2="22"></line>
          <line x1="4.93" x2="7.76" y1="4.93" y2="7.76"></line>
          <line x1="16.24" x2="19.07" y1="16.24" y2="19.07"></line>
          <line x1="2" x2="6" y1="12" y2="12"></line>
          <line x1="18" x2="22" y1="12" y2="12"></line>
          <line x1="4.93" x2="7.76" y1="19.07" y2="16.24"></line>
          <line x1="16.24" x2="19.07" y1="7.76" y2="4.93"></line>
        </svg>
        Loading
      </span>
    </div>

    <div>
      <span class="py-1 px-2 inline-flex items-center gap-x-1 text-xs bg-gray-100 text-gray-800 rounded-full dark:bg-neutral-500/20 dark:text-neutral-400">
        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
          <line x1="12" x2="12" y1="2" y2="12"></line>
        </svg>
        Disabled
      </span>
    </div>
  </div>

  <div class="inline-flex flex-wrap gap-2">
    <div>
      <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
          <polyline points="16 7 22 7 22 13"></polyline>
        </svg>
        14.5%
      </span>
    </div>

    <div>
      <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
          <polyline points="16 17 22 17 22 11"></polyline>
        </svg>
        2%
      </span>
    </div>

    <div>
      <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs bg-gray-100 text-gray-800 rounded-md dark:bg-neutral-500/20 dark:text-neutral-400">
        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
          <polyline points="16 7 22 7 22 13"></polyline>
        </svg>
        37.3%
      </span>
    </div>

    <div>
      <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs bg-gray-100 text-gray-800 rounded-md dark:bg-neutral-500/20 dark:text-neutral-400">
        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
          <polyline points="16 17 22 17 22 11"></polyline>
        </svg>
        56%
      </span>
    </div>
  </div>
</div>

Badge with remove button
Use badge with remove button.

<span class="inline-flex items-center gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
  Badge
  <button type="button" class="shrink-0 size-4 inline-flex items-center justify-center rounded-full hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 focus:text-blue-500 dark:hover:bg-blue-900">
    <span class="sr-only">Remove badge</span>
    <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M18 6 6 18"></path>
      <path d="m6 6 12 12"></path>
    </svg>
  </button>
</span>

Badge with avatar
Use badge with avatar and remove button in combination.

<div class="inline-flex flex-wrap gap-2">
  <div class="inline-flex flex-nowrap items-center bg-white border border-gray-200 rounded-full p-1.5 pe-3 dark:bg-neutral-900 dark:border-neutral-700">
    <img class="me-1.5 inline-block size-6 rounded-full" src="https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Avatar">
    <div class="whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">
      Christina
    </div>
  </div>

  <div class="inline-flex flex-nowrap items-center bg-white border border-gray-200 rounded-full p-1.5 dark:bg-neutral-900 dark:border-neutral-700">
    <img class="me-1.5 inline-block size-6 rounded-full" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Avatar">
    <div class="whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">
      Mark
    </div>
    <div class="ms-2.5 inline-flex justify-center items-center size-5 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-hidden focus:ring-2 focus:ring-gray-400 dark:bg-neutral-700/50 dark:hover:bg-neutral-700 dark:text-neutral-400 cursor-pointer">
      <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 6 6 18"></path>
        <path d="m6 6 12 12"></path>
      </svg>
    </div>
  </div>
</div>

With button
Badges can be used as part of links or buttons to provide a counter.

<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
  Notifications
  <span class="inline-flex items-center py-0.5 px-1.5 rounded-full text-xs font-medium bg-red-500 text-white">5</span>
</button>

Positioned
Position a badge in the corner of a link, button, avatar or any other component.

<button type="button" class="relative inline-flex justify-center items-center size-11 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
  <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
  </svg>
  <span class="absolute top-0 end-0 inline-flex items-center py-0.5 px-1.5 rounded-full text-xs font-medium transform -translate-y-1/2 translate-x-1/2 bg-red-500 text-white">99+</span>
</button>

Profile
Display a badge without a specific count.

<button type="button" class="relative inline-flex justify-center items-center size-11 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
  <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
  </svg>
  <span class="absolute top-0 end-0 inline-flex items-center size-3.5 rounded-full border-2 border-white text-xs font-medium transform -translate-y-1/2 translate-x-1/2 bg-teal-500 text-white dark:border-neutral-900">
    <span class="sr-only">Badge value</span>
  </span>
</button>

Animation
Ping
Add the animate-ping utility to make an element scale and fade like a radar ping or ripple of water — useful for things like notification badges.

<button type="button" class="m-1 ms-0 relative inline-flex justify-center items-center size-11 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="m5 11 4-7"></path>
    <path d="m19 11-4-7"></path>
    <path d="M2 11h20"></path>
    <path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8c.9 0 1.8-.7 2-1.6l1.7-7.4"></path>
    <path d="m9 11 1 9"></path>
    <path d="M4.5 15.5h15"></path>
    <path d="m15 11-1 9"></path>
  </svg>
  <span class="flex absolute top-0 end-0 size-3 -mt-1.5 -me-1.5">
    <span class="animate-ping absolute inline-flex size-full rounded-full bg-red-400 opacity-75 dark:bg-red-600"></span>
    <span class="relative inline-flex rounded-full size-3 bg-red-500"></span>
  </span>
</button>
<button type="button" class="m-1 ms-0 relative py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
  Notification
  <span class="flex absolute top-0 end-0 -mt-2 -me-2">
    <span class="animate-ping absolute inline-flex size-full rounded-full bg-red-400 opacity-75 dark:bg-red-600"></span>
    <span class="relative inline-flex text-xs bg-red-500 text-white rounded-full py-0.5 px-1.5">
      9+
    </span>
  </span>
</button>

### 4. Listado de botones ###

Types
Explore the most commonly used button styles such as solid, outline, ghost, soft, link, and more.

<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  Solid
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border-2 border-gray-200 text-gray-500 hover:border-blue-600 hover:text-blue-600 focus:outline-hidden focus:border-blue-600 focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-blue-500 dark:hover:border-blue-600 dark:focus:text-blue-500 dark:focus:border-blue-600">
  Outline
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:bg-blue-100 hover:text-blue-800 focus:outline-hidden focus:bg-blue-100 focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:bg-blue-800/30 dark:hover:text-blue-400 dark:focus:bg-blue-800/30 dark:focus:text-blue-400">
  Ghost
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:hover:bg-blue-900 dark:focus:bg-blue-900">
  Soft
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border-2 border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
  White
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
  Link
</button>

Sizes
Buttons stacked small to large sizes.

<button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  Small
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  Default
</button>
<button type="button" class="p-4 sm:p-5 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  Large
</button>

Solid color variants
Predefined solid color button styles.

<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-800 text-white hover:bg-gray-900 focus:outline-hidden focus:bg-gray-900 disabled:opacity-50 disabled:pointer-events-none dark:bg-white dark:text-neutral-800">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-500 text-white hover:bg-gray-600 focus:outline-hidden focus:bg-gray-600 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 focus:outline-hidden focus:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 focus:outline-hidden focus:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-yellow-500 text-white hover:bg-yellow-600 focus:outline-hidden focus:bg-yellow-600 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-white text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>

Outline color variants
Predefined outline color button styles.

<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border-2 border-gray-800 text-gray-800 hover:border-gray-500 hover:text-gray-500 focus:outline-hidden focus:border-gray-500 focus:text-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:border-white dark:text-white dark:hover:text-neutral-300 dark:hover:border-neutral-300">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border-2 border-gray-500 text-gray-500 hover:border-gray-800 hover:text-gray-800 focus:outline-hidden focus:border-gray-800 focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-400 dark:text-neutral-400 dark:hover:text-neutral-300 dark:hover:border-neutral-300">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border-2 border-teal-500 text-teal-500 hover:border-teal-400 hover:text-teal-400 focus:outline-hidden focus:border-teal-400 focus:text-teal-400 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border-2 border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:outline-hidden focus:border-blue-500 focus:text-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border-2 border-red-500 text-red-500 hover:border-red-400 hover:text-red-400 focus:outline-hidden focus:border-red-400 focus:text-red-400 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border-2 border-yellow-500 text-yellow-500 hover:border-yellow-400 focus:outline-hidden focus:border-yellow-400 focus:text-yellow-400 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border-2 border-white text-white hover:border-white/70 hover:text-white/70 focus:outline-hidden focus:border-white/70 focus:text-white/70 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>

Ghost color variants
Predefined ghost color button styles.

<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-teal-500 hover:bg-teal-100 focus:outline-hidden focus:bg-teal-100 hover:text-teal-800 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-teal-800/30 dark:hover:text-teal-400 dark:focus:text-teal-400">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:bg-blue-100 focus:outline-hidden focus:bg-blue-100 hover:text-blue-800 focus:outline-hidden focus:bg-blue-100 focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:bg-blue-800/30 dark:hover:text-blue-400 dark:focus:bg-blue-800/30 dark:focus:text-blue-400">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-red-500 hover:bg-red-100 focus:outline-hidden focus:bg-red-100 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-red-800/30 dark:hover:text-red-400 dark:focus:bg-red-800/30 dark:focus:text-red-400">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-yellow-500 hover:bg-yellow-100 focus:outline-hidden focus:bg-yellow-100 hover:text-yellow-800 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-yellow-800/30 dark:hover:text-yellow-400 dark:focus:bg-yellow-800/30 dark:focus:text-yellow-400">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-white hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 hover:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-white/10 dark:hover:text-white dark:focus:bg-white/10 dark:focus:text-white">
  Button
</button>

Soft color variants
Predefined soft color button styles.

<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-white/10 dark:text-white dark:hover:bg-white/20 dark:hover:text-white dark:focus:bg-white/20 dark:focus:text-white">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-100 text-gray-500 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-white/10 dark:text-neutral-400 dark:hover:bg-white/20 dark:hover:text-neutral-300 dark:focus:bg-white/20 dark:focus:text-neutral-300">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-100 text-teal-800 hover:bg-teal-200 focus:outline-hidden focus:bg-teal-200 disabled:opacity-50 disabled:pointer-events-none dark:text-teal-500 dark:bg-teal-800/30 dark:hover:bg-teal-800/20 dark:focus:bg-teal-800/20">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-hidden focus:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:bg-red-800/30 dark:hover:bg-red-800/20 dark:focus:bg-red-800/20">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-yellow-100 text-yellow-800 hover:bg-yellow-200 focus:outline-hidden focus:bg-yellow-200 disabled:opacity-50 disabled:pointer-events-none dark:text-yellow-500 dark:bg-yellow-800/30 dark:hover:bg-yellow-800/20 dark:focus:bg-yellow-800/20">
  Button
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-white/10 text-white hover:bg-white/20 focus:outline-hidden focus:bg-white/20 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>

White color variants
Predefined white color button styles.

<button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-gray-800 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:text-white/70 dark:focus:text-white/70">
  Link
</button>
<button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white">
  Link
</button>
<button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
  Link
</button>
<button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-white hover:text-white/80 focus:outline-hidden focus:text-white/80 disabled:opacity-50 disabled:pointer-events-none">
  Link
</button>

Link color variants
Predefined link color button styles.

<button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-gray-800 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:text-white/70 dark:focus:text-white/70">
  Link
</button>
<button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white">
  Link
</button>
<button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
  Link
</button>
<button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-white hover:text-white/80 focus:outline-hidden focus:text-white/80 disabled:opacity-50 disabled:pointer-events-none">
  Link
</button>

Block Button
.w-full or .grid classes will make the button fit to its parent width.

<button type="button" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  Button
</button>
<button type="button" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
  Button
</button>

Icon
A contained button with an icon.

<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  Add to cart
  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="m5 11 4-7"></path>
    <path d="m19 11-4-7"></path>
    <path d="M2 11h20"></path>
    <path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8c.9 0 1.8-.7 2-1.6l1.7-7.4"></path>
    <path d="m9 11 1 9"></path>
    <path d="M4.5 15.5h15"></path>
    <path d="m15 11-1 9"></path>
  </svg>
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
  Signup free
  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M5 12h14"></path>
    <path d="m12 5 7 7-7 7"></path>
  </svg>
</button>

With fixed width and height.With fixed width and height.

<button type="button" class="py-3 px-4 flex justify-center items-center size-11 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="m5 11 4-7"></path>
    <path d="m19 11-4-7"></path>
    <path d="M2 11h20"></path>
    <path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8c.9 0 1.8-.7 2-1.6l1.7-7.4"></path>
    <path d="m9 11 1 9"></path>
    <path d="M4.5 15.5h15"></path>
    <path d="m15 11-1 9"></path>
  </svg>
</button>
<button type="button" class="flex justify-center items-center size-11 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
  <span class="animate-spin inline-block size-4 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status" aria-label="loading">
    <span class="sr-only">Loading...</span>
  </span>
</button>

Also available in all button sizes.

<button type="button" class="flex shrink-0 justify-center items-center gap-2 size-9.5 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
    <polyline points="9 22 9 12 15 12 15 22"></polyline>
  </svg>
</button>
<button type="button" class="flex shrink-0 justify-center items-center gap-2 size-11 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
    <polyline points="9 22 9 12 15 12 15 22"></polyline>
  </svg>
</button>
<button type="button" class="flex shrink-0 justify-center items-center gap-2 size-15.5 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
    <polyline points="9 22 9 12 15 12 15 22"></polyline>
  </svg>
</button>

Loading
Use spinners within buttons to indicate an action is currently processing or taking place. You may also swap the text out of the spinner element and utilize button text as needed.

<button type="button" class="flex justify-center items-center size-11 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  <span class="animate-spin inline-block size-4 border-3 border-current border-t-transparent text-white rounded-full" role="status" aria-label="loading">
    <span class="sr-only">Loading...</span>
  </span>
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  <span class="animate-spin inline-block size-4 border-3 border-current border-t-transparent text-white rounded-full" role="status" aria-label="loading"></span>
  Loading
</button>

Disabled
Make buttons look inactive by adding the disabled boolean attribute to any <button> element.

<a>s don't support the disabled attribute.

<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" disabled="">
  Solid
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-500 hover:border-blue-600 hover:text-blue-600 focus:outline-hidden focus:border-blue-600 focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-blue-500 dark:hover:border-blue-600 dark:focus:text-blue-500 dark:focus:border-blue-600" disabled="">
  Outline
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:bg-blue-100 hover:text-blue-800 focus:outline-hidden focus:bg-blue-100 focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:bg-blue-800/30 dark:hover:text-blue-400 dark:focus:bg-blue-800/30 dark:focus:text-blue-400" disabled="">
  Ghost
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:hover:bg-blue-900 dark:focus:bg-blue-900" disabled="">
  Soft
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" disabled="">
  White
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400" disabled="">
  Link
</button>

Active
Style button on active using the active modifier:

<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 active:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  Solid
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-500 hover:border-blue-600 hover:text-blue-600 focus:outline-hidden focus:border-blue-600 active:border-blue-600 focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-blue-500 dark:hover:border-blue-600 dark:focus:text-blue-500 dark:focus:border-blue-600 dark:active:text-blue-500 dark:active:border-blue-600">
  Outline
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:bg-blue-100 hover:text-blue-800 focus:outline-hidden focus:bg-blue-100 focus:text-blue-800 active:bg-blue-100 active:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:bg-blue-800/30 dark:hover:text-blue-400 dark:focus:bg-blue-800/30 dark:focus:text-blue-400 dark:active:bg-blue-800/30 dark:active:text-blue-400">
  Ghost
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 active:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:hover:bg-blue-900 dark:focus:bg-blue-900 dark:active:bg-blue-900">
  Soft
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 active:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:active:bg-neutral-700">
  White
</button>
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 active:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400 dark:active:text-blue-400">
  Link
</button>

Button examples
Circlular like and dislike button styles.

<div class="inline-flex border border-gray-200 rounded-full p-0.5 dark:border-neutral-700">
  <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-full text-gray-500 hover:bg-blue-100 hover:text-blue-800 focus:outline-hidden focus:bg-blue-100 focus:text-blue-800 dark:text-neutral-500 dark:hover:bg-blue-900 dark:hover:text-blue-200 dark:focus:bg-blue-900 dark:focus:text-blue-200">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M7 10v12"></path>
      <path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2h0a3.13 3.13 0 0 1 3 3.88Z"></path>
    </svg>
  </button>
  <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-full text-gray-500 hover:bg-blue-100 hover:text-blue-800 focus:outline-hidden focus:bg-blue-100 focus:text-blue-800 dark:text-neutral-500 dark:hover:bg-blue-900 dark:hover:text-blue-200 dark:focus:bg-blue-900 dark:focus:text-blue-200">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M17 14V2"></path>
      <path d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22h0a3.13 3.13 0 0 1-3-3.88Z"></path>
    </svg>
  </button>
</div>

### 5. Listado de cards ###

Scrollable body
Simple example of a center aligned body content.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="h-80 overflow-y-auto p-4 md:p-5 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.
    </p>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.
    </p>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.
    </p>
  </div>
</div>

Empty state
Display empty state placeholder when there is no data provided, display for friendly tips.

<div class="min-h-60 flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="flex flex-auto flex-col justify-center items-center p-4 md:p-5">
    <svg class="size-10 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
      <line x1="22" x2="2" y1="12" y2="12"></line>
      <path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
      <line x1="6" x2="6.01" y1="16" y2="16"></line>
      <line x1="10" x2="10.01" y1="16" y2="16"></line>
    </svg>
    <p class="mt-2 text-sm text-gray-800 dark:text-neutral-300">
      No data to show
    </p>
  </div>
</div>

Centered body content
Simple example of a center aligned body content.

<div class="min-h-60 flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="flex flex-auto flex-col justify-center items-center p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      With supporting text below as a natural lead-in to additional content.
    </p>
    <a class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 decoration-2 hover:text-blue-700 hover:underline focus:underline focus:outline-hidden focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600" href="#">
      Card link
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
      </svg>
    </a>
  </div>
</div>

With alert
Use an alert box that perfectly sits within a card.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="border-b border-gray-200 rounded-t-xl py-3 px-4 md:py-4 md:px-5 dark:border-neutral-700">
    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-500">
      Featured
    </p>
  </div>
  <div class="bg-gray-100 border-b border-gray-200 text-sm text-gray-800 p-4 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
    <span class="font-bold">Attention needed!</span> This is an alert box.
  </div>
  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      With supporting text below as a natural lead-in to additional content.
    </p>
    <a class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 decoration-2 hover:text-blue-700 hover:underline focus:underline focus:outline-hidden focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600" href="#">
      Card link
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
      </svg>
    </a>
  </div>
</div>

Panel actions
Top bordered card example.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="flex justify-between items-center border-b border-gray-200 rounded-t-xl py-3 px-4 md:px-5 dark:border-neutral-700">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card action
    </h3>

    <div class="flex items-center gap-x-1">
      <div class="hs-tooltip inline-block">
        <button type="button" class="hs-tooltip-toggle size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"></path>
            <path d="M21 3v5h-5"></path>
          </svg>
          <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700" role="tooltip">
            Refresh
          </span>
        </button>
      </div>
      <div class="hs-tooltip inline-block">
        <button type="button" class="hs-tooltip-toggle size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m21 21-6-6m6 6v-4.8m0 4.8h-4.8"></path>
            <path d="M3 16.2V21m0 0h4.8M3 21l6-6"></path>
            <path d="M21 7.8V3m0 0h-4.8M21 3l-6 6"></path>
            <path d="M3 7.8V3m0 0h4.8M3 3l6 6"></path>
          </svg>
          <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700" role="tooltip">
            Fullscreen
          </span>
        </button>
      </div>
      <div class="hs-tooltip inline-block">
        <button type="button" class="hs-tooltip-toggle size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
          <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700" role="tooltip">
            Close
          </span>
        </button>
      </div>
    </div>
  </div>
  <div class="p-4 md:p-5">
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      With supporting text below as a natural lead-in to additional content.
    </p>
    <a class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 decoration-2 hover:text-blue-700 hover:underline focus:underline focus:outline-hidden focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600" href="#">
      Card link
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
      </svg>
    </a>
  </div>
</div>

Horizontal
Using a combination of grid and utility classes, cards can be made horizontal in a mobile-friendly and responsive way.

<div class="bg-white border border-gray-200 rounded-xl shadow-2xs sm:flex dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="shrink-0 relative w-full rounded-t-xl overflow-hidden pt-[40%] sm:rounded-s-xl sm:max-w-60 md:rounded-se-none md:max-w-xs">
    <img class="size-full absolute top-0 start-0 object-cover" src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80" alt="Card Image">
  </div>
  <div class="flex flex-wrap">
    <div class="p-4 flex flex-col h-full sm:p-7">
      <h3 class="text-lg font-bold text-gray-800 dark:text-white">
        Card title
      </h3>
      <p class="mt-1 text-gray-500 dark:text-neutral-400">
        Some quick example text to build on the card title and make up the bulk of the card's content.
      </p>
      <div class="mt-5 sm:mt-auto">
        <p class="text-xs text-gray-500 dark:text-neutral-500">
          Last updated 5 mins ago
        </p>
      </div>
    </div>
  </div>
</div>

Transition on hover
Animate the card with a shadow on hover.

<a class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl hover:shadow-lg focus:outline-hidden focus:shadow-lg transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70" href="#">
  <img class="w-full h-auto rounded-t-xl" src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80" alt="Card Image">
  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-1 text-gray-500 dark:text-neutral-400">
      Some quick example text to build on the card title and make up the bulk of the card's content.
    </p>
  </div>
</a>

Image scaling animation on hover
Animate the card image with zoom out on hover.

<a class="flex flex-col group bg-white border border-gray-200 shadow-2xs rounded-xl overflow-hidden hover:shadow-lg focus:outline-hidden focus:shadow-lg transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70" href="#">
  <div class="relative pt-[50%] sm:pt-[60%] lg:pt-[80%] rounded-t-xl overflow-hidden">
    <img class="size-full absolute top-0 start-0 object-cover group-hover:scale-105 group-focus:scale-105 transition-transform duration-500 ease-in-out rounded-t-xl" src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80" alt="Card Image">
  </div>
  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-1 text-gray-500 dark:text-neutral-400">
      Some quick example text to build on the card title and make up the bulk of the card's content.
    </p>
  </div>
</a>

Images
Cards include a few options for working with images. Choose from appending “image caps” at either end of a card, overlaying images with card content, or simply embedding the image in a card.

Image placeholders
Similar to headers and footers, cards can include top and bottom "image placeholder"—images at the top.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <img class="w-full h-auto rounded-t-xl" src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80" alt="Card Image">
  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-1 text-gray-500 dark:text-neutral-400">
      Some quick example text to build on the card title and make up the bulk of the card's content.
    </p>
    <p class="mt-5 text-xs text-gray-500 dark:text-neutral-500">
      Last updated 5 mins ago
    </p>
  </div>
</div>

Or bottom of the card.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-1 text-gray-500 dark:text-neutral-400">
      Some quick example text to build on the card title and make up the bulk of the card's content.
    </p>
    <p class="mt-5 text-xs text-gray-500 dark:text-neutral-500">
      Last updated 5 mins ago
    </p>
  </div>
  <img class="w-full h-auto rounded-b-xl" src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80" alt="Card Image">
</div>

Navigation
Add some navigation to a card's header (or block).

<div class="border border-gray-200 rounded-xl shadow-2xs p-4 dark:bg-neutral-800 dark:border-neutral-700">
  <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
    <div class="bg-gray-100 border-b border-gray-200 rounded-t-xl pt-3 px-4 md:pt-4 md:px-5 dark:bg-neutral-800 dark:border-neutral-700">
      <nav class="flex gap-x-2">
        <a class="-mb-px py-3 px-4 bg-white text-sm font-medium text-center border border-gray-200 border-b-transparent text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 focus:z-10 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-500 dark:border-b-gray-800 dark:hover:text-neutral-400 dark:focus:text-neutral-400" href="#">
          Active
        </a>

        <a class="-mb-px py-3 px-4 text-sm font-medium text-center border-b border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 focus:z-10 dark:border-neutral-700 dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400" href="#">
          Link
        </a>

        <a class="-mb-px py-3 px-4 text-sm font-medium text-center border-b border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 focus:z-10 dark:border-neutral-700 dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400" href="#">
          Link
        </a>
      </nav>
    </div>
    <div class="p-4 text-center md:py-7 md:px-5">
      <h3 class="text-lg font-bold text-gray-800 dark:text-white">
        Card title
      </h3>
      <p class="mt-2 text-gray-500 dark:text-neutral-400">
        With supporting text below as a natural lead-in to additional content.
      </p>
      <a class="mt-3 py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="#">
        Go somewhere
      </a>
    </div>
  </div>
</div>

Sizes
Small card size.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      With supporting text below as a natural lead-in to additional content.
    </p>
    <a class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 decoration-2 hover:text-blue-700 hover:underline focus:underline focus:outline-hidden focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600" href="#">
      Card link
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
      </svg>
    </a>
  </div>
</div>

Default card size.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="p-4 md:p-7">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      With supporting text below as a natural lead-in to additional content.
    </p>
    <a class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 decoration-2 hover:text-blue-700 hover:underline focus:underline focus:outline-hidden focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600" href="#">
      Card link
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
      </svg>
    </a>
  </div>
</div>

Large card size.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="p-4 md:p-10">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      With supporting text below as a natural lead-in to additional content.
    </p>
    <a class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 decoration-2 hover:text-blue-700 hover:underline focus:underline focus:outline-hidden focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600" href="#">
      Card link
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
      </svg>
    </a>
  </div>
</div>

Header and footer
Add an optional header and/or footer within a card.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="bg-gray-100 border-b border-gray-200 rounded-t-xl py-3 px-4 md:py-4 md:px-5 dark:bg-neutral-900 dark:border-neutral-700">
    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-500">
      Featured
    </p>
  </div>
  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      With supporting text below as a natural lead-in to additional content.
    </p>
    <a class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 decoration-2 hover:text-blue-700 hover:underline focus:underline focus:outline-hidden focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600" href="#">
      Card link
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
      </svg>
    </a>
  </div>
</div>

Simple footer within a card.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
      With supporting text below as a natural lead-in to additional content.
    </p>
    <a class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 decoration-2 hover:text-blue-700 hover:underline focus:underline focus:outline-hidden focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600" href="#">
      Card link
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
      </svg>
    </a>
  </div>
  <div class="bg-gray-100 border-t border-gray-200 rounded-b-xl py-3 px-4 md:py-4 md:px-5 dark:bg-neutral-900 dark:border-neutral-700">
    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-500">
      Last updated 5 mins ago
    </p>
  </div>
</div>

Simple card
A simple card only containing a content area.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <h3 class="text-lg font-bold text-gray-800 dark:text-white">
    Card title
  </h3>
  <p class="mt-1 text-xs font-medium uppercase text-gray-500 dark:text-neutral-500">
    Card subtitle
  </p>
  <p class="mt-2 text-gray-500 dark:text-neutral-400">
    Some quick example text to build on the card title and make up the bulk of the card's content.
  </p>
  <a class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 decoration-2 hover:text-blue-700 hover:underline focus:underline focus:outline-hidden focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600" href="#">
    Card link
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </a>
</div>

Body
Simple body example with text.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
  This is some text within a card body.
</div>

Example
A basic card containing a title, content and an extra corner content.

Cards assume no specific width to start, so they'll be 100% wide unless otherwise stated.

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <img class="w-full h-auto rounded-t-xl" src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80" alt="Card Image">
  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
      Card title
    </h3>
    <p class="mt-1 text-gray-500 dark:text-neutral-400">
      Some quick example text to build on the card title and make up the bulk of the card's content.
    </p>
    <a class="mt-2 py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="#">
      Go somewhere
    </a>
  </div>
</div>

### 6. Listado de datepicker ###

Single datepicker
The calendar allows the user to select a date by clicking on the desired day and month.

<div class="w-80 flex flex-col bg-white border border-gray-200 shadow-lg rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
    <!-- Calendar -->
    <div class="p-3 space-y-0.5">
      <!-- Months -->
      <div class="grid grid-cols-5 items-center gap-x-3 mx-1.5 pb-3">
        <!-- Prev Button -->
        <div class="col-span-1">
          <button type="button" class="size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-label="Previous">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
          </button>
        </div>
        <!-- End Prev Button -->

        <!-- Month / Year -->
        <div class="col-span-3 flex justify-center items-center gap-x-1">
          <div class="relative">
            <select data-hs-select='{
                "placeholder": "Select month",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative flex text-nowrap w-full cursor-pointer text-start font-medium text-gray-800 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 before:absolute before:inset-0 before:z-1 dark:text-neutral-200 dark:hover:text-blue-500 dark:focus:text-blue-500",
                "dropdownClasses": "mt-2 z-50 w-32 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                "optionClasses": "p-2 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-gray-800 dark:text-neutral-200\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
              }' class="hidden">
              <option value="0">January</option>
              <option value="1">February</option>
              <option value="2">March</option>
              <option value="3">April</option>
              <option value="4">May</option>
              <option value="5">June</option>
              <option value="6" selected>July</option>
              <option value="7">August</option>
              <option value="8">September</option>
              <option value="9">October</option>
              <option value="10">November</option>
              <option value="11">December</option>
            </select>
          </div>

          <span class="text-gray-800 dark:text-neutral-200">/</span>

          <div class="relative">
            <select data-hs-select='{
                "placeholder": "Select year",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative flex text-nowrap w-full cursor-pointer text-start font-medium text-gray-800 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 before:absolute before:inset-0 before:z-1 dark:text-neutral-200 dark:hover:text-blue-500 dark:focus:text-blue-500",
                "dropdownClasses": "mt-2 z-50 w-20 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                "optionClasses": "p-2 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-gray-800 dark:text-neutral-200\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
              }' class="hidden">
              <option selected>2023</option>
              <option>2024</option>
              <option>2025</option>
              <option>2026</option>
              <option>2027</option>
            </select>
          </div>
        </div>
        <!-- End Month / Year -->

        <!-- Next Button -->
        <div class="col-span-1 flex justify-end">
          <button type="button" class=" size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-label="Next">
            <svg class="shrink-0 size-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
          </button>
        </div>
        <!-- End Next Button -->
      </div>
      <!-- Months -->

      <!-- Weeks -->
      <div class="flex pb-1.5">
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Mo
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Tu
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          We
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Th
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Fr
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Sa
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Su
        </span>
      </div>
      <!-- Weeks -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            26
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            27
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            28
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            29
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            30
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            1
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            2
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            3
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            4
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            5
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            6
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            7
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            8
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            9
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            10
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            11
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            12
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            13
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            14
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            15
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            16
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            17
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            18
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            19
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center bg-blue-600 border-[1.5px] border-transparent text-sm font-medium text-white hover:border-blue-600 rounded-full dark:bg-blue-500 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:hover:border-neutral-700">
            20
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            21
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            22
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            23
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            24
          </button>
        </div>
        <div >
            <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            25
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            26
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            27
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            28
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            29
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            30
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            31
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            1
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            2
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            3
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            4
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            5
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            6
          </button>
        </div>
      </div>
      <!-- Days -->
    </div>
</div>

Single pre-set ranges
This example allows to select a range of dates.

<div class="w-80 flex flex-col bg-white border border-gray-200 shadow-lg rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
    <!-- Calendar -->
    <div class="p-3 space-y-0.5">
      <!-- Months -->
      <div class="grid grid-cols-5 items-center gap-x-3 mx-1.5 pb-3">
        <!-- Prev Button -->
        <div class="col-span-1">
          <button type="button" class="size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-label="Previous">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
          </button>
        </div>
        <!-- End Prev Button -->

        <!-- Month / Year -->
        <div class="col-span-3 flex justify-center items-center gap-x-1">
          <div class="relative">
            <select data-hs-select='{
                "placeholder": "Select month",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative flex text-nowrap w-full cursor-pointer text-start font-medium text-gray-800 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 before:absolute before:inset-0 before:z-1 dark:text-neutral-200 dark:hover:text-blue-500 dark:focus:text-blue-500",
                "dropdownClasses": "mt-2 z-50 w-32 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                "optionClasses": "p-2 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-gray-800 dark:text-neutral-200\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
              }' class="hidden">
              <option value="0">January</option>
              <option value="1">February</option>
              <option value="2">March</option>
              <option value="3">April</option>
              <option value="4">May</option>
              <option value="5">June</option>
              <option value="6" selected>July</option>
              <option value="7">August</option>
              <option value="8">September</option>
              <option value="9">October</option>
              <option value="10">November</option>
              <option value="11">December</option>
            </select>
          </div>

          <span class="text-gray-800 dark:text-neutral-200">/</span>

          <div class="relative">
            <select data-hs-select='{
                "placeholder": "Select year",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative flex text-nowrap w-full cursor-pointer text-start font-medium text-gray-800 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 before:absolute before:inset-0 before:z-1 dark:text-neutral-200 dark:hover:text-blue-500 dark:focus:text-blue-500",
                "dropdownClasses": "mt-2 z-50 w-20 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                "optionClasses": "p-2 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-gray-800 dark:text-neutral-200\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
              }' class="hidden">
              <option selected>2023</option>
              <option>2024</option>
              <option>2025</option>
              <option>2026</option>
              <option>2027</option>
            </select>
          </div>
        </div>
        <!-- End Month / Year -->

        <!-- Next Button -->
        <div class="col-span-1 flex justify-end">
          <button type="button" class=" size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-label="Next">
            <svg class="shrink-0 size-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
          </button>
        </div>
        <!-- End Next Button -->
      </div>
      <!-- Months -->

      <!-- Weeks -->
      <div class="flex pb-1.5">
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Mo
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Tu
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          We
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Th
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Fr
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Sa
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Su
        </span>
      </div>
      <!-- Weeks -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            26
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            27
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            28
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            29
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            30
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            1
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            2
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            3
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            4
          </button>
        </div>
        <div class="bg-gray-100 rounded-s-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center bg-blue-600 border-[1.5px] border-transparent text-sm font-medium text-white hover:border-blue-600 focus:outline-hidden focus:border-blue-600 rounded-full disabled:text-gray-300 disabled:pointer-events-none dark:bg-blue-500 dark:hover:border-neutral-700 dark:focus:border-neutral-700">
            5
          </button>
        </div>
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            6
          </button>
        </div>
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            7
          </button>
        </div>
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            8
          </button>
        </div>
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            9
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            10
          </button>
        </div>
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            11
          </button>
        </div>
        <div class="bg-gray-100 rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center bg-blue-600 border-[1.5px] border-transparent text-sm font-medium text-white hover:border-blue-600 focus:outline-hidden focus:border-blue-600 rounded-full disabled:text-gray-300 disabled:pointer-events-none dark:bg-blue-500 dark:hover:border-neutral-700 dark:focus:border-neutral-700">
            12
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            13
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            14
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            15
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            16
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            17
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            18
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            19
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            20
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            21
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            22
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            23
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            24
          </button>
        </div>
        <div >
            <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            25
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            26
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            27
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            28
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            29
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            30
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            31
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            1
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            2
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            3
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            4
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            5
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            6
          </button>
        </div>
      </div>
      <!-- Days -->
    </div>

    <!-- Button Group -->
    <div class="py-3 px-4 flex items-center justify-end gap-x-2 border-t border-gray-200 dark:border-neutral-700">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        Cancel
      </button>
      <button type="button" class="py-2 px-3  inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border-[1.5px] border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:ring-2 focus:ring-blue-500">
        Apply
      </button>
    </div>
    <!-- End Button Group -->
</div>

With time
Datepickers can be customized to select time.

<div class="w-80 flex flex-col bg-white border border-gray-200 shadow-lg rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
    <!-- Calendar -->
    <div class="p-3 space-y-0.5">
      <!-- Months -->
      <div class="grid grid-cols-5 items-center gap-x-3 mx-1.5 pb-3">
        <!-- Prev Button -->
        <div class="col-span-1">
          <button type="button" class="size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-label="Previous">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
          </button>
        </div>
        <!-- End Prev Button -->

        <!-- Month / Year -->
        <div class="col-span-3 flex justify-center items-center gap-x-1">
          <div class="relative">
            <select data-hs-select='{
                "placeholder": "Select month",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative flex text-nowrap w-full cursor-pointer text-start font-medium text-gray-800 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 before:absolute before:inset-0 before:z-1 dark:text-neutral-200 dark:hover:text-blue-500 dark:focus:text-blue-500",
                "dropdownClasses": "mt-2 z-50 w-32 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                "optionClasses": "p-2 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-gray-800 dark:text-neutral-200\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
              }' class="hidden">
              <option value="0">January</option>
              <option value="1">February</option>
              <option value="2">March</option>
              <option value="3">April</option>
              <option value="4">May</option>
              <option value="5">June</option>
              <option value="6" selected>July</option>
              <option value="7">August</option>
              <option value="8">September</option>
              <option value="9">October</option>
              <option value="10">November</option>
              <option value="11">December</option>
            </select>
          </div>

          <span class="text-gray-800 dark:text-neutral-200">/</span>

          <div class="relative">
            <select data-hs-select='{
                "placeholder": "Select year",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative flex text-nowrap w-full cursor-pointer text-start font-medium text-gray-800 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 before:absolute before:inset-0 before:z-1 dark:text-neutral-200 dark:hover:text-blue-500 dark:focus:text-blue-500",
                "dropdownClasses": "mt-2 z-50 w-20 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                "optionClasses": "p-2 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-gray-800 dark:text-neutral-200\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
              }' class="hidden">
              <option selected>2023</option>
              <option>2024</option>
              <option>2025</option>
              <option>2026</option>
              <option>2027</option>
            </select>
          </div>
        </div>
        <!-- End Month / Year -->

        <!-- Next Button -->
        <div class="col-span-1 flex justify-end">
          <button type="button" class=" size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-label="Next">
            <svg class="shrink-0 size-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
          </button>
        </div>
        <!-- End Next Button -->
      </div>
      <!-- Months -->

      <!-- Weeks -->
      <div class="flex pb-1.5">
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Mo
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Tu
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          We
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Th
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Fr
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Sa
        </span>
        <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
          Su
        </span>
      </div>
      <!-- Weeks -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            26
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            27
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            28
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            29
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500" disabled>
            30
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            1
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            2
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            3
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            4
          </button>
        </div>
        <div class="bg-gray-100 rounded-s-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center bg-blue-600 border-[1.5px] border-transparent text-sm font-medium text-white hover:border-blue-600 focus:outline-hidden focus:border-blue-600 rounded-full disabled:text-gray-300 disabled:pointer-events-none dark:bg-blue-500 dark:hover:border-neutral-700 dark:focus:border-neutral-700">
            5
          </button>
        </div>
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            6
          </button>
        </div>
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            7
          </button>
        </div>
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            8
          </button>
        </div>
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            9
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            10
          </button>
        </div>
        <div class="bg-gray-100 first:rounded-s-full last:rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            11
          </button>
        </div>
        <div class="bg-gray-100 rounded-e-full dark:bg-neutral-800">
          <button type="button" class="m-px size-10 flex justify-center items-center bg-blue-600 border-[1.5px] border-transparent text-sm font-medium text-white hover:border-blue-600 focus:outline-hidden focus:border-blue-600 rounded-full disabled:text-gray-300 disabled:pointer-events-none dark:bg-blue-500 dark:hover:border-neutral-700 dark:focus:border-neutral-700">
            12
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            13
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            14
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            15
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            16
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            17
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            18
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            19
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            20
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            21
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            22
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            23
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            24
          </button>
        </div>
        <div >
            <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            25
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            26
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            27
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            28
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            29
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            30
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Days -->
      <div class="flex">
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 rounded-full hover:border-blue-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:border-blue-600 focus:text-blue-600 dark:text-neutral-200 dark:hover:border-blue-500 dark:hover:text-blue-500 dark:focus:border-blue-500 dark:focus:text-blue-500">
            31
          </button>
        </div>
        <div >
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            1
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            2
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            3
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            4
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            5
          </button>
        </div>
        <div>
          <button type="button" class="m-px size-10 flex justify-center items-center border-[1.5px] border-transparent text-sm text-gray-800 hover:border-blue-600 hover:text-blue-600 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:border-neutral-500 dark:focus:bg-neutral-700" disabled>
            6
          </button>
        </div>
      </div>
      <!-- Days -->

      <!-- Time -->
      <div class="pt-3 flex justify-center items-center gap-x-2">
        <!-- Select -->
        <div class="relative">
          <select data-hs-select='{
              "placeholder": "Select option...",
              "viewport": "#with-time-tab-preview-datepicker",
              "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
              "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-1 px-2 pe-6 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-1 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400",
              "dropdownClasses": "mt-2 z-50 w-full min-w-24 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-neutral-900 dark:border-neutral-700",
              "dropdownVerticalFixedPlacement": "top",
              "optionClasses": "hs-selected:bg-gray-100 dark:hs-selected:bg-neutral-800 py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:hs-selected:bg-gray-700 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
              "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span></div>"
            }' class="hidden">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
            <option>11</option>
            <option selected>12</option>
          </select>

          <div class="absolute top-1/2 end-2 -translate-y-1/2">
            <svg class="shrink-0 size-3 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
          </div>
        </div>
        <!-- End Select -->

        <span class="text-gray-800 dark:text-white">:</span>

        <!-- Select -->
        <div class="relative">
          <select data-hs-select='{
              "placeholder": "Select option...",
              "viewport": "#with-time-tab-preview-datepicker",
              "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
              "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-1 px-2 pe-6 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-1 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400",
              "dropdownClasses": "mt-2 z-50 w-full min-w-24 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-neutral-900 dark:border-neutral-700",
              "dropdownVerticalFixedPlacement": "top",
              "optionClasses": "hs-selected:bg-gray-100 dark:hs-selected:bg-neutral-800 py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:hs-selected:bg-gray-700 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
              "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span></div>"
            }' class="hidden">
            <option selected>00</option>
            <option>01</option>
            <option>02</option>
            <option>03</option>
            <option>04</option>
            <option>05</option>
            <option>06</option>
            <option>07</option>
            <option>08</option>
            <option>09</option>
            <option>10</option>
            <option>11</option>
            <option>12</option>
            <option>13</option>
            <option>14</option>
            <option>15</option>
            <option>16</option>
            <option>17</option>
            <option>18</option>
            <option>19</option>
            <option>20</option>
            <option>21</option>
            <option>22</option>
            <option>23</option>
            <option>24</option>
            <option>25</option>
            <option>26</option>
            <option>27</option>
            <option>28</option>
            <option>29</option>
            <option>30</option>
            <option>31</option>
            <option>32</option>
            <option>33</option>
            <option>34</option>
            <option>35</option>
            <option>36</option>
            <option>37</option>
            <option>38</option>
            <option>39</option>
            <option>40</option>
            <option>41</option>
            <option>42</option>
            <option>43</option>
            <option>44</option>
            <option>45</option>
            <option>46</option>
            <option>47</option>
            <option>48</option>
            <option>49</option>
            <option>50</option>
            <option>51</option>
            <option>52</option>
            <option>53</option>
            <option>54</option>
            <option>55</option>
            <option>56</option>
            <option>57</option>
            <option>58</option>
            <option>59</option>
          </select>

          <div class="absolute top-1/2 end-2 -translate-y-1/2">
            <svg class="shrink-0 size-3 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
          </div>
        </div>
        <!-- End Select -->

        <!-- Select -->
        <div class="relative">
          <select data-hs-select='{
              "placeholder": "Select option...",
              "viewport": "#with-time-tab-preview-datepicker",
              "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
              "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-1 px-2 pe-6 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-1 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400",
              "dropdownClasses": "mt-2 z-50 w-full min-w-24 max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-neutral-900 dark:border-neutral-700",
              "dropdownVerticalFixedPlacement": "top",
              "optionClasses": "hs-selected:bg-gray-100 dark:hs-selected:bg-neutral-800 py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:hs-selected:bg-gray-700 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
              "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span></div>"
            }' class="hidden">
            <option selected>PM</option>
            <option>AM</option>
          </select>

          <div class="absolute top-1/2 end-2 -translate-y-1/2">
            <svg class="shrink-0 size-3 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
          </div>
        </div>
        <!-- End Select -->
      </div>
      <!-- End Time -->
    </div>

    <!-- Button Group -->
    <div class="py-3 px-4 flex items-center justify-end gap-x-2 border-t border-gray-200 dark:border-neutral-700">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        Cancel
      </button>
      <button type="button" class="py-2 px-3  inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border-[1.5px] border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:ring-2 focus:ring-blue-500">
        Apply
      </button>
    </div>
    <!-- End Button Group -->
</div>



### 7. Listado de lists ###

Setting the list style type
To create bulleted or numeric lists, use the .list-disc and .list-decimal utilities.

<div>
  <span class="font-medium text-sm text-gray-500 font-mono mb-3 dark:text-neutral-400">list-disc</span>
  <ul class="list-disc list-inside text-gray-800 dark:text-white">
    <li>Now this is a story all about how, my life got flipped turned upside down</li>
    <li>And I like to take a minute and sit right here</li>
    <li>I'll tell you how I became the prince of a town called Bel-Air </li>
  </ul>
</div>

<div>
  <span class="font-medium text-sm text-gray-500 font-mono mb-3 dark:text-neutral-400">list-decimal</span>
  <ol class="list-decimal list-inside text-gray-800 dark:text-white">
    <li>Now this is a story all about how, my life got flipped turned upside down</li>
    <li>And I like to take a minute and sit right here</li>
    <li>I'll tell you how I became the prince of a town called Bel-Air </li>
  </ol>
</div>

<div>
  <span class="font-medium text-sm text-gray-500 font-mono mb-3 dark:text-neutral-400">list-none</span>
  <ul class="list-none list-inside text-gray-800 dark:text-white">
    <li>Now this is a story all about how, my life got flipped turned upside down</li>
    <li>And I like to take a minute and sit right here</li>
    <li>I'll tell you how I became the prince of a town called Bel-Air </li>
  </ul>
</div>

List marker
Style the counters or bullets in lists using the marker modifier:

<ul class="marker:text-blue-600 list-disc ps-5 space-y-2 text-sm text-gray-600 dark:text-neutral-400">
  <li>
    FAQ
  </li>
  <li>
    License
  </li>
  <li>
    Terms & Conditions
  </li>
</ul>

Separator
A basic form of the inline list with dotted separator.

<ul class="text-sm text-gray-600">
  <li class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full dark:text-neutral-400 dark:before:bg-neutral-600">
    FAQ
  </li>
  <li class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full dark:text-neutral-400 dark:before:bg-neutral-600">
    License
  </li>
  <li class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full dark:text-neutral-400 dark:before:bg-neutral-600">
    Terms & Conditions
  </li>
</ul><ul class="text-sm text-gray-600">
  <li class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full dark:text-neutral-400 dark:before:bg-neutral-600">
    FAQ
  </li>
  <li class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full dark:text-neutral-400 dark:before:bg-neutral-600">
    License
  </li>
  <li class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full dark:text-neutral-400 dark:before:bg-neutral-600">
    Terms & Conditions
  </li>
</ul>

Checked style
Replacing the default list style check style icons.

<ul class="space-y-3 text-sm">
  <li class="flex gap-x-3">
    <svg class="shrink-0 size-4 mt-0.5 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span class="text-gray-800 dark:text-neutral-400">
      FAQ
    </span>
  </li>

  <li class="flex gap-x-3">
    <svg class="shrink-0 size-4 mt-0.5 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span class="text-gray-800 dark:text-neutral-400">
      License
    </span>
  </li>

  <li class="flex gap-x-3">
    <svg class="shrink-0 size-4 mt-0.5 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span class="text-gray-800 dark:text-neutral-400">
      Terms & Conditions
    </span>
  </li>
</ul>

<ul class="space-y-3 text-sm">
  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-800/30 dark:text-blue-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-800 dark:text-neutral-400">
      FAQ
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-800/30 dark:text-blue-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-800 dark:text-neutral-400">
      License
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-800/30 dark:text-blue-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-800 dark:text-neutral-400">
      Terms & Conditions
    </span>
  </li>
</ul>

<ul class="space-y-3 text-sm">
  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-blue-600 text-white dark:bg-blue-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-800 dark:text-neutral-400">
      FAQ
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-blue-600 text-white dark:bg-blue-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-800 dark:text-neutral-400">
      License
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-blue-600 text-white dark:bg-blue-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-800 dark:text-neutral-400">
      Terms & Conditions
    </span>
  </li>
</ul>

List checked color variations
Predefined list checked color styles.

<ul class="space-y-3 text-sm">
  <li class="flex gap-x-3">
    <svg class="shrink-0 size-4 mt-0.5 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span class="text-gray-600 dark:text-white">
      Dark
    </span>
  </li>

  <li class="flex gap-x-3">
    <svg class="shrink-0 size-4 mt-0.5 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span class="text-gray-600 dark:text-white">
      Gray
    </span>
  </li>

  <li class="flex gap-x-3">
    <svg class="shrink-0 size-4 mt-0.5 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span class="text-gray-600 dark:text-white">
      Green
    </span>
  </li>

  <li class="flex gap-x-3">
    <svg class="shrink-0 size-4 mt-0.5 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span class="text-gray-600 dark:text-white">
      Blue
    </span>
  </li>

  <li class="flex gap-x-3">
    <svg class="shrink-0 size-4 mt-0.5 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span class="text-gray-600 dark:text-white">
      Red
    </span>
  </li>

  <li class="flex gap-x-3">
    <svg class="shrink-0 size-4 mt-0.5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span class="text-gray-600 dark:text-white">
      Yellow
    </span>
  </li>

  <li class="flex gap-x-3">
    <svg class="shrink-0 size-4 mt-0.5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span class="text-gray-600 dark:text-white">
      Light
    </span>
  </li>
</ul>

<ul class="space-y-3 text-sm">
  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-gray-50 text-gray-600 dark:bg-neutral-700 dark:text-neutral-200">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Dark
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-gray-50 text-gray-500 dark:bg-neutral-700 dark:text-neutral-400">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Gray
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-teal-50 text-teal-500 dark:bg-teal-800/30 dark:text-teal-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Green
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-blue-60 text-blue-600 dark:bg-blue-800/30 dark:text-blue-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Blue
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-red-50 text-red-500 dark:bg-red-800/30 dark:text-red-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Red
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-yellow-50 text-yellow-500 dark:bg-yellow-800/30 dark:text-yellow-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Yellow
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-white/10 text-white">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Light
    </span>
  </li>
</ul>

<ul class="space-y-3 text-sm">
  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-gray-800 text-gray-200 dark:bg-neutral-200 dark:text-neutral-800">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Dark
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-gray-500 text-white">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Gray
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-teal-500 text-white">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Green
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-blue-600 text-white dark:bg-blue-500">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Blue
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-red-500 text-white">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Red
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-yellow-500 text-white">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Yellow
    </span>
  </li>

  <li class="flex gap-x-3">
    <span class="size-5 flex justify-center items-center rounded-full bg-white text-gray-800">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
    <span class="text-gray-600 dark:text-white">
      Light
    </span>
  </li>
</ul>


### 8. Listado de list group ###

Example
The most basic list group is an unordered list with list items.

<ul class="max-w-xs flex flex-col">
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    Profile
  </li>
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    Settings
  </li>
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    Newsletter
  </li>
</ul><ul class="max-w-xs flex flex-col">
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    Profile
  </li>
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    Settings
  </li>
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    Newsletter
  </li>
</ul>

Icons
The default list group with icons.

<ul class="max-w-xs flex flex-col">
  <li class="inline-flex items-center gap-x-3.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
      <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
    </svg>
    Newsletter
  </li>
  <li class="inline-flex items-center gap-x-3.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path>
      <path d="M12 12v9"></path>
      <path d="m8 17 4 4 4-4"></path>
    </svg>
    Downloads
  </li>
  <li class="inline-flex items-center gap-x-3.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
      <circle cx="9" cy="7" r="4"></circle>
      <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
      <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    Team Account
  </li>
</ul>

Links
Use <a> to create actionable list group items with hover, disabled, and active states.

<div class="max-w-xs flex flex-col">
  <a class="inline-flex items-center gap-x-3.5 py-3 px-4 text-sm font-medium border border-gray-200 text-blue-600 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:border-neutral-700" href="#">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
      <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
    </svg>
    Active
  </a>
  <a class="inline-flex items-center gap-x-3.5 py-3 px-4 text-sm font-medium border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg hover:text-blue-600 focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:border-neutral-700 dark:text-white dark:hover:text-blue-600" href="#">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path>
      <path d="M12 12v9"></path>
      <path d="m8 17 4 4 4-4"></path>
    </svg>
    Link
  </a>
  <a class="inline-flex items-center gap-x-3.5 py-3 px-4 text-sm font-medium border border-gray-200 text-gray-400 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg cursor-not-allowed focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:border-neutral-700 dark:text-neutral-700" href="#">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
      <circle cx="9" cy="7" r="4"></circle>
      <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
      <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    Disabled
  </a>
</div>

Buttons
Use <button> to create actionable list group items with hover, disabled, and active states.

<div class="max-w-xs flex flex-col">
  <button type="button" class="inline-flex items-center gap-x-2 py-3 px-4 text-sm text-start font-medium border border-gray-200 text-blue-600 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:border-neutral-700">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
      <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
    </svg>
    Active
  </button>
  <button type="button" class="inline-flex items-center gap-x-2 py-3 px-4 text-sm text-start font-medium border border-gray-200 text-gray-800 hover:text-blue-600 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:border-neutral-700 dark:text-white dark:hover:text-blue-500">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path>
      <path d="M12 12v9"></path>
      <path d="m8 17 4 4 4-4"></path>
    </svg>
    Link
  </button>
  <button type="button" class="inline-flex items-center gap-x-2 py-3 px-4 text-sm text-start font-medium border border-gray-200 text-gray-800 hover:text-blue-600 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:border-neutral-700 dark:text-white dark:hover:text-blue-500" disabled="">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
      <circle cx="9" cy="7" r="4"></circle>
      <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
      <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    Disabled
  </button>
</div>

No gutters
No paddings in left and right.

<ul class="max-w-xs flex flex-col divide-y divide-gray-200 dark:divide-neutral-700">
  <li class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-gray-800 dark:text-white">
    Profile
  </li>
  <li class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-gray-800 dark:text-white">
    Settings
  </li>
  <li class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-gray-800 dark:text-white">
    Newsletter
  </li>
</ul>

Horizontal
The default horizontal list group.

The horizontal list will change to vertical order at small resolutions. Reduce browser size to see it in action.

<ul class="flex flex-col sm:flex-row">
  <li class="inline-flex items-center gap-x-2.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ms-px sm:mt-0 sm:first:rounded-se-none sm:first:rounded-es-lg sm:last:rounded-es-none sm:last:rounded-se-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
      <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
    </svg>
    Newsletter
  </li>
  <li class="inline-flex items-center gap-x-2.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ms-px sm:mt-0 sm:first:rounded-se-none sm:first:rounded-es-lg sm:last:rounded-es-none sm:last:rounded-se-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path>
      <path d="M12 12v9"></path>
      <path d="m8 17 4 4 4-4"></path>
    </svg>
    Downloads
  </li>
  <li class="inline-flex items-center gap-x-2.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ms-px sm:mt-0 sm:first:rounded-se-none sm:first:rounded-es-lg sm:last:rounded-es-none sm:last:rounded-se-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
      <circle cx="9" cy="7" r="4"></circle>
      <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
      <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    Team Account
  </li>
</ul>

Badges
Add badges to any list group item to show unread counts, activity, and more.

<ul class="max-w-xs flex flex-col">
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    <div class="flex justify-between w-full">
      Profile
      <span class="inline-flex items-center py-1 px-2 rounded-full text-xs font-medium bg-blue-500 text-white">New</span>
    </div>
  </li>
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    <div class="flex justify-between w-full">
      Settings
      <span class="inline-flex items-center py-1 px-2 rounded-full text-xs font-medium bg-blue-500 text-white">2</span>
    </div>
  </li>
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
    <div class="flex justify-between w-full">
      Newsletter
      <span class="inline-flex items-center py-1 px-2 rounded-full text-xs font-medium bg-blue-500 text-white">99+</span>
    </div>
  </li>
</ul>

List group invoice
A simple list group example with a highlighted footer.

<!-- List Group -->
<ul class="mt-3 flex flex-col">
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
    <div class="flex items-center justify-between w-full">
      <span>Payment to Front</span>
      <span>$264.00</span>
    </div>
  </li>
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-neutral-700 dark:text-neutral-200">
    <div class="flex items-center justify-between w-full">
      <span>Tax fee</span>
      <span>$52.8</span>
    </div>
  </li>
  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-semibold bg-gray-50 border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200">
    <div class="flex items-center justify-between w-full">
      <span>Amount paid</span>
      <span>$316.8</span>
    </div>
  </li>
</ul>
<!-- End List Group -->

List group examples
This can be useful for a large number of invoices.

<!-- List Group -->
<ul class="flex flex-col justify-end text-start -space-y-px">
  <li class="flex items-center gap-x-2 p-3 text-sm bg-white border border-gray-200 text-gray-800 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200">
    <div class="w-full flex justify-between truncate">
      <span class="me-3 flex-1 w-0 truncate">
        resume_web_ui_developer.csv
      </span>
      <button type="button" class="flex items-center gap-x-2 text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 whitespace-nowrap dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="7 10 12 15 17 10"></polyline>
          <line x1="12" x2="12" y1="15" y2="3"></line>
        </svg>
        Download
      </button>
    </div>
  </li>
  <li class="flex items-center gap-x-2 p-3 text-sm bg-white border border-gray-200 text-gray-800 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200">
    <div class="w-full flex justify-between truncate">
      <span class="me-3 flex-1 w-0 truncate">
        coverletter_web_ui_developer.pdf
      </span>
      <button type="button" class="flex items-center gap-x-2 text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 whitespace-nowrap dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="7 10 12 15 17 10"></polyline>
          <line x1="12" x2="12" y1="15" y2="3"></line>
        </svg>
        Download
      </button>
    </div>
  </li>
</ul>
<!-- End List Group -->

### 9. Listado de legend indicator ###

Example
A base form of the legend indicator.

<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-gray-500 rounded-full me-2 dark:bg-neutral-500"></span>
  <span class="text-gray-600 dark:text-neutral-400">Legend indicator</span>
</div>

Color variations
Predefined solid color legend indicator styles.

<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-gray-800 rounded-full me-2 dark:bg-white"></span>
  <span class="text-gray-600 dark:text-neutral-400">Dark</span>
</div>
<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-gray-500 rounded-full me-2"></span>
  <span class="text-gray-600 dark:text-neutral-400">Gray</span>
</div>
<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-red-500 rounded-full me-2"></span>
  <span class="text-gray-600 dark:text-neutral-400">Red</span>
</div>
<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-yellow-500 rounded-full me-2"></span>
  <span class="text-gray-600 dark:text-neutral-400">Yellow</span>
</div>
<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-green-500 rounded-full me-2"></span>
  <span class="text-gray-600 dark:text-neutral-400">Green</span>
</div>
<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-blue-600 rounded-full me-2 dark:bg-blue-500"></span>
  <span class="text-gray-600 dark:text-neutral-400">Blue</span>
</div>
<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-indigo-500 rounded-full me-2"></span>
  <span class="text-gray-600 dark:text-neutral-400">Indigo</span>
</div>
<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-purple-500 rounded-full me-2"></span>
  <span class="text-gray-600 dark:text-neutral-400">Purple</span>
</div>
<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-pink-500 rounded-full me-2"></span>
  <span class="text-gray-600 dark:text-neutral-400">Pink</span>
</div>
<div class="inline-flex items-center">
  <span class="size-2 inline-block bg-white rounded-full me-2"></span>
  <span class="text-gray-600 dark:text-neutral-400">Light</span>
</div>

### 10. Listado de progress ###

Example
Determinate progress bars fill the container from 0 to 100%. This reflects the progress of the process.

<!-- Progress -->
<div class="flex w-full h-1.5 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
  <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 25%"></div>
</div>
<!-- End Progress -->

Height
We only set a height value on the progress, so if you change that value the inner progress bar will automatically resize accordingly.

<div class="space-y-2">
  <!-- Progress -->
  <div class="flex w-full h-1.5 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 25%"></div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex w-full h-4 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 50%"></div>
  </div>
  <!-- End Progress -->
</div>

Label at the end
Place label at the end of a progress.

<div class="space-y-5">
  <!-- Progress -->
  <div class="flex items-center gap-x-3 whitespace-nowrap">
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 25%"></div>
    </div>
    <div class="w-10 text-end">
      <span class="text-sm text-gray-800 dark:text-white">25%</span>
    </div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex items-center gap-x-3 whitespace-nowrap">
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 50%"></div>
    </div>
    <div class="w-10 text-end">
      <span class="text-sm text-gray-800 dark:text-white">50%</span>
    </div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex items-center gap-x-3 whitespace-nowrap">
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 75%"></div>
    </div>
    <div class="w-10 text-end">
      <span class="text-sm text-gray-800 dark:text-white">75%</span>
    </div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex items-center gap-x-3 whitespace-nowrap">
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 100%"></div>
    </div>
    <div class="w-10 text-end">
      <span class="text-sm text-gray-800 dark:text-white">100%</span>
    </div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex items-center gap-x-3 whitespace-nowrap">
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-red-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 80%"></div>
    </div>
    <span class="sr-only">80%</span>
    <div class="w-10 text-end">
      <span class="shrink-0 ms-auto size-4 flex justify-center items-center rounded-full bg-red-500 text-white">
        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"></path>
          <path d="m6 6 12 12"></path>
        </svg>
      </span>
    </div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex items-center gap-x-3 whitespace-nowrap">
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-teal-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 100%"></div>
    </div>
    <span class="sr-only">100%</span>
    <div class="w-10 text-end">
      <span class="shrink-0 ms-auto size-4 flex justify-center items-center rounded-full bg-teal-500 text-white">
        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
      </span>
    </div>
  </div>
  <!-- End Progress -->
</div>

Title label
Use with title.

<div class="space-y-5">
  <!-- Progress -->
  <div>
    <div class="mb-2 flex justify-between items-center">
      <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Progress title</h3>
      <span class="text-sm text-gray-800 dark:text-white">25%</span>
    </div>
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 25%"></div>
    </div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div>
    <div class="mb-2 flex justify-between items-center">
      <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Progress title</h3>
      <span class="text-sm text-gray-800 dark:text-white">50%</span>
    </div>
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 50%"></div>
    </div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div>
    <div class="mb-2 flex justify-between items-center">
      <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Progress title</h3>
      <span class="text-sm text-gray-800 dark:text-white">75%</span>
    </div>
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 75%"></div>
    </div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div>
    <div class="mb-2 flex justify-between items-center">
      <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Progress title</h3>
      <span class="text-sm text-gray-800 dark:text-white">100%</span>
    </div>
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 100%"></div>
    </div>
  </div>
  <!-- End Progress -->
</div>

Color variants
Change the appearance of individual progress bars.

<div class="space-y-5">
  <!-- Progress -->
  <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-gray-800 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-white" style="width: 50%"></div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-gray-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 50%"></div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-teal-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 50%"></div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-red-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 50%"></div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-yellow-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 50%"></div>
  </div>
  <!-- End Progress -->

  <!-- Progress -->
  <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-white text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 50%"></div>
  </div>
  <!-- End Progress -->
</div>

Multiple bars
Include multiple progress bars in a progress component if you need.

<!-- Multiple bars Progress -->
<div class="flex w-full h-1.5 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700">
  <div class="flex flex-col justify-center overflow-hidden bg-blue-400 text-xs text-white text-center whitespace-nowrap" style="width: 25%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
  <div class="flex flex-col justify-center overflow-hidden bg-blue-700 text-xs text-white text-center whitespace-nowrap" style="width: 15%" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
  <div class="flex flex-col justify-center overflow-hidden bg-gray-800 text-xs text-white text-center whitespace-nowrap dark:bg-white" style="width: 30%" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
  <div class="flex flex-col justify-center overflow-hidden bg-orange-600 text-xs text-white text-center whitespace-nowrap" style="width: 5%" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<!-- End Multiple bars Progress -->

Straight bar
Bar with 0 radius, but rounded progress.

<!-- Progress -->
<div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
  <div class="flex flex-col justify-center overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 25%"></div>
</div>
<!-- End Progress -->

Vertical progress
A base form of vertical progress.

<div class="flex gap-x-8">
  <!-- Progress Vertical -->
  <div class="flex flex-col flex-nowrap justify-end w-2 h-32 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
    <div class="rounded-full overflow-hidden bg-blue-600" style="height: 25%"></div>
  </div>
  <!-- End Progress Vertical -->

  <!-- Progress Vertical -->
  <div class="flex flex-col flex-nowrap justify-end w-2 h-32 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
    <div class="rounded-full overflow-hidden bg-blue-600" style="height: 50%"></div>
  </div>
  <!-- End Progress Vertical -->

  <!-- Progress Vertical -->
  <div class="flex flex-col flex-nowrap justify-end w-2 h-32 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
    <div class="rounded-full overflow-hidden bg-blue-600" style="height: 75%"></div>
  </div>
  <!-- End Progress Vertical -->

  <!-- Progress Vertical -->
  <div class="flex flex-col flex-nowrap justify-end w-2 h-32 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
    <div class="rounded-full overflow-hidden bg-blue-600" style="height: 90%"></div>
  </div>
  <!-- End Progress Vertical -->

  <!-- Progress Vertical -->
  <div class="flex flex-col flex-nowrap justify-end w-2 h-32 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="17" aria-valuemin="0" aria-valuemax="100">
    <div class="rounded-full overflow-hidden bg-blue-600" style="height: 17%"></div>
  </div>
  <!-- End Progress Vertical -->
</div>

Gauge progress
To adjust the percentage, change the first number in the progress circle's stroke-dasharray where it's max value 75 for gauge and 50 for half circle gauge. For example, for 50% progress, use stroke-dasharray="37.5 100" (50% of 75 is 37.5).

<!-- Gauge Component -->
<div class="relative size-40">
  <svg class="rotate-[135deg] size-full" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
    <!-- Background Circle (Gauge) -->
    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-gray-200 dark:text-neutral-700" stroke-width="1.5" stroke-dasharray="75 100" stroke-linecap="round"></circle>

    <!-- Gauge Progress -->
    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-blue-600 dark:text-blue-500" stroke-width="1.5" stroke-dasharray="37.5 100" stroke-linecap="round"></circle>
  </svg>

  <!-- Value Text -->
  <div class="absolute top-1/2 start-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
    <span class="text-4xl font-bold text-blue-600 dark:text-blue-500">50</span>
    <span class="text-blue-600 dark:text-blue-500 block">Score</span>
  </div>
</div>
<!-- End Gauge Component -->

<!-- Gauge Component -->
<div class="relative size-40">
  <svg class="size-full rotate-180" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
    <!-- Background Circle (Gauge) -->
    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-gray-200 dark:text-neutral-700" stroke-width="1" stroke-dasharray="50 100" stroke-linecap="round"></circle>

    <!-- Gauge Progress -->
    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-blue-600 dark:text-blue-500" stroke-width="1.5" stroke-dasharray="37.5 100" stroke-linecap="round"></circle>
  </svg>

  <!-- Value Text -->
  <div class="absolute top-9 start-1/2 transform -translate-x-1/2 text-center">
    <span class="text-3xl font-bold text-blue-600 dark:text-blue-500">75</span>
    <span class="text-sm text-blue-600 dark:text-blue-500 block">Score</span>
  </div>
</div>
<!-- End Gauge Component -->

Customize visual look by adjusting stroke-width and color, text values. You may also adjust the stroke-linecap to change the shape of the gauge.

<!-- Gauge Component -->
<div class="relative size-40">
  <svg class="rotate-[135deg] size-full" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
    <!-- Background Circle (Gauge) -->
    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-purple-200 dark:text-neutral-700" stroke-width="1" stroke-dasharray="75 100"></circle>

    <!-- Gauge Progress -->
    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-purple-600 dark:text-purple-500" stroke-width="2" stroke-dasharray="18.75 100"></circle>
  </svg>

  <!-- Value Text -->
  <div class="absolute top-1/2 start-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
    <span class="text-4xl font-bold text-purple-600 dark:text-purple-500">25</span>
    <span class="text-purple-600 dark:text-purple-500 block">mph</span>
  </div>
</div>
<!-- End Gauge Component -->

<!-- Gauge Component -->
<div class="relative size-40">
  <svg class="rotate-[135deg] size-full" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
    <!-- Background Circle (Gauge) -->
    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-green-200 dark:text-neutral-700" stroke-width="1" stroke-dasharray="75 100" stroke-linecap="round"></circle>

    <!-- Gauge Progress -->
    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-green-500 dark:text-green-500" stroke-width="2" stroke-dasharray="56.25 100" stroke-linecap="round"></circle>
  </svg>

  <!-- Value Text -->
  <div class="absolute top-1/2 start-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
    <span class="text-4xl font-bold text-green-600 dark:text-green-500">75</span>
    <span class="text-green-600 dark:text-green-500 block">Score</span>
  </div>
</div>
<!-- End Gauge Component -->

<!-- Gauge Component -->
<div class="relative size-40">
  <svg class="size-full rotate-180" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
    <!-- Background Circle (Gauge) -->
    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-orange-100 dark:text-neutral-700" stroke-width="3" stroke-dasharray="50 100" stroke-linecap="round"></circle>

    <!-- Gauge Progress -->
    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-orange-600 dark:text-orange-500" stroke-width="1" stroke-dasharray="25 100" stroke-linecap="round"></circle>
  </svg>

  <!-- Value Text -->
  <div class="absolute top-9 start-1/2 transform -translate-x-1/2 text-center">
    <span class="text-2xl font-bold text-orange-600 dark:text-orange-500">50</span>
    <span class="text-xs text-orange-600 dark:text-orange-500 block">Average</span>
  </div>
</div>
<!-- End Gauge Component -->



### 11. Listado de File Uploading Progress ###

Just uploaded file
A single just uploaded file example.

<!-- File Uploading Progress Form -->
<div>
  <!-- Uploading File Content -->
  <div class="mb-2 flex justify-between items-center">
    <div class="flex items-center gap-x-3">
      <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
        <svg class="shrink-0 size-5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.0243 1.43996H7.08805C6.82501 1.43996 6.57277 1.54445 6.38677 1.73043C6.20077 1.91642 6.09631 2.16868 6.09631 2.43171V6.64796L15.0243 11.856L19.4883 13.7398L23.9523 11.856V6.64796L15.0243 1.43996Z" fill="#21A366"></path>
          <path d="M6.09631 6.64796H15.0243V11.856H6.09631V6.64796Z" fill="#107C41"></path>
          <path d="M22.9605 1.43996H15.0243V6.64796H23.9523V2.43171C23.9523 2.16868 23.8478 1.91642 23.6618 1.73043C23.4758 1.54445 23.2235 1.43996 22.9605 1.43996Z" fill="#33C481"></path>
          <path d="M15.0243 11.856H6.09631V21.2802C6.09631 21.5433 6.20077 21.7955 6.38677 21.9815C6.57277 22.1675 6.82501 22.272 7.08805 22.272H22.9606C23.2236 22.272 23.4759 22.1675 23.6618 21.9815C23.8478 21.7955 23.9523 21.5433 23.9523 21.2802V17.064L15.0243 11.856Z" fill="#185C37"></path>
          <path d="M15.0243 11.856H23.9523V17.064H15.0243V11.856Z" fill="#107C41"></path>
          <path opacity="0.1" d="M12.5446 5.15996H6.09631V19.296H12.5446C12.8073 19.2952 13.0591 19.1904 13.245 19.0046C13.4308 18.8188 13.5355 18.567 13.5363 18.3042V6.1517C13.5355 5.88892 13.4308 5.63712 13.245 5.4513C13.0591 5.26548 12.8073 5.16074 12.5446 5.15996Z" fill="black"></path>
          <path opacity="0.2" d="M11.8006 5.90396H6.09631V20.04H11.8006C12.0633 20.0392 12.3151 19.9344 12.501 19.7486C12.6868 19.5628 12.7915 19.311 12.7923 19.0482V6.8957C12.7915 6.6329 12.6868 6.38114 12.501 6.19532C12.3151 6.0095 12.0633 5.90475 11.8006 5.90396Z" fill="black"></path>
          <path opacity="0.2" d="M11.8006 5.90396H6.09631V18.552H11.8006C12.0633 18.5512 12.3151 18.4464 12.501 18.2606C12.6868 18.0748 12.7915 17.823 12.7923 17.5602V6.8957C12.7915 6.6329 12.6868 6.38114 12.501 6.19532C12.3151 6.0095 12.0633 5.90475 11.8006 5.90396Z" fill="black"></path>
          <path opacity="0.2" d="M11.0566 5.90396H6.09631V18.552H11.0566C11.3193 18.5512 11.5711 18.4464 11.757 18.2606C11.9428 18.0748 12.0475 17.823 12.0483 17.5602V6.8957C12.0475 6.6329 11.9428 6.38114 11.757 6.19532C11.5711 6.0095 11.3193 5.90475 11.0566 5.90396Z" fill="black"></path>
          <path d="M1.13604 5.90396H11.0566C11.3195 5.90396 11.5718 6.00842 11.7578 6.19442C11.9438 6.38042 12.0483 6.63266 12.0483 6.8957V16.8162C12.0483 17.0793 11.9438 17.3315 11.7578 17.5175C11.5718 17.7035 11.3195 17.808 11.0566 17.808H1.13604C0.873012 17.808 0.620754 17.7035 0.434765 17.5175C0.248775 17.3315 0.144287 17.0793 0.144287 16.8162V6.8957C0.144287 6.63266 0.248775 6.38042 0.434765 6.19442C0.620754 6.00842 0.873012 5.90396 1.13604 5.90396Z" fill="#107C41"></path>
          <path d="M2.77283 15.576L5.18041 11.8455L2.9752 8.13596H4.74964L5.95343 10.5071C6.06401 10.7318 6.14015 10.8994 6.18185 11.01H6.19745C6.27683 10.8305 6.35987 10.6559 6.44669 10.4863L7.73309 8.13596H9.36167L7.09991 11.8247L9.41897 15.576H7.68545L6.29489 12.972C6.22943 12.861 6.17387 12.7445 6.12899 12.6238H6.10817C6.06761 12.7419 6.01367 12.855 5.94748 12.9608L4.51676 15.576H2.77283Z" fill="white"></path>
        </svg>
      </span>
      <div>
        <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui.xls</p>
        <p class="text-xs text-gray-500 dark:text-neutral-500">7 KB</p>
      </div>
    </div>
    <div class="inline-flex items-center gap-x-2">
      <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect width="4" height="16" x="6" y="4"></rect>
          <rect width="4" height="16" x="14" y="4"></rect>
        </svg>
        <span class="sr-only">Pause</span>
      </button>
      <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 6h18"></path>
          <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
          <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
          <line x1="10" x2="10" y1="11" y2="17"></line>
          <line x1="14" x2="14" y1="11" y2="17"></line>
        </svg>
        <span class="sr-only">Delete</span>
      </button>
    </div>
  </div>
  <!-- End Uploading File Content -->

  <!-- Progress Bar -->
  <div class="flex items-center gap-x-3 whitespace-nowrap">
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 1%"></div>
    </div>
    <div class="w-6 text-end">
      <span class="text-sm text-gray-800 dark:text-white">0%</span>
    </div>
  </div>
  <!-- End Progress Bar -->
</div>
<!-- End File Uploading Progress Form -->

In progress file
A single in progress file example.

<!-- File Uploading Progress Form -->
<div>
  <!-- Uploading File Content -->
  <div class="mb-2 flex justify-between items-center">
    <div class="flex items-center gap-x-3">
      <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
        <svg class="shrink-0 size-5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.0243 1.43996H7.08805C6.82501 1.43996 6.57277 1.54445 6.38677 1.73043C6.20077 1.91642 6.09631 2.16868 6.09631 2.43171V6.64796L15.0243 11.856L19.4883 13.7398L23.9523 11.856V6.64796L15.0243 1.43996Z" fill="#21A366"></path>
          <path d="M6.09631 6.64796H15.0243V11.856H6.09631V6.64796Z" fill="#107C41"></path>
          <path d="M22.9605 1.43996H15.0243V6.64796H23.9523V2.43171C23.9523 2.16868 23.8478 1.91642 23.6618 1.73043C23.4758 1.54445 23.2235 1.43996 22.9605 1.43996Z" fill="#33C481"></path>
          <path d="M15.0243 11.856H6.09631V21.2802C6.09631 21.5433 6.20077 21.7955 6.38677 21.9815C6.57277 22.1675 6.82501 22.272 7.08805 22.272H22.9606C23.2236 22.272 23.4759 22.1675 23.6618 21.9815C23.8478 21.7955 23.9523 21.5433 23.9523 21.2802V17.064L15.0243 11.856Z" fill="#185C37"></path>
          <path d="M15.0243 11.856H23.9523V17.064H15.0243V11.856Z" fill="#107C41"></path>
          <path opacity="0.1" d="M12.5446 5.15996H6.09631V19.296H12.5446C12.8073 19.2952 13.0591 19.1904 13.245 19.0046C13.4308 18.8188 13.5355 18.567 13.5363 18.3042V6.1517C13.5355 5.88892 13.4308 5.63712 13.245 5.4513C13.0591 5.26548 12.8073 5.16074 12.5446 5.15996Z" fill="black"></path>
          <path opacity="0.2" d="M11.8006 5.90396H6.09631V20.04H11.8006C12.0633 20.0392 12.3151 19.9344 12.501 19.7486C12.6868 19.5628 12.7915 19.311 12.7923 19.0482V6.8957C12.7915 6.6329 12.6868 6.38114 12.501 6.19532C12.3151 6.0095 12.0633 5.90475 11.8006 5.90396Z" fill="black"></path>
          <path opacity="0.2" d="M11.8006 5.90396H6.09631V18.552H11.8006C12.0633 18.5512 12.3151 18.4464 12.501 18.2606C12.6868 18.0748 12.7915 17.823 12.7923 17.5602V6.8957C12.7915 6.6329 12.6868 6.38114 12.501 6.19532C12.3151 6.0095 12.0633 5.90475 11.8006 5.90396Z" fill="black"></path>
          <path opacity="0.2" d="M11.0566 5.90396H6.09631V18.552H11.0566C11.3193 18.5512 11.5711 18.4464 11.757 18.2606C11.9428 18.0748 12.0475 17.823 12.0483 17.5602V6.8957C12.0475 6.6329 11.9428 6.38114 11.757 6.19532C11.5711 6.0095 11.3193 5.90475 11.0566 5.90396Z" fill="black"></path>
          <path d="M1.13604 5.90396H11.0566C11.3195 5.90396 11.5718 6.00842 11.7578 6.19442C11.9438 6.38042 12.0483 6.63266 12.0483 6.8957V16.8162C12.0483 17.0793 11.9438 17.3315 11.7578 17.5175C11.5718 17.7035 11.3195 17.808 11.0566 17.808H1.13604C0.873012 17.808 0.620754 17.7035 0.434765 17.5175C0.248775 17.3315 0.144287 17.0793 0.144287 16.8162V6.8957C0.144287 6.63266 0.248775 6.38042 0.434765 6.19442C0.620754 6.00842 0.873012 5.90396 1.13604 5.90396Z" fill="#107C41"></path>
          <path d="M2.77283 15.576L5.18041 11.8455L2.9752 8.13596H4.74964L5.95343 10.5071C6.06401 10.7318 6.14015 10.8994 6.18185 11.01H6.19745C6.27683 10.8305 6.35987 10.6559 6.44669 10.4863L7.73309 8.13596H9.36167L7.09991 11.8247L9.41897 15.576H7.68545L6.29489 12.972C6.22943 12.861 6.17387 12.7445 6.12899 12.6238H6.10817C6.06761 12.7419 6.01367 12.855 5.94748 12.9608L4.51676 15.576H2.77283Z" fill="white"></path>
        </svg>
      </span>
      <div>
        <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui.xls</p>
        <p class="text-xs text-gray-500 dark:text-neutral-500">7 KB</p>
      </div>
    </div>
    <div class="inline-flex items-center gap-x-2">
      <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect width="4" height="16" x="6" y="4"></rect>
          <rect width="4" height="16" x="14" y="4"></rect>
        </svg>
        <span class="sr-only">Pause</span>
      </button>
      <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 6h18"></path>
          <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
          <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
          <line x1="10" x2="10" y1="11" y2="17"></line>
          <line x1="14" x2="14" y1="11" y2="17"></line>
        </svg>
        <span class="sr-only">Delete</span>
      </button>
    </div>
  </div>
  <!-- End Uploading File Content -->

  <!-- Progress Bar -->
  <div class="flex items-center gap-x-3 whitespace-nowrap">
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 25%"></div>
    </div>
    <div class="w-6 text-end">
      <span class="text-sm text-gray-800 dark:text-white">25%</span>
    </div>
  </div>
  <!-- End Progress Bar -->
</div>
<!-- End File Uploading Progress Form -->

Completed
This is a successfully uploaded file example.

<!-- File Uploading Progress Form -->
<div>
  <!-- Uploading File Content -->
  <div class="mb-2 flex justify-between items-center">
    <div class="flex items-center gap-x-3">
      <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
        <svg class="shrink-0 size-5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.0243 1.43996H7.08805C6.82501 1.43996 6.57277 1.54445 6.38677 1.73043C6.20077 1.91642 6.09631 2.16868 6.09631 2.43171V6.64796L15.0243 11.856L19.4883 13.7398L23.9523 11.856V6.64796L15.0243 1.43996Z" fill="#21A366"></path>
          <path d="M6.09631 6.64796H15.0243V11.856H6.09631V6.64796Z" fill="#107C41"></path>
          <path d="M22.9605 1.43996H15.0243V6.64796H23.9523V2.43171C23.9523 2.16868 23.8478 1.91642 23.6618 1.73043C23.4758 1.54445 23.2235 1.43996 22.9605 1.43996Z" fill="#33C481"></path>
          <path d="M15.0243 11.856H6.09631V21.2802C6.09631 21.5433 6.20077 21.7955 6.38677 21.9815C6.57277 22.1675 6.82501 22.272 7.08805 22.272H22.9606C23.2236 22.272 23.4759 22.1675 23.6618 21.9815C23.8478 21.7955 23.9523 21.5433 23.9523 21.2802V17.064L15.0243 11.856Z" fill="#185C37"></path>
          <path d="M15.0243 11.856H23.9523V17.064H15.0243V11.856Z" fill="#107C41"></path>
          <path opacity="0.1" d="M12.5446 5.15996H6.09631V19.296H12.5446C12.8073 19.2952 13.0591 19.1904 13.245 19.0046C13.4308 18.8188 13.5355 18.567 13.5363 18.3042V6.1517C13.5355 5.88892 13.4308 5.63712 13.245 5.4513C13.0591 5.26548 12.8073 5.16074 12.5446 5.15996Z" fill="black"></path>
          <path opacity="0.2" d="M11.8006 5.90396H6.09631V20.04H11.8006C12.0633 20.0392 12.3151 19.9344 12.501 19.7486C12.6868 19.5628 12.7915 19.311 12.7923 19.0482V6.8957C12.7915 6.6329 12.6868 6.38114 12.501 6.19532C12.3151 6.0095 12.0633 5.90475 11.8006 5.90396Z" fill="black"></path>
          <path opacity="0.2" d="M11.8006 5.90396H6.09631V18.552H11.8006C12.0633 18.5512 12.3151 18.4464 12.501 18.2606C12.6868 18.0748 12.7915 17.823 12.7923 17.5602V6.8957C12.7915 6.6329 12.6868 6.38114 12.501 6.19532C12.3151 6.0095 12.0633 5.90475 11.8006 5.90396Z" fill="black"></path>
          <path opacity="0.2" d="M11.0566 5.90396H6.09631V18.552H11.0566C11.3193 18.5512 11.5711 18.4464 11.757 18.2606C11.9428 18.0748 12.0475 17.823 12.0483 17.5602V6.8957C12.0475 6.6329 11.9428 6.38114 11.757 6.19532C11.5711 6.0095 11.3193 5.90475 11.0566 5.90396Z" fill="black"></path>
          <path d="M1.13604 5.90396H11.0566C11.3195 5.90396 11.5718 6.00842 11.7578 6.19442C11.9438 6.38042 12.0483 6.63266 12.0483 6.8957V16.8162C12.0483 17.0793 11.9438 17.3315 11.7578 17.5175C11.5718 17.7035 11.3195 17.808 11.0566 17.808H1.13604C0.873012 17.808 0.620754 17.7035 0.434765 17.5175C0.248775 17.3315 0.144287 17.0793 0.144287 16.8162V6.8957C0.144287 6.63266 0.248775 6.38042 0.434765 6.19442C0.620754 6.00842 0.873012 5.90396 1.13604 5.90396Z" fill="#107C41"></path>
          <path d="M2.77283 15.576L5.18041 11.8455L2.9752 8.13596H4.74964L5.95343 10.5071C6.06401 10.7318 6.14015 10.8994 6.18185 11.01H6.19745C6.27683 10.8305 6.35987 10.6559 6.44669 10.4863L7.73309 8.13596H9.36167L7.09991 11.8247L9.41897 15.576H7.68545L6.29489 12.972C6.22943 12.861 6.17387 12.7445 6.12899 12.6238H6.10817C6.06761 12.7419 6.01367 12.855 5.94748 12.9608L4.51676 15.576H2.77283Z" fill="white"></path>
        </svg>
      </span>
      <div>
        <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui.xls</p>
        <p class="text-xs text-gray-500 dark:text-neutral-500">7 KB</p>
      </div>
    </div>
    <div class="inline-flex items-center gap-x-2">
      <span class="relative">
        <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
        </svg>
        <span class="sr-only">Success</span>
      </span>
      <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 6h18"></path>
          <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
          <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
          <line x1="10" x2="10" y1="11" y2="17"></line>
          <line x1="14" x2="14" y1="11" y2="17"></line>
        </svg>
        <span class="sr-only">Delete</span>
      </button>
    </div>
  </div>
  <!-- End Uploading File Content -->

  <!-- Progress Bar -->
  <div class="flex items-center gap-x-3 whitespace-nowrap">
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-teal-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 100%"></div>
    </div>
    <div class="w-6 text-end">
      <span class="text-sm text-gray-800 dark:text-white">100%</span>
    </div>
  </div>
  <!-- End Progress Bar -->
</div>
<!-- End File Uploading Progress Form -->

Error
A failed uploaded file example.

<!-- File Uploading Progress Form -->
<div>
  <!-- Uploading File Content -->
  <div class="mb-2 flex justify-between items-center">
    <div class="flex items-center gap-x-3">
      <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
        <svg class="shrink-0 size-5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.0243 1.43996H7.08805C6.82501 1.43996 6.57277 1.54445 6.38677 1.73043C6.20077 1.91642 6.09631 2.16868 6.09631 2.43171V6.64796L15.0243 11.856L19.4883 13.7398L23.9523 11.856V6.64796L15.0243 1.43996Z" fill="#21A366"></path>
          <path d="M6.09631 6.64796H15.0243V11.856H6.09631V6.64796Z" fill="#107C41"></path>
          <path d="M22.9605 1.43996H15.0243V6.64796H23.9523V2.43171C23.9523 2.16868 23.8478 1.91642 23.6618 1.73043C23.4758 1.54445 23.2235 1.43996 22.9605 1.43996Z" fill="#33C481"></path>
          <path d="M15.0243 11.856H6.09631V21.2802C6.09631 21.5433 6.20077 21.7955 6.38677 21.9815C6.57277 22.1675 6.82501 22.272 7.08805 22.272H22.9606C23.2236 22.272 23.4759 22.1675 23.6618 21.9815C23.8478 21.7955 23.9523 21.5433 23.9523 21.2802V17.064L15.0243 11.856Z" fill="#185C37"></path>
          <path d="M15.0243 11.856H23.9523V17.064H15.0243V11.856Z" fill="#107C41"></path>
          <path opacity="0.1" d="M12.5446 5.15996H6.09631V19.296H12.5446C12.8073 19.2952 13.0591 19.1904 13.245 19.0046C13.4308 18.8188 13.5355 18.567 13.5363 18.3042V6.1517C13.5355 5.88892 13.4308 5.63712 13.245 5.4513C13.0591 5.26548 12.8073 5.16074 12.5446 5.15996Z" fill="black"></path>
          <path opacity="0.2" d="M11.8006 5.90396H6.09631V20.04H11.8006C12.0633 20.0392 12.3151 19.9344 12.501 19.7486C12.6868 19.5628 12.7915 19.311 12.7923 19.0482V6.8957C12.7915 6.6329 12.6868 6.38114 12.501 6.19532C12.3151 6.0095 12.0633 5.90475 11.8006 5.90396Z" fill="black"></path>
          <path opacity="0.2" d="M11.8006 5.90396H6.09631V18.552H11.8006C12.0633 18.5512 12.3151 18.4464 12.501 18.2606C12.6868 18.0748 12.7915 17.823 12.7923 17.5602V6.8957C12.7915 6.6329 12.6868 6.38114 12.501 6.19532C12.3151 6.0095 12.0633 5.90475 11.8006 5.90396Z" fill="black"></path>
          <path opacity="0.2" d="M11.0566 5.90396H6.09631V18.552H11.0566C11.3193 18.5512 11.5711 18.4464 11.757 18.2606C11.9428 18.0748 12.0475 17.823 12.0483 17.5602V6.8957C12.0475 6.6329 11.9428 6.38114 11.757 6.19532C11.5711 6.0095 11.3193 5.90475 11.0566 5.90396Z" fill="black"></path>
          <path d="M1.13604 5.90396H11.0566C11.3195 5.90396 11.5718 6.00842 11.7578 6.19442C11.9438 6.38042 12.0483 6.63266 12.0483 6.8957V16.8162C12.0483 17.0793 11.9438 17.3315 11.7578 17.5175C11.5718 17.7035 11.3195 17.808 11.0566 17.808H1.13604C0.873012 17.808 0.620754 17.7035 0.434765 17.5175C0.248775 17.3315 0.144287 17.0793 0.144287 16.8162V6.8957C0.144287 6.63266 0.248775 6.38042 0.434765 6.19442C0.620754 6.00842 0.873012 5.90396 1.13604 5.90396Z" fill="#107C41"></path>
          <path d="M2.77283 15.576L5.18041 11.8455L2.9752 8.13596H4.74964L5.95343 10.5071C6.06401 10.7318 6.14015 10.8994 6.18185 11.01H6.19745C6.27683 10.8305 6.35987 10.6559 6.44669 10.4863L7.73309 8.13596H9.36167L7.09991 11.8247L9.41897 15.576H7.68545L6.29489 12.972C6.22943 12.861 6.17387 12.7445 6.12899 12.6238H6.10817C6.06761 12.7419 6.01367 12.855 5.94748 12.9608L4.51676 15.576H2.77283Z" fill="white"></path>
        </svg>
      </span>
      <div>
        <p class="font-semibold text-red-500">preline-ui.xls</p>
        <p class="text-xs text-gray-500 dark:text-neutral-500">7 KB</p>
      </div>
    </div>
    <div class="inline-flex items-center gap-x-2">
      <span class="relative">
        <svg class="shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
        </svg>
        <span class="sr-only">Danger</span>
      </span>
      <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 6h18"></path>
          <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
          <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
          <line x1="10" x2="10" y1="11" y2="17"></line>
          <line x1="14" x2="14" y1="11" y2="17"></line>
        </svg>
        <span class="sr-only">Delete</span>
      </button>
    </div>
  </div>
  <!-- End Uploading File Content -->

  <!-- Progress Bar -->
  <div class="flex items-center gap-x-3 whitespace-nowrap">
    <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
      <div class="flex flex-col justify-center rounded-full overflow-hidden bg-red-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 25%"></div>
    </div>
    <div class="w-6 text-end">
      <span class="text-sm text-gray-800 dark:text-white">25%</span>
    </div>
  </div>
  <!-- End Progress Bar -->
</div>
<!-- End File Uploading Progress Form -->

Multiple files: Just uploaded
Multiple files in card style with indication of statuses.

<!-- File Uploading Progress Form -->
<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
  <!-- Body -->
  <div class="p-4 md:p-5 space-y-7">
    <div>
      <!-- Uploading File Content -->
      <div class="mb-2 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
          <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" x2="12" y1="3" y2="15"></line>
            </svg>
          </span>
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui.html</p>
            <p class="text-xs text-gray-500 dark:text-neutral-500">7 KB</p>
          </div>
        </div>
        <div class="inline-flex items-center gap-x-2">
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="4" height="16" x="6" y="4"></rect>
              <rect width="4" height="16" x="14" y="4"></rect>
            </svg>
            <span class="sr-only">Pause</span>
          </button>
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 6h18"></path>
              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
              <line x1="10" x2="10" y1="11" y2="17"></line>
              <line x1="14" x2="14" y1="11" y2="17"></line>
            </svg>
            <span class="sr-only">Delete</span>
          </button>
        </div>
      </div>
      <!-- End Uploading File Content -->

      <!-- Progress Bar -->
      <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 1%"></div>
      </div>
      <!-- End Progress Bar -->
    </div>

    <div>
      <!-- Uploading File Content -->
      <div class="mb-2 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
          <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" x2="12" y1="3" y2="15"></line>
            </svg>
          </span>
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui.mp4</p>
            <p class="text-xs text-gray-500 dark:text-neutral-500">105.5 MB</p>
          </div>
        </div>
        <div class="inline-flex items-center gap-x-2">
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="4" height="16" x="6" y="4"></rect>
              <rect width="4" height="16" x="14" y="4"></rect>
            </svg>
            <span class="sr-only">Pause</span>
          </button>
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 6h18"></path>
              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
              <line x1="10" x2="10" y1="11" y2="17"></line>
              <line x1="14" x2="14" y1="11" y2="17"></line>
            </svg>
            <span class="sr-only">Delete</span>
          </button>
        </div>
      </div>
      <!-- End Uploading File Content -->

      <!-- Progress Bar -->
      <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 1%"></div>
      </div>
      <!-- End Progress Bar -->
    </div>

    <div>
      <!-- Uploading File Content -->
      <div class="mb-2 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
          <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" x2="12" y1="3" y2="15"></line>
            </svg>
          </span>
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui-cover.jpg</p>
            <p class="text-xs text-gray-500 dark:text-neutral-500">55 KB</p>
          </div>
        </div>
        <div class="inline-flex items-center gap-x-2">
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="4" height="16" x="6" y="4"></rect>
              <rect width="4" height="16" x="14" y="4"></rect>
            </svg>
            <span class="sr-only">Pause</span>
          </button>
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 6h18"></path>
              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
              <line x1="10" x2="10" y1="11" y2="17"></line>
              <line x1="14" x2="14" y1="11" y2="17"></line>
            </svg>
            <span class="sr-only">Delete</span>
          </button>
        </div>
      </div>
      <!-- End Uploading File Content -->

      <!-- Progress Bar -->
      <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 1%"></div>
      </div>
      <!-- End Progress Bar -->
    </div>
  </div>
  <!-- End Body -->

  <!-- Footer -->
  <div class="bg-gray-50 border-t border-gray-200 rounded-b-xl py-2 px-4 md:px-5 dark:bg-white/10 dark:border-neutral-700">
    <div class="flex flex-wrap justify-between items-center gap-x-3">
      <div>
        <span class="text-sm font-semibold text-gray-800 dark:text-white">
          3 left
        </span>
      </div>
      <!-- End Col -->

      <div class="-me-2.5">
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1.5 text-sm font-medium rounded-lg border border-transparent text-gray-500 hover:bg-gray-200 hover:text-gray-800 focus:outline-hidden focus:bg-gray-200 focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white dark:focus:bg-neutral-800 dark:focus:text-white">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="4" height="16" x="6" y="4"></rect>
            <rect width="4" height="16" x="14" y="4"></rect>
          </svg>
          <span class="sr-only">Pause</span>
        </button>
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1.5 text-sm font-medium rounded-lg border border-transparent text-gray-500 hover:bg-gray-200 hover:text-gray-800 focus:outline-hidden focus:bg-gray-200 focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white dark:focus:bg-neutral-800 dark:focus:text-white">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 6h18"></path>
            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
            <line x1="10" x2="10" y1="11" y2="17"></line>
            <line x1="14" x2="14" y1="11" y2="17"></line>
          </svg>
          Delete
        </button>
      </div>
      <!-- End Col -->
    </div>
  </div>
  <!-- End Footer -->
</div>
<!-- End File Uploading Progress Form -->

Multiple files: In progress
Success state.

<!-- File Uploading Progress Form -->
<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
  <!-- Body -->
  <div class="p-4 md:p-5 space-y-7">
    <div>
      <!-- Uploading File Content -->
      <div class="mb-2 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
          <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" x2="12" y1="3" y2="15"></line>
            </svg>
          </span>
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui.html</p>
            <p class="text-xs text-gray-500 dark:text-neutral-500">7 KB</p>
          </div>
        </div>
        <div class="inline-flex items-center gap-x-2">
          <span class="relative">
            <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
            </svg>
            <span class="sr-only">Success</span>
          </span>
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 6h18"></path>
              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
              <line x1="10" x2="10" y1="11" y2="17"></line>
              <line x1="14" x2="14" y1="11" y2="17"></line>
            </svg>
            <span class="sr-only">Delete</span>
          </button>
        </div>
      </div>
      <!-- End Uploading File Content -->

      <!-- Progress Bar -->
      <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-teal-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 100%"></div>
      </div>
      <!-- End Progress Bar -->
    </div>

    <div>
      <!-- Uploading File Content -->
      <div class="mb-2 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
          <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" x2="12" y1="3" y2="15"></line>
            </svg>
          </span>
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui.mp4</p>
            <p class="text-xs text-gray-500 dark:text-neutral-500">105.5 MB</p>
          </div>
        </div>
        <div class="inline-flex items-center gap-x-2">
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="4" height="16" x="6" y="4"></rect>
              <rect width="4" height="16" x="14" y="4"></rect>
            </svg>
            <span class="sr-only">Pause</span>
          </button>
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 6h18"></path>
              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
              <line x1="10" x2="10" y1="11" y2="17"></line>
              <line x1="14" x2="14" y1="11" y2="17"></line>
            </svg>
            <span class="sr-only">Delete</span>
          </button>
        </div>
      </div>
      <!-- End Uploading File Content -->

      <!-- Progress Bar -->
      <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500" style="width: 25%"></div>
      </div>
      <!-- End Progress Bar -->
    </div>

    <div>
      <!-- Uploading File Content -->
      <div class="mb-2 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
          <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" x2="12" y1="3" y2="15"></line>
            </svg>
          </span>
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui-cover.jpg</p>
            <p class="text-xs text-gray-500 dark:text-neutral-500">55 KB</p>
          </div>
        </div>
        <div class="inline-flex items-center gap-x-2">
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="4" height="16" x="6" y="4"></rect>
              <rect width="4" height="16" x="14" y="4"></rect>
            </svg>
            <span class="sr-only">Pause</span>
          </button>
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 6h18"></path>
              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
              <line x1="10" x2="10" y1="11" y2="17"></line>
              <line x1="14" x2="14" y1="11" y2="17"></line>
            </svg>
            <span class="sr-only">Delete</span>
          </button>
        </div>
      </div>
      <!-- End Uploading File Content -->

      <!-- Progress Bar -->
      <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-teal-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 100%"></div>
      </div>
      <!-- End Progress Bar -->
    </div>
  </div>
  <!-- End Body -->

  <!-- Footer -->
  <div class="bg-gray-50 border-t border-gray-200 rounded-b-xl py-2 px-4 md:px-5 dark:bg-white/10 dark:border-neutral-700">
    <div class="flex flex-wrap justify-between items-center gap-x-3">
      <div>
        <span class="text-sm font-semibold text-gray-800 dark:text-white">
          1 left
        </span>
      </div>
      <!-- End Col -->

      <div class="-me-2.5">
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1.5 text-sm font-medium rounded-lg border border-transparent text-gray-500 hover:bg-gray-200 hover:text-gray-800 focus:outline-hidden focus:bg-gray-200 focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white dark:focus:bg-neutral-800 dark:focus:text-white">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="4" height="16" x="6" y="4"></rect>
            <rect width="4" height="16" x="14" y="4"></rect>
          </svg>
          Pause
        </button>
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1.5 text-sm font-medium rounded-lg border border-transparent text-gray-500 hover:bg-gray-200 hover:text-gray-800 focus:outline-hidden focus:bg-gray-200 focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white dark:focus:bg-neutral-800 dark:focus:text-white">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 6h18"></path>
            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
            <line x1="10" x2="10" y1="11" y2="17"></line>
            <line x1="14" x2="14" y1="11" y2="17"></line>
          </svg>
          Delete
        </button>
      </div>
      <!-- End Col -->
    </div>
  </div>
  <!-- End Footer -->
</div>
<!-- End File Uploading Progress Form -->

Multiple files: Error
Error state.

<!-- File Uploading Progress Form -->
<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
  <!-- Body -->
  <div class="p-4 md:p-5 space-y-7">
    <div>
      <!-- Uploading File Content -->
      <div class="mb-2 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
          <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" x2="12" y1="3" y2="15"></line>
            </svg>
          </span>
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui.html</p>
            <p class="text-xs text-gray-500 dark:text-neutral-500">7 KB</p>
          </div>
        </div>
        <div class="inline-flex items-center gap-x-2">
          <span class="relative">
            <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
            </svg>
            <span class="sr-only">Success</span>
          </span>
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 6h18"></path>
              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
              <line x1="10" x2="10" y1="11" y2="17"></line>
              <line x1="14" x2="14" y1="11" y2="17"></line>
            </svg>
            <span class="sr-only">Delete</span>
          </button>
        </div>
      </div>
      <!-- End Uploading File Content -->

      <!-- Progress Bar -->
      <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-teal-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 100%"></div>
      </div>
      <!-- End Progress Bar -->
    </div>

    <div>
      <!-- Uploading File Content -->
      <div class="mb-2 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
          <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" x2="12" y1="3" y2="15"></line>
            </svg>
          </span>
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui.mp4</p>
            <p class="text-xs text-gray-500 dark:text-neutral-500">105.5 MB</p>
          </div>
        </div>
        <div class="inline-flex items-center gap-x-2">
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="4" height="16" x="6" y="4"></rect>
              <rect width="4" height="16" x="14" y="4"></rect>
            </svg>
            <span class="sr-only">Pause</span>
          </button>
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 6h18"></path>
              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
              <line x1="10" x2="10" y1="11" y2="17"></line>
              <line x1="14" x2="14" y1="11" y2="17"></line>
            </svg>
            <span class="sr-only">Delete</span>
          </button>
        </div>
      </div>
      <!-- End Uploading File Content -->

      <!-- Progress Bar -->
      <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-red-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 25%"></div>
      </div>
      <!-- End Progress Bar -->
    </div>

    <div>
      <!-- Uploading File Content -->
      <div class="mb-2 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
          <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" x2="12" y1="3" y2="15"></line>
            </svg>
          </span>
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-white">preline-ui-cover.jpg</p>
            <p class="text-xs text-gray-500 dark:text-neutral-500">55 KB</p>
          </div>
        </div>
        <div class="inline-flex items-center gap-x-2">
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="4" height="16" x="6" y="4"></rect>
              <rect width="4" height="16" x="14" y="4"></rect>
            </svg>
            <span class="sr-only">Pause</span>
          </button>
          <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 6h18"></path>
              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
              <line x1="10" x2="10" y1="11" y2="17"></line>
              <line x1="14" x2="14" y1="11" y2="17"></line>
            </svg>
            <span class="sr-only">Delete</span>
          </button>
        </div>
      </div>
      <!-- End Uploading File Content -->

      <!-- Progress Bar -->
      <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-teal-500 text-xs text-white text-center whitespace-nowrap transition duration-500" style="width: 100%"></div>
      </div>
      <!-- End Progress Bar -->
    </div>
  </div>
  <!-- End Body -->

  <!-- Footer -->
  <div class="bg-gray-50 border-t border-gray-200 rounded-b-xl py-2 px-4 md:px-5 dark:bg-white/10 dark:border-neutral-700">
    <div class="flex flex-wrap justify-between items-center gap-x-3">
      <div>
        <span class="text-sm font-semibold text-gray-800 dark:text-white">
          2 success, 1 failed
        </span>
      </div>
      <!-- End Col -->

      <div class="-me-2.5">
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1.5 text-sm font-medium rounded-lg border border-transparent text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="5 3 19 12 5 21 5 3"></polygon>
          </svg>
          Start
        </button>
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1.5 text-sm font-medium rounded-lg border border-transparent text-gray-500 hover:bg-gray-200 hover:text-gray-800 focus:outline-hidden focus:bg-gray-200 focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-white dark:focus:bg-neutral-800 dark:focus:text-white">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 6h18"></path>
            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
            <line x1="10" x2="10" y1="11" y2="17"></line>
            <line x1="14" x2="14" y1="11" y2="17"></line>
          </svg>
          Delete
        </button>
      </div>
      <!-- End Col -->
    </div>
  </div>
  <!-- End Footer -->
</div>
<!-- End File Uploading Progress Form -->

### 12. Listado de Ratings ###

Basic usage
Basic rating example with input.

<!-- Rating -->
<div class="flex flex-row-reverse justify-end items-center">
  <input id="hs-ratings-readonly-1" type="radio" class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="1">
  <label for="hs-ratings-readonly-1" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-neutral-600">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
    </svg>
  </label>
  <input id="hs-ratings-readonly-2" type="radio" class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="2">
  <label for="hs-ratings-readonly-2" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-neutral-600">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
    </svg>
  </label>
  <input id="hs-ratings-readonly-3" type="radio" class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="3">
  <label for="hs-ratings-readonly-3" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-neutral-600">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
    </svg>
  </label>
  <input id="hs-ratings-readonly-4" type="radio" class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="4">
  <label for="hs-ratings-readonly-4" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-neutral-600">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
    </svg>
  </label>
  <input id="hs-ratings-readonly-5" type="radio" class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="5">
  <label for="hs-ratings-readonly-5" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-neutral-600">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
    </svg>
  </label>
</div>
<!-- End Rating -->

Button example
Button example with star shapes.

<!-- Rating -->
<div class="flex items-center">
  <button type="button" class="size-5 inline-flex justify-center items-center text-2xl rounded-full text-yellow-400 disabled:opacity-50 disabled:pointer-events-none dark:text-yellow-500">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
    </svg>
  </button>
  <button type="button" class="size-5 inline-flex justify-center items-center text-2xl rounded-full text-yellow-400 disabled:opacity-50 disabled:pointer-events-none dark:text-yellow-500">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
    </svg>
  </button>
  <button type="button" class="size-5 inline-flex justify-center items-center text-2xl rounded-full text-yellow-400 disabled:opacity-50 disabled:pointer-events-none dark:text-yellow-500">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
    </svg>
  </button>
  <button type="button" class="size-5 inline-flex justify-center items-center text-2xl rounded-full text-yellow-400 disabled:opacity-50 disabled:pointer-events-none dark:text-yellow-500">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
    </svg>
  </button>
  <button type="button" class="size-5 inline-flex justify-center items-center text-2xl rounded-full text-gray-300 hover:text-yellow-400 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-600 dark:hover:text-yellow-500">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
    </svg>
  </button>
</div>
<!-- End Rating -->

Custom symbol with button
Custom symbol heart shapes with button example.

<!-- Rating -->
<div class="flex items-center">
  <button type="button" class="size-5 inline-flex justify-center items-center text-2xl rounded-full text-red-500 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>
    </svg>
  </button>
  <button type="button" class="size-5 inline-flex justify-center items-center text-2xl rounded-full text-red-500 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>
    </svg>
  </button>
  <button type="button" class="size-5 inline-flex justify-center items-center text-2xl rounded-full text-red-500 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>
    </svg>
  </button>
  <button type="button" class="size-5 inline-flex justify-center items-center text-2xl rounded-full text-red-500 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>
    </svg>
  </button>
  <button type="button" class="size-5 inline-flex justify-center items-center text-2xl rounded-full text-gray-300 hover:text-red-500 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-600 dark:hover:text-red-500">
    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>
    </svg>
  </button>
</div>
<!-- End Rating -->

Static example

<!-- Rating -->
<div class="flex items-center">
  <svg class="shrink-0 size-5 text-yellow-400 dark:text-yellow-600" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
  </svg>
  <svg class="shrink-0 size-5 text-yellow-400 dark:text-yellow-600" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
  </svg>
  <svg class="shrink-0 size-5 text-yellow-400 dark:text-yellow-600" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
  </svg>
  <svg class="shrink-0 size-5 text-gray-300 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
  </svg>
  <svg class="shrink-0 size-5 text-gray-300 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
  </svg>
</div>
<!-- End Rating -->

Rate with emoji

<!-- Rate review -->
<div class="text-center">
  <h3 class="text-gray-800 dark:text-white">
    Did this answer your question?
  </h3>

  <!-- Rating -->
  <div class="mt-2 flex justify-center items-center">
    <button type="button" class="size-10 inline-flex justify-center items-center text-2xl rounded-full hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
      😔
    </button>
    <button type="button" class="size-10 inline-flex justify-center items-center text-2xl rounded-full hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
      😐️
    </button>
    <button type="button" class="size-10 inline-flex justify-center items-center text-2xl rounded-full hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
      🤩
    </button>
  </div>
  <!-- End Rating -->
</div>
<!-- End Rate review -->

Rate with thumb buttons

<!-- Rating -->
<div class="mt-2 flex justify-center items-center gap-x-2">
  <h3 class="text-gray-800 dark:text-white">
    Was this page helpful?
  </h3>
  <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M7 10v12"></path>
      <path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2h0a3.13 3.13 0 0 1 3 3.88Z"></path>
    </svg>
    Yes
  </button>
  <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M17 14V2"></path>
      <path d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22h0a3.13 3.13 0 0 1-3-3.88Z"></path>
    </svg>
    No
  </button>
</div>
<!-- End Rating -->


### 13. Listado de Spinners (Loaders) ###

Example
A simple loading status.

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

Color variants
Predefined spinner color styles.

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-gray-800 rounded-full dark:text-white" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-gray-400 rounded-full" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-red-600 rounded-full" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-yellow-600 rounded-full" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-green-600 rounded-full" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-indigo-600 rounded-full" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-purple-600 rounded-full" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-pink-600 rounded-full" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-orange-600 rounded-full" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

Sizes
A small size is good for loading text, default sized spin for loading a card-level block, and large spin used for loading a page.

<div class="animate-spin inline-block size-4 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

<div class="animate-spin inline-block size-8 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status" aria-label="loading">
  <span class="sr-only">Loading...</span>
</div>

Inside a card
Spin in a card.

<div class="min-h-60 flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
  <div class="flex flex-auto flex-col justify-center items-center p-4 md:p-5">
    <div class="flex justify-center">
      <div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status" aria-label="loading">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
</div>

Customized description
Customized description content.

<div class="relative">
  <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex">
      <div class="shrink-0">
        <svg class="shrink-0 size-4 text-blue-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
          <path d="M12 9v4"></path>
          <path d="M12 17h.01"></path>
        </svg>
      </div>
      <div class="ms-3">
        <h3 class="text-sm text-blue-800 font-medium">
          Attention needed
        </h3>
        <div class="text-sm text-blue-700 mt-2">
          <span class="font-semibold">Holy guacamole!</span> You should check in on some of those fields below.
        </div>
      </div>
    </div>
  </div>

  <div class="absolute top-0 start-0 size-full bg-white/50 rounded-lg dark:bg-neutral-800/40"></div>

  <div class="absolute top-1/2 start-1/2 transform -translate-x-1/2 -translate-y-1/2">
    <div class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status" aria-label="loading">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</div>

### 14. Listado de Toasts ###

Example
A basic form of the toasts.

<div class="space-y-3">
  <!-- Toast -->
  <div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-normal-example-label">
    <div class="flex p-4">
      <div class="shrink-0">
        <svg class="shrink-0 size-4 text-blue-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
        </svg>
      </div>
      <div class="ms-3">
        <p id="hs-toast-normal-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
          This is a normal message.
        </p>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-success-example-label">
    <div class="flex p-4">
      <div class="shrink-0">
        <svg class="shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
        </svg>
      </div>
      <div class="ms-3">
        <p id="hs-toast-success-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
          This is a success message.
        </p>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-error-example-label">
    <div class="flex p-4">
      <div class="shrink-0">
        <svg class="shrink-0 size-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
        </svg>
      </div>
      <div class="ms-3">
        <p id="hs-toast-error-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
          This is an error message.
        </p>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-warning-example-label">
    <div class="flex p-4">
      <div class="shrink-0">
        <svg class="shrink-0 size-4 text-yellow-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
        </svg>
      </div>
      <div class="ms-3">
        <p id="hs-toast-warning-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
          This is a warning message.
        </p>
      </div>
    </div>
  </div>
  <!-- End Toast -->
</div>

Condensed
Vertically stacking multiple toasts in a readable manner.

<!-- Toast -->
<div class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-condensed-label">
  <div class="flex p-4">
    <p id="hs-toast-condensed-label" class="text-sm text-gray-700 dark:text-neutral-400">
      Your email has been sent
    </p>

    <div class="ms-auto flex items-center space-x-3">
      <button type="button" class="text-blue-600 decoration-2 hover:underline font-medium text-sm focus:outline-hidden focus:underline dark:text-blue-500">
        Undo
      </button>
      <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-white" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"></path>
          <path d="m6 6 12 12"></path>
        </svg>
      </button>
    </div>
  </div>
</div>
<!-- End Toast -->

Solid color variants
The default form of solid color toasts

<div class="space-y-3">
  <!-- Toast -->
  <div class="max-w-xs bg-gray-800 text-sm text-white rounded-xl shadow-lg dark:bg-neutral-900" role="alert" tabindex="-1" aria-labelledby="hs-toast-solid-color-dark-label">
    <div id="hs-toast-solid-color-dark-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-white hover:text-white opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-gray-500 text-sm text-white rounded-xl shadow-lg dark:bg-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-solid-color-gray-label">
    <div id="hs-toast-solid-color-gray-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-white hover:text-white opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-teal-500 text-sm text-white rounded-xl shadow-lg" role="alert" tabindex="-1" aria-labelledby="hs-toast-solid-color-teal-label">
    <div id="hs-toast-solid-color-teal-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-white hover:text-white opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-blue-500 text-sm text-white rounded-xl shadow-lg" role="alert" tabindex="-1" aria-labelledby="hs-toast-solid-color-blue-label">
    <div id="hs-toast-solid-color-blue-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-white hover:text-white opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-red-500 text-sm text-white rounded-xl shadow-lg" role="alert" tabindex="-1" aria-labelledby="hs-toast-solid-color-red-label">
    <div id="hs-toast-solid-color-red-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-white hover:text-white opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-yellow-500 text-sm text-white rounded-xl shadow-lg" role="alert" tabindex="-1" aria-labelledby="hs-toast-solid-color-yellow-label">
    <div id="hs-toast-solid-color-yellow-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-white hover:text-white opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->
</div>

Soft color variants
The default form of soft color toasts.

<div class="space-y-3">
  <!-- Toast -->
  <div class="max-w-xs bg-gray-100 border border-gray-200 text-sm text-gray-800 rounded-lg dark:bg-white/10 dark:border-white/20 dark:text-white" role="alert" tabindex="-1" aria-labelledby="hs-toast-soft-color-dark-label">
    <div id="hs-toast-soft-color-dark-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-white" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-gray-50 border border-gray-200 text-sm text-gray-600 rounded-lg dark:bg-white/10 dark:border-white/10 dark:text-neutral-400" role="alert" tabindex="-1" aria-labelledby="hs-toast-soft-color-gray-label">
    <div id="hs-toast-soft-color-gray-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-white" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-teal-100 border border-teal-200 text-sm text-teal-800 rounded-lg dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500" role="alert" tabindex="-1" aria-labelledby="hs-toast-soft-color-teal-label">
    <div id="hs-toast-soft-color-teal-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-teal-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-teal-200" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-blue-100 border border-blue-200 text-sm text-blue-800 rounded-lg dark:bg-blue-800/10 dark:border-blue-900 dark:text-blue-500" role="alert" tabindex="-1" aria-labelledby="hs-toast-soft-color-blue-label">
    <div id="hs-toast-soft-color-blue-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-blue-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-blue-200" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert" tabindex="-1" aria-labelledby="hs-toast-soft-color-red-label">
    <div id="hs-toast-soft-color-red-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-red-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-red-200" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-yellow-100 border border-yellow-200 text-sm text-yellow-800 rounded-lg dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500" role="alert" tabindex="-1" aria-labelledby="hs-toast-soft-color-yellow-label">
    <div id="hs-toast-soft-color-yellow-label" class="flex p-4">
      Hello, world! This is a toast message.

      <div class="ms-auto">
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-yellow-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-yellow-200" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- End Toast -->
</div>

Message with loading indicator
Display a global loading indicator, which is dismissed by itself asynchronously.

<!-- Toast -->
<div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-message-with-loading-indicator-label">
  <div class="flex items-center p-4">
    <div class="animate-spin inline-block size-4 border-3 border-current border-t-transparent text-blue-600 rounded-full" role="status" aria-label="loading">
      <span class="sr-only">Loading...</span>
    </div>
    <p id="hs-toast-message-with-loading-indicator-label" class="ms-3 text-sm text-gray-700 dark:text-neutral-400">
      Action in progress
    </p>
  </div>
</div>
<!-- End Toast -->

With actions
Add additional controls and components to toasts.

<!-- Toast -->
<div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-with-icons-label">
  <div class="flex p-4">
    <div class="shrink-0">
      <svg class="size-5 text-gray-600 mt-1 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
      </svg>
    </div>
    <div class="ms-4">
      <h3 id="hs-toast-with-icons-label" class="text-gray-800 font-semibold dark:text-white">
        App notifications
      </h3>
      <div class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        Notifications may include alerts, sounds and icon badges.
      </div>
      <div class="mt-4">
        <div class="flex gap-x-3">
          <button type="button" class="text-blue-600 decoration-2 hover:underline font-medium text-sm focus:outline-hidden focus:underline dark:text-blue-500">
            Don't allow
          </button>
          <button type="button" class="text-blue-600 decoration-2 hover:underline font-medium text-sm focus:outline-hidden focus:underline dark:text-blue-500">
            Allow
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Toast -->

Stack
Vertically stacking multiple toasts in a readable manner.

<div class="space-y-3">
  <!-- Toast -->
  <div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-stack-toggle-label">
    <div class="flex p-4">
      <div class="shrink-0">
        <svg class="size-5 text-gray-600 mt-1 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
          <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
        </svg>
      </div>
      <div class="ms-4">
        <h3 id="hs-toast-stack-toggle-label" class="text-gray-800 font-semibold dark:text-white">
          App notifications
        </h3>
        <div class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
          Notifications may include alerts, sounds and icon badges.
        </div>
        <div class="mt-4">
          <div class="flex gap-x-3">
            <button type="button" class="text-blue-600 decoration-2 hover:underline font-medium text-sm focus:outline-hidden focus:underline dark:text-blue-500">
              Don't allow
            </button>
            <button type="button" class="text-blue-600 decoration-2 hover:underline font-medium text-sm focus:outline-hidden focus:underline dark:text-blue-500">
              Allow
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Toast -->

  <!-- Toast -->
  <div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-stack-toggle-update-label">
    <div class="flex p-4">
      <div class="shrink-0">
        <svg class="shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
        </svg>
      </div>
      <div class="ms-3">
        <p id="hs-toast-stack-toggle-update-label" class="text-sm text-gray-700 dark:text-neutral-400">
          Your app preferences has been successfully updated.
        </p>
      </div>
    </div>
  </div>
  <!-- End Toast -->
</div>

Progress
You can also add additional elements, such as an icon and a progress bar.

<!-- Toast -->
<div class="max-w-xs relative bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-progress-label">
  <div class="flex gap-x-3 p-4">
    <div class="shrink-0">
      <!-- Icon -->
      <span class="m-1 inline-flex justify-center items-center size-8 rounded-full bg-gray-100 text-gray-800 dark:bg-neutral-700 dark:text-neutral-200">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path>
          <path d="M12 12v9"></path>
          <path d="m16 16-4-4-4 4"></path>
        </svg>
      </span>
      <!-- End Icon -->

      <button type="button" class="absolute top-3 end-3 inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-white" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"></path>
          <path d="m6 6 12 12"></path>
        </svg>
      </button>
    </div>

    <div class="grow me-5">
      <h3 id="hs-toast-progress-label" class="text-gray-800 font-medium text-sm dark:text-white">
        Uploading 3 files
      </h3>

      <!-- Progress -->
      <div class="mt-2 flex flex-col gap-x-3">
        <span class="block mb-1.5 text-xs text-gray-500 dark:text-neutral-400">57% · 5 seconds left</span>
        <div class="flex w-full h-1 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100">
          <div class="flex flex-col justify-center overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap dark:bg-neutral-200" style="width: 57%"></div>
        </div>
      </div>
      <!-- End Progress -->
    </div>
  </div>
</div>
<!-- End Toast -->

Placement
Display a notification message at any place of the viewport.

<!-- Toast -->
<div class="absolute top-0 start-0">
  <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-placement-top-left-label">
    <div class="p-2 sm:p-4">
      <h3 id="hs-toast-placement-top-left-label" class="text-xs text-gray-800 font-semibold sm:text-base dark:text-white">
        Top left
      </h3>
    </div>
  </div>
</div>
<!-- End Toast -->

<!-- Toast -->
<div class="absolute top-0 start-1/2 -translate-x-1/2">
  <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-placement-top-center-label">
    <div class="p-2 sm:p-4">
      <h3 id="hs-toast-placement-top-center-label" class="text-xs text-gray-800 font-semibold sm:text-base dark:text-white">
        Top center
      </h3>
    </div>
  </div>
</div>
<!-- End Toast -->

<!-- Toast -->
<div class="absolute top-0 end-0">
  <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-placement-top-right-label">
    <div class="p-2 sm:p-4">
      <h3 id="hs-toast-placement-top-right-label" class="text-xs text-gray-800 font-semibold sm:text-base dark:text-white">
        Top right
      </h3>
    </div>
  </div>
</div>
<!-- End Toast -->

<!-- Toast -->
<div class="absolute top-1/2 start-1/2 transform -translate-y-1/2 -translate-x-1/2">
  <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-placement-Center-label">
    <div class="p-2 sm:p-4">
      <h3 id="hs-toast-placement-Center-label" class="text-xs text-gray-800 font-semibold sm:text-base dark:text-white">
        Center
      </h3>
    </div>
  </div>
</div>
<!-- End Toast -->

<!-- Toast -->
<div class="absolute bottom-0 start-0">
  <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-placement-bottom-left-label">
    <div class="p-2 sm:p-4">
      <h3 id="hs-toast-placement-bottom-left-label" class="text-xs text-gray-800 font-semibold sm:text-base dark:text-white">
        Bottom left
      </h3>
    </div>
  </div>
</div>
<!-- End Toast -->

<!-- Toast -->
<div class="absolute bottom-0 start-1/2 -translate-x-1/2">
  <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-placement-bottom-center-label">
    <div class="p-2 sm:p-4">
      <h3 id="hs-toast-placement-bottom-center-label" class="text-xs text-gray-800 font-semibold sm:text-base dark:text-white">
        Bottom center
      </h3>
    </div>
  </div>
</div>
<!-- End Toast -->

<!-- Toast -->
<div class="absolute bottom-0 end-0">
  <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-placement-bottom-right-label">
    <div class="p-2 sm:p-4">
      <h3 id="hs-toast-placement-bottom-right-label" class="text-xs text-gray-800 font-semibold sm:text-base dark:text-white">
        Bottom right
      </h3>
    </div>
  </div>
</div>
<!-- End Toast -->

Dismiss button
Requires JS
Note that this component requires the use of our Remove Element plugin, else you can skip this message if you are already using Preline UI as a package.

Use dismiss-alert to dismiss a content.

<!-- Toast -->
<div id="dismiss-toast" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-dismiss-button-label">
  <div class="flex p-4">
    <p id="hs-toast-dismiss-button-label" class="text-sm text-gray-700 dark:text-neutral-400">
      Your email has been sent
    </p>

    <div class="ms-auto">
      <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-white" aria-label="Close" data-hs-remove-element="#dismiss-toast">
        <span class="sr-only">Close</span>
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"></path>
          <path d="m6 6 12 12"></path>
        </svg>
      </button>
    </div>
  </div>
</div>
<!-- End Toast -->

JavaScript Behavior New
Requires Additional Installation
Note that this feature requires the use of the third-party Toastify plugin.
Use Toastify to create dynamic toasts.

<button id="hs-new-toast" type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
  Call toast
</button>

### 15. Listado de Timeline ###

With time
With time on the left side.

<!-- Timeline -->
<div>
  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Left Content -->
    <div class="min-w-14 text-end">
      <span class="text-xs text-gray-500 dark:text-neutral-400">12:05PM</span>
    </div>
    <!-- End Left Content -->

    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        <svg class="shrink-0 size-4 mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
          <polyline points="14 2 14 8 20 8"></polyline>
          <line x1="16" x2="8" y1="13" y2="13"></line>
          <line x1="16" x2="8" y1="17" y2="17"></line>
          <line x1="10" x2="8" y1="9" y2="9"></line>
        </svg>
        Created "Preline in React" task
      </h3>
      <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        Find more detailed insctructions here.
      </p>
      <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <img class="shrink-0 size-4 rounded-full" src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8auto=format&fit=facearea&facepad=3&w=320&h=320&q=80" alt="Avatar">
        James Collins
      </button>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Left Content -->
    <div class="min-w-14 text-end">
      <span class="text-xs text-gray-500 dark:text-neutral-400">12:05PM</span>
    </div>
    <!-- End Left Content -->

    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        Release v5.2.0 quick bug fix 🐞
      </h3>
      <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <span class="flex shrink-0 justify-center items-center size-4 bg-white border border-gray-200 text-[10px] font-semibold uppercase text-gray-600 rounded-full dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
          A
        </span>
        Alex Gregarov
      </button>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Left Content -->
    <div class="min-w-14 text-end">
      <span class="text-xs text-gray-500 dark:text-neutral-400">12:05PM</span>
    </div>
    <!-- End Left Content -->

    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        Marked "Install Charts" completed
      </h3>
      <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        Finally! You can check it out here.
      </p>
      <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <img class="shrink-0 size-4 rounded-full" src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80" alt="Avatar">
        James Collins
      </button>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Left Content -->
    <div class="min-w-14 text-end">
      <span class="text-xs text-gray-500 dark:text-neutral-400">12:05PM</span>
    </div>
    <!-- End Left Content -->

    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        Take a break ⛳️
      </h3>
      <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        Just chill for now... 😉
      </p>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->
</div>
<!-- End Timeline -->

Collapsable
Collapsable timeline to hide/show more contents.

<!-- Timeline -->
<div>
  <!-- Heading -->
  <div class="ps-2 my-2 first:mt-0">
    <h3 class="text-xs font-medium uppercase text-gray-500 dark:text-neutral-400">
      1 Aug, 2023
    </h3>
  </div>
  <!-- End Heading -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        <svg class="shrink-0 size-4 mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
          <polyline points="14 2 14 8 20 8"></polyline>
          <line x1="16" x2="8" y1="13" y2="13"></line>
          <line x1="16" x2="8" y1="17" y2="17"></line>
          <line x1="10" x2="8" y1="9" y2="9"></line>
        </svg>
        Created "Preline in React" task
      </h3>
      <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        Find more detailed insctructions here.
      </p>
      <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <img class="shrink-0 size-4 rounded-full" src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8auto=format&fit=facearea&facepad=3&w=320&h=320&q=80" alt="Avatar">
        James Collins
      </button>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        Release v5.2.0 quick bug fix 🐞
      </h3>
      <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <span class="flex shrink-0 justify-center items-center size-4 bg-white border border-gray-200 text-[10px] font-semibold uppercase text-gray-600 rounded-full dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
          A
        </span>
        Alex Gregarov
      </button>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        Marked "Install Charts" completed
      </h3>
      <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        Finally! You can check it out here.
      </p>
      <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <img class="shrink-0 size-4 rounded-full" src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80" alt="Avatar">
        James Collins
      </button>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->

  <!-- Heading -->
  <div class="ps-2 my-2 first:mt-0">
    <h3 class="text-xs font-medium uppercase text-gray-500 dark:text-neutral-400">
      31 Jul, 2023
    </h3>
  </div>
  <!-- End Heading -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        Take a break ⛳️
      </h3>
      <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        Just chill for now... 😉
      </p>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->

  <!-- Collapse -->
  <div id="hs-timeline-collapse" class="hs-collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="hs-timeline-collapse-content">
    <!-- Heading -->
    <div class="ps-2 my-2">
      <h3 class="text-xs font-medium uppercase text-gray-500 dark:text-neutral-400">
        30 Jul, 2023
      </h3>
    </div>
    <!-- End Heading -->

    <!-- Item -->
    <div class="flex gap-x-3">
      <!-- Icon -->
      <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
        <div class="relative z-10 size-7 flex justify-center items-center">
          <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
        </div>
      </div>
      <!-- End Icon -->

      <!-- Right Content -->
      <div class="grow pt-0.5 pb-8">
        <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
          Final touch ups
        </h3>
        <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
          Double check everything and make sure we're ready to go.
        </p>
      </div>
      <!-- End Right Content -->
    </div>
    <!-- End Item -->
  </div>
  <!-- End Collapse -->

  <!-- Item -->
  <div class="ps-2 -ms-px flex gap-x-3">
    <button type="button" class="hs-collapse-toggle hs-collapse-open:hidden text-start inline-flex items-center gap-x-1 text-sm text-blue-600 font-medium decoration-2 hover:underline focus:outline-hidden focus:underline dark:text-blue-500" id="hs-timeline-collapse-content" aria-expanded="false" aria-controls="hs-timeline-collapse" data-hs-collapse="#hs-timeline-collapse">
      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m6 9 6 6 6-6"></path>
      </svg>
      Show older
    </button>
  </div>
  <!-- End Item -->
</div>
<!-- End Timeline -->

Icons and avatars
You can also add additional elements, such as icons and avatars.

<!-- Timeline -->
<div>
  <!-- Heading -->
  <div class="ps-2 my-2 first:mt-0">
    <h3 class="text-xs font-medium uppercase text-gray-500 dark:text-neutral-400">
      1 Aug, 2023
    </h3>
  </div>
  <!-- End Heading -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <img class="shrink-0 size-7 rounded-full" src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80" alt="Avatar">
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        <svg class="shrink-0 size-4 mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
          <polyline points="14 2 14 8 20 8"></polyline>
          <line x1="16" x2="8" y1="13" y2="13"></line>
          <line x1="16" x2="8" y1="17" y2="17"></line>
          <line x1="10" x2="8" y1="9" y2="9"></line>
        </svg>
        Created "Preline in React" task
      </h3>
      <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        Find more detailed insctructions here.
      </p>
      <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <img class="shrink-0 size-4 rounded-full" src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8auto=format&fit=facearea&facepad=3&w=320&h=320&q=80" alt="Avatar">
        James Collins
      </button>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <span class="flex shrink-0 justify-center items-center size-7 border border-gray-200 text-sm font-semibold uppercase text-gray-800 rounded-full dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
          A
        </span>
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        Release v5.2.0 quick bug fix 🐞
      </h3>
      <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <span class="flex shrink-0 justify-center items-center size-4 bg-white border border-gray-200 text-[10px] font-semibold uppercase text-gray-600 rounded-full dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
          A
        </span>
        Alex Gregarov
      </button>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <img class="shrink-0 size-7 rounded-full" src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80" alt="Avatar">
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        Marked "Install Charts" completed
      </h3>
      <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        Finally! You can check it out here.
      </p>
      <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <img class="shrink-0 size-4 rounded-full" src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80" alt="Avatar">
        James Collins
      </button>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->

  <!-- Heading -->
  <div class="ps-2 my-2 first:mt-0">
    <h3 class="text-xs font-medium uppercase text-gray-500 dark:text-neutral-400">
      31 Jul, 2023
    </h3>
  </div>
  <!-- End Heading -->

  <!-- Item -->
  <div class="flex gap-x-3">
    <!-- Icon -->
    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
      <div class="relative z-10 size-7 flex justify-center items-center">
        <span class="flex shrink-0 justify-center items-center size-7 bg-white border border-gray-200 text-[10px] font-semibold uppercase text-gray-600 rounded-full dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
          <svg class="shrink-0 size-4 mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 3h5v5"></path>
            <path d="M8 3H3v5"></path>
            <path d="M12 22v-8.3a4 4 0 0 0-1.172-2.872L3 3"></path>
            <path d="m15 9 6-6"></path>
          </svg>
        </span>
      </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 pb-8">
      <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
        Take a break ⛳️
      </h3>
      <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        Just chill for now... 😉
      </p>
    </div>
    <!-- End Right Content -->
  </div>
  <!-- End Item -->
</div>
<!-- End Timeline -->