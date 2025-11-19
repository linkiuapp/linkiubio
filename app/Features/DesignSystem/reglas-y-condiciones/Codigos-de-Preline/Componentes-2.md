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


### 16. Listado de Navs ###

**Reglas aplicadas:**
- ✅ Textos en español
- ✅ Sin clases `dark:`
- ✅ Iconos Lucide (reemplazando SVG)
- ✅ Resto de clases Preline exactas (incluyendo `hover:text-blue-70`, `focus:outline-hidden`, etc.)

Example
The base nav component is built with flexbox and provide a strong foundation for building all types of navigation components.

<nav class="flex gap-x-6">
  <a class="inline-flex items-center gap-x-2 text-sm whitespace-nowrap text-blue-600 hover:text-blue-70 focus:outline-hidden focus:text-blue-700 dark:text-blue-500 dark:focus:text-blue-400" href="#">
    Link
  </a>
  <a class="inline-flex items-center gap-x-2 text-sm font-semibold whitespace-nowrap text-blue-600 hover:text-blue-70 focus:outline-hidden focus:text-blue-700 dark:text-blue-500 dark:focus:text-blue-400" href="#" aria-current="page">
    Active
  </a>
  <a class="inline-flex items-center gap-x-2 text-sm whitespace-nowrap text-blue-600 hover:text-blue-70 focus:outline-hidden focus:text-blue-700 dark:text-blue-500 dark:focus:text-blue-400" href="#">
    Link
  </a>
  <a class="inline-flex items-center gap-x-2 text-sm whitespace-nowrap text-blue-600 hover:text-blue-70 focus:outline-hidden focus:text-blue-700 opacity-50 pointer-events-none dark:text-blue-500 dark:focus:text-blue-400" href="#">
    Disabled
  </a>
</nav>

Segment
Another type of Tabs with segment.

Preview
HTML

<div class="flex">
  <div class="flex bg-gray-100 hover:bg-gray-200 rounded-lg transition p-1 dark:bg-neutral-700 dark:hover:bg-neutral-600">
    <nav class="flex gap-x-2">
      <a class="py-3 px-4 inline-flex items-center gap-2 bg-white text-sm text-gray-700 font-medium rounded-lg shadow-2xs focus:outline-hidden dark:bg-neutral-800 dark:text-neutral-400" href="#" aria-current="page">
        Active
      </a>
      <a class="py-3 px-4 inline-flex items-center gap-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 font-medium rounded-lg hover:hover:text-blue-600 focus:outline-hidden focus:hover:text-blue-600 dark:text-neutral-400 dark:focus:text-white" href="#">
        Link
      </a>
      <a class="py-3 px-4 inline-flex items-center gap-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 font-medium rounded-lg hover:hover:text-blue-600 focus:outline-hidden focus:hover:text-blue-600 dark:text-neutral-400 dark:focus:text-white" href="#">
        Link
      </a>
      <a class="py-3 px-4 inline-flex items-center gap-2 bg-transparent text-sm text-gray-400 font-medium rounded-lg pointer-events-none focus:outline-hidden dark:text-neutral-400 dark:hover:text-white dark:focus:text-white" href="#">
        Disabled
      </a>
    </nav>
  </div>
</div>

With badges
Simple example with badges.

<div class="border-b-2 border-gray-200 dark:border-neutral-700">
  <nav class="-mb-0.5 flex gap-x-6">
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      Tab 1 <span class="ms-1 py-0.5 px-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-neutral-700 dark:text-neutral-300">99+</span>
    </a>
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-blue-500 text-sm font-medium whitespace-nowrap text-blue-600 focus:outline-hidden focus:text-blue-800 dark:text-blue-500" href="#" aria-current="page">
      Tab 2 <span class="ms-1 py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-600 dark:bg-blue-500 dark:text-white">99+</span>
    </a>
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      Tab 3
    </a>
  </nav>
</div>

With icons
Contained tabs with icons.

<div class="border-b-2 border-gray-200 dark:border-neutral-700">
  <nav class="-mb-0.5 flex gap-x-6">
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        <polyline points="9 22 9 12 15 12 15 22"></polyline>
      </svg>
      Tab 1
    </a>
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-blue-500 text-sm font-medium whitespace-nowrap text-blue-600 focus:outline-hidden focus:text-blue-800 dark:text-blue-500" href="#" aria-current="page">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <circle cx="12" cy="10" r="3"></circle>
        <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>
      </svg>
      Tab 2
    </a>
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
        <circle cx="12" cy="12" r="3"></circle>
      </svg>
      Tab 3
    </a>
  </nav>
</div>

Tabs with underline
A basic form of tabs with underline.

<div class="border-b-2 border-gray-200 dark:border-neutral-700">
  <nav class="-mb-0.5 flex gap-x-6">
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500 active" href="#" aria-current="page">
      Tab 1
    </a>
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      Tab 2
    </a>
    <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      Tab 3
    </a>
  </nav>
</div>

### 17. Listado de tabs ###

Pills with brand color
Another type of Tabs with pills.

<nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
  <button type="button" class="hs-tab-active:bg-blue-600 hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active:dark:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-neutral-300 active" id="pills-with-brand-color-item-1" aria-selected="true" data-hs-tab="#pills-with-brand-color-1" aria-controls="pills-with-brand-color-1" role="tab">
    Tab 1
  </button>
  <button type="button" class="hs-tab-active:bg-blue-600 hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active:dark:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-neutral-300" id="pills-with-brand-color-item-2" aria-selected="false" data-hs-tab="#pills-with-brand-color-2" aria-controls="pills-with-brand-color-2" role="tab">
    Tab 2
  </button>
  <button type="button" class="hs-tab-active:bg-blue-600 hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active:dark:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-neutral-300" id="pills-with-brand-color-item-3" aria-selected="false" data-hs-tab="#pills-with-brand-color-3" aria-controls="pills-with-brand-color-3" role="tab">
    Tab 3
  </button>
</nav>

<div class="mt-3">
  <div id="pills-with-brand-color-1" role="tabpanel" aria-labelledby="pills-with-brand-color-item-1">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">first</em> item's tab body.
    </p>
  </div>
  <div id="pills-with-brand-color-2" class="hidden" role="tabpanel" aria-labelledby="pills-with-brand-color-item-2">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">second</em> item's tab body.
    </p>
  </div>
  <div id="pills-with-brand-color-3" class="hidden" role="tabpanel" aria-labelledby="pills-with-brand-color-item-3">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">third</em> item's tab body.
    </p>
  </div>
</div>

Pills on gray color
Another type of Tabs with pills on gray colo

<nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
  <button type="button" class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400 active" id="pills-on-gray-color-item-1" aria-selected="true" data-hs-tab="#pills-on-gray-color-1" aria-controls="pills-on-gray-color-1" role="tab">
    Tab 1
  </button>
  <button type="button" class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400" id="pills-on-gray-color-item-2" aria-selected="false" data-hs-tab="#pills-on-gray-color-2" aria-controls="pills-on-gray-color-2" role="tab">
    Tab 2
  </button>
  <button type="button" class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400" id="pills-on-gray-color-item-3" aria-selected="false" data-hs-tab="#pills-on-gray-color-3" aria-controls="pills-on-gray-color-3" role="tab">
    Tab 3
  </button>
</nav>

<div class="mt-3">
  <div id="pills-on-gray-color-1" role="tabpanel" aria-labelledby="pills-on-gray-color-item-1">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">first</em> item's tab body.
    </p>
  </div>
  <div id="pills-on-gray-color-2" class="hidden" role="tabpanel" aria-labelledby="pills-on-gray-color-item-2">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">second</em> item's tab body.
    </p>
  </div>
  <div id="pills-on-gray-color-3" class="hidden" role="tabpanel" aria-labelledby="pills-on-gray-color-item-3">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">third</em> item's tab body.
    </p>
  </div>
</div><nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
  <button type="button" class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400 active" id="pills-on-gray-color-item-1" aria-selected="true" data-hs-tab="#pills-on-gray-color-1" aria-controls="pills-on-gray-color-1" role="tab">
    Tab 1
  </button>
  <button type="button" class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400" id="pills-on-gray-color-item-2" aria-selected="false" data-hs-tab="#pills-on-gray-color-2" aria-controls="pills-on-gray-color-2" role="tab">
    Tab 2
  </button>
  <button type="button" class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400" id="pills-on-gray-color-item-3" aria-selected="false" data-hs-tab="#pills-on-gray-color-3" aria-controls="pills-on-gray-color-3" role="tab">
    Tab 3
  </button>
</nav>

<div class="mt-3">
  <div id="pills-on-gray-color-1" role="tabpanel" aria-labelledby="pills-on-gray-color-item-1">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">first</em> item's tab body.
    </p>
  </div>
  <div id="pills-on-gray-color-2" class="hidden" role="tabpanel" aria-labelledby="pills-on-gray-color-item-2">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">second</em> item's tab body.
    </p>
  </div>
  <div id="pills-on-gray-color-3" class="hidden" role="tabpanel" aria-labelledby="pills-on-gray-color-item-3">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">third</em> item's tab body.
    </p>
  </div>
</div>

Bar with underline
Another type of Tabs with underlined bar.

<nav class="relative z-0 flex border border-gray-200 rounded-xl overflow-hidden dark:border-neutral-700" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
  <button type="button" class="hs-tab-active:border-b-blue-600 hs-tab-active:text-gray-900 dark:hs-tab-active:text-white relative dark:hs-tab-active:border-b-blue-600 min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 border-gray-200 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-l-neutral-700 dark:border-b-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-400 active" id="bar-with-underline-item-1" aria-selected="true" data-hs-tab="#bar-with-underline-1" aria-controls="bar-with-underline-1" role="tab">
    Tab 1
  </button>
  <button type="button" class="hs-tab-active:border-b-blue-600 hs-tab-active:text-gray-900 dark:hs-tab-active:text-white relative dark:hs-tab-active:border-b-blue-600 min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 border-gray-200 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-l-neutral-700 dark:border-b-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-400" id="bar-with-underline-item-2" aria-selected="false" data-hs-tab="#bar-with-underline-2" aria-controls="bar-with-underline-2" role="tab">
    Tab 2
  </button>
  <button type="button" class="hs-tab-active:border-b-blue-600 hs-tab-active:text-gray-900 dark:hs-tab-active:text-white relative dark:hs-tab-active:border-b-blue-600 min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 border-gray-200 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-l-neutral-700 dark:border-b-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-400" id="bar-with-underline-item-3" aria-selected="false" data-hs-tab="#bar-with-underline-3" aria-controls="bar-with-underline-3" role="tab">
    Tab 3
  </button>
</nav>

<div class="mt-3">
  <div id="bar-with-underline-1" role="tabpanel" aria-labelledby="bar-with-underline-item-1">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">first</em> item's tab body.
    </p>
  </div>
  <div id="bar-with-underline-2" class="hidden" role="tabpanel" aria-labelledby="bar-with-underline-item-2">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">second</em> item's tab body.
    </p>
  </div>
  <div id="bar-with-underline-3" class="hidden" role="tabpanel" aria-labelledby="bar-with-underline-item-3">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">third</em> item's tab body.
    </p>
  </div>
</div>

Segment
Another type of Tabs with segment.

<div class="flex">
  <div class="flex bg-gray-100 hover:bg-gray-200 rounded-lg transition p-1 dark:bg-neutral-700 dark:hover:bg-neutral-600">
    <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
      <button type="button" class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active:dark:bg-neutral-800 hs-tab-active:dark:text-neutral-400 dark:hs-tab-active:bg-gray-800 py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-hidden focus:text-gray-700 font-medium rounded-lg hover:hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white active" id="segment-item-1" aria-selected="true" data-hs-tab="#segment-1" aria-controls="segment-1" role="tab">
        Tab 1
      </button>
      <button type="button" class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active:dark:bg-neutral-800 hs-tab-active:dark:text-neutral-400 dark:hs-tab-active:bg-gray-800 py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-hidden focus:text-gray-700 font-medium rounded-lg hover:hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white" id="segment-item-2" aria-selected="false" data-hs-tab="#segment-2" aria-controls="segment-2" role="tab">
        Tab 2
      </button>
      <button type="button" class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active:dark:bg-neutral-800 hs-tab-active:dark:text-neutral-400 dark:hs-tab-active:bg-gray-800 py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-hidden focus:text-gray-700 font-medium rounded-lg hover:hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white" id="segment-item-3" aria-selected="false" data-hs-tab="#segment-3" aria-controls="segment-3" role="tab">
        Tab 3
      </button>
    </nav>
  </div>
</div>

<div class="mt-3">
  <div id="segment-1" role="tabpanel" aria-labelledby="segment-item-1">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">first</em> item's tab body.
    </p>
  </div>
  <div id="segment-2" class="hidden" role="tabpanel" aria-labelledby="segment-item-2">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">second</em> item's tab body.
    </p>
  </div>
  <div id="segment-3" class="hidden" role="tabpanel" aria-labelledby="segment-item-3">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">third</em> item's tab body.
    </p>
  </div>
</div>

Card type tab
Another type of Tabs.

<div class="border-b border-gray-200 dark:border-neutral-700">
  <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
    <button type="button" class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-800 dark:hs-tab-active:border-b-gray-800 dark:hs-tab-active:text-white -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200 active" id="card-type-tab-item-1" aria-selected="true" data-hs-tab="#card-type-tab-preview" aria-controls="card-type-tab-preview" role="tab">
      Tab 1
    </button>
    <button type="button" class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-800 dark:hs-tab-active:border-b-gray-800 dark:hs-tab-active:text-white -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200" id="card-type-tab-item-2" aria-selected="false" data-hs-tab="#card-type-tab-2" aria-controls="card-type-tab-2" role="tab">
      Tab 2
    </button>
    <button type="button" class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-800 dark:hs-tab-active:border-b-gray-800 dark:hs-tab-active:text-white -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200" id="card-type-tab-item-3" aria-selected="false" data-hs-tab="#card-type-tab-3" aria-controls="card-type-tab-3" role="tab">
      Tab 3
    </button>
  </nav>
</div>

<div class="mt-3">
  <div id="card-type-tab-preview" role="tabpanel" aria-labelledby="card-type-tab-item-1">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">first</em> item's tab body.
    </p>
  </div>
  <div id="card-type-tab-2" class="hidden" role="tabpanel" aria-labelledby="card-type-tab-item-2">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">second</em> item's tab body.
    </p>
  </div>
  <div id="card-type-tab-3" class="hidden" role="tabpanel" aria-labelledby="card-type-tab-item-3">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">third</em> item's tab body.
    </p>
  </div>
</div>

Tabs with badges
Contained tabs with badges.

<div class="border-b border-gray-200 dark:border-neutral-700">
  <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
    <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500 active" id="tabs-with-badges-item-1" aria-selected="true" data-hs-tab="#tabs-with-badges-1" aria-controls="tabs-with-badges-1" role="tab">
      Tab 1 <span class="hs-tab-active:bg-blue-100 hs-tab-active:text-blue-600 dark:hs-tab-active:bg-blue-800 dark:hs-tab-active:text-white ms-1 py-0.5 px-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-neutral-700 dark:text-neutral-300">99+</span>
    </button>
    <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500" id="tabs-with-badges-item-2" aria-selected="false" data-hs-tab="#tabs-with-badges-2" aria-controls="tabs-with-badges-2" role="tab">
      Tab 2 <span class="hs-tab-active:bg-blue-100 hs-tab-active:text-blue-600 dark:hs-tab-active:bg-blue-800 dark:hs-tab-active:text-white ms-1 py-0.5 px-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-neutral-700 dark:text-neutral-300">99+</span>
    </button>
    <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500" id="tabs-with-badges-item-3" aria-selected="false" data-hs-tab="#tabs-with-badges-3" aria-controls="tabs-with-badges-3" role="tab">
      Tab 3
    </button>
  </nav>
</div>

<div class="mt-3">
  <div id="tabs-with-badges-1" role="tabpanel" aria-labelledby="tabs-with-badges-item-1">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">first</em> item's tab body.
    </p>
  </div>
  <div id="tabs-with-badges-2" class="hidden" role="tabpanel" aria-labelledby="tabs-with-badges-item-2">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">second</em> item's tab body.
    </p>
  </div>
  <div id="tabs-with-badges-3" class="hidden" role="tabpanel" aria-labelledby="tabs-with-badges-item-3">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">third</em> item's tab body.
    </p>
  </div>
</div>

Tabs with icons
Contained tabs with icons.

<div class="border-b border-gray-200 dark:border-neutral-700">
  <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
    <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500 active" id="tabs-with-icons-item-1" aria-selected="true" data-hs-tab="#tabs-with-icons-1" aria-controls="tabs-with-icons-1" role="tab">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        <polyline points="9 22 9 12 15 12 15 22"></polyline>
      </svg>
      Tab 1
    </button>
    <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500" id="tabs-with-icons-item-2" aria-selected="false" data-hs-tab="#tabs-with-icons-2" aria-controls="tabs-with-icons-2" role="tab">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <circle cx="12" cy="10" r="3"></circle>
        <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>
      </svg>
      Tab 2
    </button>
    <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500" id="tabs-with-icons-item-3" aria-selected="false" data-hs-tab="#tabs-with-icons-3" aria-controls="tabs-with-icons-3" role="tab">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
        <circle cx="12" cy="12" r="3"></circle>
      </svg>
      Tab 3
    </button>
  </nav>
</div>

<div class="mt-3">
  <div id="tabs-with-icons-1" role="tabpanel" aria-labelledby="tabs-with-icons-item-1">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">first</em> item's tab body.
    </p>
  </div>
  <div id="tabs-with-icons-2" class="hidden" role="tabpanel" aria-labelledby="tabs-with-icons-item-2">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">second</em> item's tab body.
    </p>
  </div>
  <div id="tabs-with-icons-3" class="hidden" role="tabpanel" aria-labelledby="tabs-with-icons-item-3">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">third</em> item's tab body.
    </p>
  </div>
</div>

Tabs with underline
A basic form of tabs with underline.

<div class="border-b border-gray-200 dark:border-neutral-700">
  <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
    <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500 active" id="tabs-with-underline-item-1" aria-selected="true" data-hs-tab="#tabs-with-underline-1" aria-controls="tabs-with-underline-1" role="tab">
      Tab 1
    </button>
    <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500" id="tabs-with-underline-item-2" aria-selected="false" data-hs-tab="#tabs-with-underline-2" aria-controls="tabs-with-underline-2" role="tab">
      Tab 2
    </button>
    <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500" id="tabs-with-underline-item-3" aria-selected="false" data-hs-tab="#tabs-with-underline-3" aria-controls="tabs-with-underline-3" role="tab">
      Tab 3
    </button>
  </nav>
</div>

<div class="mt-3">
  <div id="tabs-with-underline-1" role="tabpanel" aria-labelledby="tabs-with-underline-item-1">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">first</em> item's tab body.
    </p>
  </div>
  <div id="tabs-with-underline-2" class="hidden" role="tabpanel" aria-labelledby="tabs-with-underline-item-2">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">second</em> item's tab body.
    </p>
  </div>
  <div id="tabs-with-underline-3" class="hidden" role="tabpanel" aria-labelledby="tabs-with-underline-item-3">
    <p class="text-gray-500 dark:text-neutral-400">
      This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">third</em> item's tab body.
    </p>
  </div>
</div>

### 18. Listado de sidebar ###

Content push to mini sidebar New
On desktop, closing the sidebar transitions it into a compact mini sidebar mode, ensuring both the sidebar and main content remain visible for a smooth and uninterrupted navigation experience.

<!-- Navigation Toggle -->
<div class="lg:hidden py-16 text-center">
  <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-start bg-gray-800 border border-gray-800 text-white text-sm font-medium rounded-lg shadow-2xs align-middle hover:bg-gray-950 focus:outline-hidden focus:bg-gray-900 dark:bg-white dark:text-neutral-800 dark:hover:bg-neutral-200 dark:focus:bg-neutral-200" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-sidebar-content-push-to-mini-sidebar" aria-label="Toggle navigation" data-hs-overlay="#hs-sidebar-content-push-to-mini-sidebar">
    Open
  </button>
</div>
<!-- End Navigation Toggle -->

<!-- Sidebar -->
<div id="hs-sidebar-content-push-to-mini-sidebar" class="hs-overlay [--auto-close:lg] hs-overlay-minified:w-13 lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 w-64
hs-overlay-open:translate-x-0
-translate-x-full transition-all duration-300 transform
h-full
hidden
overflow-x-hidden
fixed top-0 start-0 bottom-0 z-60
bg-white border-e border-gray-200 dark:bg-neutral-800 dark:border-neutral-700" role="dialog" tabindex="-1" aria-label="Sidebar" >
  <div class="relative flex flex-col h-full max-h-full ">
      <!-- Header -->
      <header class="py-4 px-2  flex justify-between items-center gap-x-2">

        <div class="lg:hidden">
          <!-- Close Button -->
          <button type="button" class="flex justify-center items-center gap-x-3 size-6 bg-white border border-gray-200 text-sm text-gray-600 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:hover:text-neutral-200 dark:focus:text-neutral-200" data-hs-overlay="#hs-sidebar-content-push-to-mini-sidebar">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            <span class="sr-only">Close</span>
          </button>
          <!-- End Close Button -->
        </div>
        <div class="hidden lg:block">
          <!-- Toggle Button -->
          <button type="button" class="flex justify-center items-center flex-none gap-x-3 size-9 text-sm text-gray-600 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:hover:text-neutral-200 dark:focus:text-neutral-200" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-sidebar-content-push-to-mini-sidebar" aria-label="Minify navigation" data-hs-overlay-minifier="#hs-sidebar-content-push-to-mini-sidebar">
            <svg class="hidden hs-overlay-minified:block shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/><path d="m8 9 3 3-3 3"/></svg>
            <svg class="hs-overlay-minified:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/><path d="m10 15-3-3 3-3"/></svg>
            <span class="sr-only">Navigation Toggle</span>
          </button>
          <!-- End Toggle Button -->
        </div>
      </header>
      <!-- End Header -->

      <!-- Body -->
      <nav class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
        <div class=" pb-0 px-2  w-full flex flex-col flex-wrap" >
          <ul class="space-y-1">
            <li>
              <a class="min-h-[36px] flex items-center gap-x-3.5 py-2 px-2.5 bg-gray-100 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-white" href="#">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="hs-overlay-minified:hidden">Dashboard</span>
              </a>
            </li>

            <li>
              <a class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200" href="#">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                <span class="text-nowrap hs-overlay-minified:hidden">Calendar <span class="ms-auto py-0.5 px-1.5 inline-flex items-center gap-x-1.5 text-xs bg-gray-200 text-gray-800 rounded-full dark:bg-neutral-600 dark:text-neutral-200">New</span></span>
              </a>
            </li>
            <li>
              <a class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200" href="#">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                <span class="hs-overlay-minified:hidden">Documentation</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Body -->

      <!-- Footer -->
      <footer class="mt-auto p-2 border-t border-gray-200 dark:border-neutral-700">
        <!-- Account Dropdown -->
        <div class="hs-dropdown [--strategy:absolute] [--auto-close:inside] relative w-full inline-flex">
          <button id="hs-sidebar-footer-example-with-dropdown" type="button" class="w-full inline-flex shrink-0 items-center gap-x-2 p-2 text-start text-sm text-gray-800 rounded-md hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
            <img class="shrink-0 size-5 rounded-full" src="https://images.unsplash.com/photo-1734122415415-88cb1d7d5dc0?q=80&w=320&h=320&auto=format&fit=facearea&facepad=3&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Avatar">
            Mia Hudson
            <svg class="shrink-0 size-3.5 ms-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
          </button>

          <!-- Account Dropdown -->
          <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-60 transition-[opacity,margin] duration opacity-0 hidden z-20 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-900 dark:border-neutral-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-sidebar-footer-example-with-dropdown">
            <div class="p-1">
              <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                My account
              </a>
              <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                Settings
              </a>
              <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                Billing
              </a>
              <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                Sign out
              </a>
            </div>
          </div>
          <!-- End Account Dropdown -->
        </div>
        <!-- End Account Dropdown -->
      </footer>
      <!-- End Footer -->
  </div>
</div>
<!-- End Sidebar -->

### 19. Listado de Breadcrumb ###

Chevrons
The simple form of chevron breadcrumbs.

<ol class="flex items-center whitespace-nowrap">
  <li class="inline-flex items-center">
    <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      Home
    </a>
    <svg class="shrink-0 mx-2 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </li>
  <li class="inline-flex items-center">
    <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      App Center
      <svg class="shrink-0 mx-2 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
      </svg>
    </a>
  </li>
  <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate dark:text-neutral-200" aria-current="page">
    Application
  </li>
</ol>

Slashes
The simple form of slashes breadcrumbs.

<ol class="flex items-center whitespace-nowrap">
  <li class="inline-flex items-center">
    <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      Home
    </a>
    <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600 mx-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M6 13L10 3" stroke="currentColor" stroke-linecap="round"></path>
    </svg>
  </li>
  <li class="inline-flex items-center">
    <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      App Center
      <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600 mx-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M6 13L10 3" stroke="currentColor" stroke-linecap="round"></path>
      </svg>
    </a>
  </li>
  <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate dark:text-neutral-200" aria-current="page">
    Application
  </li>
</ol>

With icons
Example with icons.

<ol class="flex items-center whitespace-nowrap">
  <li class="inline-flex items-center">
    <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      <svg class="shrink-0 me-3 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        <polyline points="9 22 9 12 15 12 15 22"></polyline>
      </svg>
      Home
    </a>
    <svg class="shrink-0 mx-2 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </li>
  <li class="inline-flex items-center">
    <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500" href="#">
      <svg class="shrink-0 me-3 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect width="7" height="7" x="14" y="3" rx="1"></rect>
        <path d="M10 21V8a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H3"></path>
      </svg>
      App Center
      <svg class="shrink-0 mx-2 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
      </svg>
    </a>
  </li>
  <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate dark:text-neutral-200" aria-current="page">
    Application
  </li>
</ol>



### 20. Listado de pagination ###

Bordered group
Bordered group pagination variant.

<!-- Pagination -->
<nav class="flex items-center -space-x-px" aria-label="Pagination">
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Previous">
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15 18-6-6 6-6"></path>
    </svg>
    <span class="hidden sm:block">Previous</span>
  </button>
  <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center bg-gray-200 text-gray-800 border border-gray-200 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-hidden focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-600 dark:border-neutral-700 dark:text-white dark:focus:bg-neutral-500" aria-current="page">1</button>
  <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">2</button>
  <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">3</button>
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Next">
    <span class="hidden sm:block">Next</span>
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </button>
</nav>
<!-- End Pagination -->

Alignment
Change the alignment of pagination components. For example, with justify-center:

<!-- Pagination -->
<nav class="flex justify-center items-center gap-x-1" aria-label="Pagination">
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex jusify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Previous">
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15 18-6-6 6-6"></path>
    </svg>
    <span class="sr-only">Previous</span>
  </button>
  <div class="flex items-center gap-x-1">
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center bg-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-600 dark:text-white dark:focus:bg-neutral-500" aria-current="page">1</button>
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">2</button>
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">3</button>
  </div>
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex jusify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Next">
    <span class="sr-only">Next</span>
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </button>
</nav>
<!-- End Pagination -->

<!-- Pagination -->
<nav class="flex justify-center items-center gap-x-1" aria-label="Pagination">
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-transparent dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Previous">
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15 18-6-6 6-6"></path>
    </svg>
    <span class="sr-only">Previous</span>
  </button>
  <div class="flex items-center gap-x-1">
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:focus:bg-white/10" aria-current="page">1</button>
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-transparent text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-transparent dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">2</button>
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-transparent text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-transparent dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">3</button>
  </div>
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-transparent dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Next">
    <span class="sr-only">Next</span>
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </button>
</nav>
<!-- End Pagination -->

<!-- Pagination -->
<nav class="flex justify-center items-center -space-x-px" aria-label="Pagination">
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Previous">
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15 18-6-6 6-6"></path>
    </svg>
    <span class="sr-only">Previous</span>
  </button>
  <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center bg-gray-200 text-gray-800 border border-gray-200 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-hidden focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-600 dark:border-neutral-700 dark:text-white dark:focus:bg-neutral-500" aria-current="page">1</button>
  <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">2</button>
  <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">3</button>
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Next">
    <span class="sr-only">Next</span>
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </button>
</nav>
<!-- End Pagination -->

<!-- Pagination -->
<nav class="flex justify-center items-center gap-x-1" aria-label="Pagination">
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Previous">
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15 18-6-6 6-6"></path>
    </svg>
    <span class="sr-only">Previous</span>
  </button>
  <div class="flex items-center gap-x-1">
    <span class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:focus:bg-white/10">1</span>
    <span class="min-h-9.5 flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm dark:text-neutral-500">of</span>
    <span class="min-h-9.5 flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm dark:text-neutral-500">3</span>
  </div>
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Next">
    <span class="sr-only">Next</span>
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </button>
</nav>
<!-- End Pagination -->

Or with justify-end:

<!-- Pagination -->
<nav class="flex justify-end items-center gap-x-1" aria-label="Pagination">
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex jusify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Previous">
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15 18-6-6 6-6"></path>
    </svg>
    <span class="sr-only">Previous</span>
  </button>
  <div class="flex items-center gap-x-1">
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center bg-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-600 dark:text-white dark:focus:bg-neutral-500" aria-current="page">1</button>
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">2</button>
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">3</button>
  </div>
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex jusify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Next">
    <span class="sr-only">Next</span>
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </button>
</nav>
<!-- End Pagination -->

<!-- Pagination -->
<nav class="flex justify-end items-center gap-x-1" aria-label="Pagination">
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-transparent dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Previous">
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15 18-6-6 6-6"></path>
    </svg>
    <span class="sr-only">Previous</span>
  </button>
  <div class="flex items-center gap-x-1">
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:focus:bg-white/10" aria-current="page">1</button>
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-transparent text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-transparent dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">2</button>
    <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-transparent text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-transparent dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">3</button>
  </div>
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-transparent dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Next">
    <span class="sr-only">Next</span>
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </button>
</nav>
<!-- End Pagination -->

<!-- Pagination -->
<nav class="flex justify-end items-center -space-x-px" aria-label="Pagination">
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Previous">
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15 18-6-6 6-6"></path>
    </svg>
    <span class="sr-only">Previous</span>
  </button>
  <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center bg-gray-200 text-gray-800 border border-gray-200 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-hidden focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-600 dark:border-neutral-700 dark:text-white dark:focus:bg-neutral-500" aria-current="page">1</button>
  <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">2</button>
  <button type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">3</button>
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Next">
    <span class="sr-only">Next</span>
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </button>
</nav>
<!-- End Pagination -->

<!-- Pagination -->
<nav class="flex justify-end items-center gap-x-1" aria-label="Pagination">
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Previous">
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15 18-6-6 6-6"></path>
    </svg>
    <span class="sr-only">Previous</span>
  </button>
  <div class="flex items-center gap-x-1">
    <span class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:focus:bg-white/10">1</span>
    <span class="min-h-9.5 flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm dark:text-neutral-500">of</span>
    <span class="min-h-9.5 flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm dark:text-neutral-500">3</span>
  </div>
  <button type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Next">
    <span class="sr-only">Next</span>
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </button>
</nav>
<!-- End Pagination -->

### 21. Listado de stepper ###

Dynamic Linear
Requires JS
Note that this component requires the use of our Stepper plugin, else you can skip this message if you are already using Preline UI as a package.

A dynamic stepper example that guides users through the steps of a task.

<!-- Stepper -->
<div data-hs-stepper="">
  <!-- Stepper Nav -->
  <ul class="relative flex flex-row gap-x-2">
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group" data-hs-stepper-nav-item='{
      "index": 1
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-600 dark:hs-stepper-completed:bg-teal-600"></div>
    </li>

    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group" data-hs-stepper-nav-item='{
      "index": 2
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-600 dark:hs-stepper-completed:bg-teal-600"></div>
    </li>

    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group" data-hs-stepper-nav-item='{
        "index": 3
      }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-600 dark:hs-stepper-completed:bg-teal-600"></div>
    </li>
    <!-- End Item -->
  </ul>
  <!-- End Stepper Nav -->

  <!-- Stepper Content -->
  <div class="mt-5 sm:mt-8">
    <!-- First Content -->
    <div data-hs-stepper-content-item='{
      "index": 1
    }'>
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          First content
        </h3>
      </div>
    </div>
    <!-- End First Content -->

    <!-- First Content -->
    <div data-hs-stepper-content-item='{
      "index": 2
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Second content
        </h3>
      </div>
    </div>
    <!-- End First Content -->

    <!-- First Content -->
    <div data-hs-stepper-content-item='{
      "index": 3
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Third content
        </h3>
      </div>
    </div>
    <!-- End First Content -->

    <!-- Final Content -->
    <div data-hs-stepper-content-item='{
      "isFinal": true
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Final content
        </h3>
      </div>
    </div>
    <!-- End Final Content -->

    <!-- Button Group -->
    <div class="mt-5 flex justify-between items-center gap-x-2">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-stepper-back-btn="">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m15 18-6-6 6-6"></path>
        </svg>
        Back
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-next-btn="">
        Next
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 18 6-6-6-6"></path>
        </svg>
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-finish-btn="" style="display: none;">
        Finish
      </button>
      <button type="reset" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-reset-btn="" style="display: none;">
        Reset
      </button>
    </div>
    <!-- End Button Group -->
  </div>
  <!-- End Stepper Content -->
</div>
<!-- End Stepper -->

Non-linear
With a "Complete Step" button.

<!-- Stepper -->
<div data-hs-stepper='{
  "mode": "non-linear"
}'>
  <!-- Stepper Nav -->
  <ul class="relative flex flex-row gap-x-2">
    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group active" data-hs-stepper-nav-item='{
      "index": 1
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->

    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group" data-hs-stepper-nav-item='{
      "index": 2
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->

    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group" data-hs-stepper-nav-item='{
      "index": 3
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->
  </ul>
  <!-- End Stepper Nav -->

  <!-- Stepper Content -->
  <div class="mt-5 sm:mt-8">
    <!-- First Content -->
    <div data-hs-stepper-content-item='{
      "index": 1
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          First content
        </h3>
      </div>
    </div>
    <!-- End First Content -->

    <!-- Second Content -->
    <div data-hs-stepper-content-item='{
      "index": 2
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Second content
        </h3>
      </div>
    </div>
    <!-- End Second Content -->

    <!-- Third Content -->
    <div data-hs-stepper-content-item='{
      "index": 3
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Third content
        </h3>
      </div>
    </div>
    <!-- End Third Content -->

    <!-- Final Content -->
    <div data-hs-stepper-content-item='{
      "isFinal": true
    }'>
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Final content
        </h3>
      </div>
    </div>
    <!-- End Final Content -->

    <div class="mt-5 flex justify-between items-center gap-x-2">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-stepper-back-btn="">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m15 18-6-6 6-6"></path>
        </svg>
        Back
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-skip-btn="" style="display: none;">
        Skip
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-complete-step-btn='{
        "completedText": "This step is completed"
      }'>
        Complete Step
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-next-btn="">
        Next
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 18 6-6-6-6"></path>
        </svg>
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-finish-btn="" style="display: none;">
        Finish
      </button>
      <button type="reset" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-reset-btn="" style="display: none;">
        Reset
      </button>
    </div>
  </div>
  <!-- End Stepper Content -->
</div>
<!-- Stepper -->

Skipped
A skip button step example.

<!-- Stepper -->
<div data-hs-stepper="">
  <!-- Stepper Nav -->
  <ul class="relative flex flex-row gap-x-2">
    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group active" data-hs-stepper-nav-item='{
      "index": 1,
      "isOptional": true
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->

    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group" data-hs-stepper-nav-item='{
      "index": 2,
      "isOptional": true
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->

    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group" data-hs-stepper-nav-item='{
      "index": 3
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->
  </ul>
  <!-- End Stepper Nav -->

  <!-- Stepper Content -->
  <div class="mt-5 sm:mt-8">
    <!-- First Content -->
    <div data-hs-stepper-content-item='{
      "index": 1
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          First content
        </h3>
      </div>
    </div>
    <!-- End First Content -->

    <!-- Second Content -->
    <div data-hs-stepper-content-item='{
      "index": 2
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Second content
        </h3>
      </div>
    </div>
    <!-- End Second Content -->

    <!-- Third Content -->
    <div data-hs-stepper-content-item='{
      "index": 3
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Third content
        </h3>
      </div>
    </div>
    <!-- End Third Content -->

    <!-- Final Content -->
    <div data-hs-stepper-content-item='{
      "isFinal": true
    }'>
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Final content
        </h3>
      </div>
    </div>
    <!-- End Final Content -->

    <div class="mt-5 flex justify-between items-center gap-x-2">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-stepper-back-btn="">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m15 18-6-6 6-6"></path>
        </svg>
        Back
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-skip-btn="" style="display: none;">
        Skip
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-next-btn="">
        Next
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 18 6-6-6-6"></path>
        </svg>
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-finish-btn="" style="display: none;">
        Finish
      </button>
      <button type="reset" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-reset-btn="" style="display: none;">
        Reset
      </button>
    </div>
  </div>
  <!-- End Stepper Content -->
</div>
<!-- Stepper -->

Active
Active stepper example.

<!-- Stepper -->
<div data-hs-stepper='{
  "currentIndex": 2
}'>
  <!-- Stepper Nav -->
  <ul class="relative flex flex-row gap-x-2">
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group success" data-hs-stepper-nav-item='{
      "index": 1,
      "isCompleted": true
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-600 dark:hs-stepper-completed:bg-teal-600"></div>
    </li>

    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group active" data-hs-stepper-nav-item='{
      "index": 2
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-600 dark:hs-stepper-completed:bg-teal-600"></div>
    </li>

    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group" data-hs-stepper-nav-item='{
      "index": 3
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-600 dark:hs-stepper-completed:bg-teal-600"></div>
    </li>
    <!-- End Item -->
  </ul>
  <!-- End Stepper Nav -->

  <!-- Stepper Content -->
  <div class="mt-5 sm:mt-8">
    <!-- First Content -->
    <div data-hs-stepper-content-item='{
      "index": 1,
      "isCompleted": true
    }' class="success" style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          First content
        </h3>
      </div>
    </div>
    <!-- End First Content -->

    <!-- First Content -->
    <div data-hs-stepper-content-item='{
      "index": 2
    }' class="active">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Second content
        </h3>
      </div>
    </div>
    <!-- End First Content -->

    <!-- First Content -->
    <div data-hs-stepper-content-item='{
      "index": 3
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Third content
        </h3>
      </div>
    </div>
    <!-- End First Content -->

    <!-- Final Content -->
    <div data-hs-stepper-content-item='{
      "isFinal": true
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Final content
        </h3>
      </div>
    </div>
    <!-- End Final Content -->

    <!-- Button Group -->
    <div class="mt-5 flex justify-between items-center gap-x-2">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-stepper-back-btn="">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m15 18-6-6 6-6"></path>
        </svg>
        Back
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-next-btn="">
        Next
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 18 6-6-6-6"></path>
        </svg>
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-finish-btn="" style="display: none;">
        Finish
      </button>
      <button type="reset" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-reset-btn="" style="display: none;">
        Reset
      </button>
    </div>
    <!-- End Button Group -->
  </div>
  <!-- End Stepper Content -->
</div>
<!-- End Stepper -->

Error
Error stepper example.

<!-- Stepper -->
<div id="error-stepper" data-hs-stepper='{
  "currentIndex": 2
}'>
  <!-- Stepper Nav -->
  <ul class="relative flex flex-row gap-x-2">
    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group success" data-hs-stepper-nav-item='{
      "index": 1,
      "isCompleted": true
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 hs-stepper-error:bg-red-500 hs-stepper-active:text-white hs-stepper-success:text-white hs-stepper-processed:bg-white hs-stepper-processed:border hs-stepper-processed:border-gray-200 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600 dark:hs-stepper-error:bg-red-500 dark:hs-stepper-processed:bg-neutral-800 dark:hs-stepper-processed:border-neutral-700">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden hs-stepper-error:hidden hs-stepper-processed:hidden">1</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
          <svg class="hidden shrink-0 size-3 hs-stepper-error:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
          <span class="hidden animate-spin size-4 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500 hs-stepper-processed:inline-block" role="status" aria-label="loading">
            <span class="sr-only">Loading...</span>
          </span>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->

    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group error" data-hs-stepper-nav-item='{
      "index": 2,
      "hasError": true
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 hs-stepper-error:bg-red-500 hs-stepper-active:text-white hs-stepper-success:text-white hs-stepper-processed:bg-white hs-stepper-processed:border hs-stepper-processed:border-gray-200 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600 dark:hs-stepper-error:bg-red-500 dark:hs-stepper-processed:bg-neutral-800 dark:hs-stepper-processed:border-neutral-700">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden hs-stepper-error:hidden hs-stepper-processed:hidden">2</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
          <svg class="hidden shrink-0 size-3 hs-stepper-error:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
          <span class="hidden animate-spin size-4 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500 hs-stepper-processed:inline-block" role="status" aria-label="loading">
            <span class="sr-only">Loading...</span>
          </span>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->

    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group" data-hs-stepper-nav-item='{
      "index": 3
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 hs-stepper-error:bg-red-500 hs-stepper-active:text-white hs-stepper-success:text-white hs-stepper-processed:bg-white hs-stepper-processed:border hs-stepper-processed:border-gray-200 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600 dark:hs-stepper-error:bg-red-500 dark:hs-stepper-processed:bg-neutral-800 dark:hs-stepper-processed:border-neutral-700">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden hs-stepper-error:hidden hs-stepper-processed:hidden">3</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
          <svg class="hidden shrink-0 size-3 hs-stepper-error:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
          <span class="hidden animate-spin size-4 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500 hs-stepper-processed:inline-block" role="status" aria-label="loading">
            <span class="sr-only">Loading...</span>
          </span>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->
  </ul>
  <!-- End Stepper Nav -->

  <!-- Stepper Content -->
  <div class="mt-5 sm:mt-8">
    <!-- First Content -->
    <div data-hs-stepper-content-item='{
      "index": 1,
      "isCompleted": true
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          First content
        </h3>
      </div>
    </div>
    <!-- End First Content -->

    <!-- Second Content -->
    <div data-hs-stepper-content-item='{
      "index": 2
    }'>
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Second content
        </h3>
      </div>
    </div>
    <!-- End Second Content -->

    <!-- Third Content -->
    <div data-hs-stepper-content-item='{
      "index": 3
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Third content
        </h3>
      </div>
    </div>
    <!-- End Third Content -->

    <!-- Final Content -->
    <div data-hs-stepper-content-item='{
      "isFinal": true
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Final content
        </h3>
      </div>
    </div>
    <!-- End Final Content -->

    <div class="mt-5 flex justify-between items-center gap-x-2">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-stepper-back-btn="">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m15 18-6-6 6-6"></path>
        </svg>
        Back
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-next-btn="">
        Next
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 18 6-6-6-6"></path>
        </svg>
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-finish-btn="" style="display: none;">
        Finish
      </button>
      <button type="reset" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-reset-btn="" style="display: none;">
        Reset
      </button>
    </div>
  </div>
  <!-- End Stepper Content -->
</div>
<!-- End Stepper -->

Success
Success stepper example.

<!-- Stepper -->
<div data-hs-stepper='{
  "isCompleted": true
}' class="completed">
  <!-- Stepper Nav -->
  <ul class="relative flex flex-row gap-x-2">
    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group success" data-hs-stepper-nav-item='{
      "index": 1,
      "isCompleted": true
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->

    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group success" data-hs-stepper-nav-item='{
      "index": 2,
      "isCompleted": true
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->

    <!-- Item -->
    <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group active success" data-hs-stepper-nav-item='{
      "index": 3,
      "isCompleted": true
    }'>
      <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
        <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
          <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500 dark:text-white dark:group-focus:text-gray-400">
          Step
        </span>
      </span>
      <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500"></div>
    </li>
    <!-- End Item -->
  </ul>
  <!-- End Stepper Nav -->

  <!-- Stepper Content -->
  <div class="mt-5 sm:mt-8">
    <!-- First Content -->
    <div data-hs-stepper-content-item='{
      "index": 1,
      "isCompleted": true
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          First content
        </h3>
      </div>
    </div>
    <!-- End First Content -->

    <!-- Second Content -->
    <div data-hs-stepper-content-item='{
      "index": 2,
      "isCompleted": true
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Second content
        </h3>
      </div>
    </div>
    <!-- End Second Content -->

    <!-- Third Content -->
    <div data-hs-stepper-content-item='{
      "index": 3,
      "isCompleted": true
    }' style="display: none;">
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Third content
        </h3>
      </div>
    </div>
    <!-- End Third Content -->

    <!-- Final Content -->
    <div data-hs-stepper-content-item='{
      "isFinal": true
    }'>
      <div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 class="text-gray-500 dark:text-neutral-500">
          Final content
        </h3>
      </div>
    </div>
    <!-- End Final Content -->

    <div class="mt-5 flex justify-between items-center gap-x-2">
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-stepper-back-btn="" style="display: none;">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m15 18-6-6 6-6"></path>
        </svg>
        Back
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-next-btn="" style="display: none;">
        Next
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 18 6-6-6-6"></path>
        </svg>
      </button>
      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-finish-btn="" style="display: none;">
        Finish
      </button>
      <button type="reset" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-stepper-reset-btn="">
        Reset
      </button>
    </div>
  </div>
  <!-- End Stepper Content -->
</div>
<!-- End Stepper -->

### 22. Listado de input group ###

Checkbox and radios
Place any checkbox or radio option within an input group’s addon instead of text.

<div class="max-w-sm space-y-3">
  <div>
    <div class="flex rounded-lg">
      <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400">
        <span class="flex">
          <input type="checkbox" class="shrink-0 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-input-group-with-checkbox">
          <label for="hs-input-group-with-checkbox" class="sr-only">Checkbox</label>
        </span>
      </span>
      <input type="text" name="hs-input-with-add-on-url-checkbox" id="hs-input-with-add-on-url-checkbox" class="py-2.5 sm:py-3 px-4 pe-11 block w-full border-gray-200 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Checkbox">
    </div>
  </div>

  <div>
    <div class="flex rounded-lg">
      <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400">
        <span class="flex">
          <input type="radio" class="shrink-0 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-input-group-with-radio">
          <label for="hs-input-group-with-radio" class="sr-only">Radio</label>
        </span>
      </span>
      <input type="text" name="hs-input-with-add-on-url-radio" id="hs-input-with-add-on-url-radio" class="py-2.5 sm:py-3 px-4 pe-11 block w-full border-gray-200 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Radio">
    </div>
  </div>
</div>

Leading button add-ons

<div class="max-w-sm space-y-3">
  <div>
    <label for="hs-leading-button-add-on-with-icon" class="sr-only">Label</label>
    <div class="flex rounded-lg">
      <button type="button" class="size-11.5 shrink-0 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <path d="m21 21-4.3-4.3"></path>
        </svg>
      </button>
      <input type="text" id="hs-leading-button-add-on-with-icon" name="hs-leading-button-add-on-with-icon" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
    </div>
  </div>

  <div>
    <label for="hs-leading-button-add-on-with-leading-and-leading" class="sr-only">Label</label>
    <div class="flex rounded-lg">
      <button type="button" class="size-11.5 shrink-0 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <path d="m21 21-4.3-4.3"></path>
        </svg>
      </button>
      <input type="text" id="hs-leading-button-add-on-with-leading-and-leading" name="hs-leading-button-add-on-with-leading-and-leading" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-0 sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
      <span class="px-4 inline-flex items-center min-w-fit rounded-e-md border border-s-0 border-gray-200 bg-gray-50 text-sm dark:bg-neutral-700 dark:border-neutral-700">
        <span class="text-sm text-gray-500 dark:text-neutral-400">http://</span>
      </span>
    </div>
  </div>

  <div>
    <label for="hs-leading-button-add-on-with-icon-and-button" class="sr-only">Label</label>
    <div class="relative flex rounded-lg">
      <button type="button" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">Search</button>
      <input type="text" id="hs-leading-button-add-on-with-icon-and-button" name="hs-leading-button-add-on-with-icon-and-button" class="py-2.5 sm:py-3 px-4 pe-11 block w-full border-gray-200 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none z-20 pe-4">
        <svg class="shrink-0 size-4 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <path d="m21 21-4.3-4.3"></path>
        </svg>
      </div>
    </div>
  </div>

  <div>
    <label for="hs-leading-button-add-on" class="sr-only">Label</label>
    <div class="flex rounded-lg">
      <button type="button" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
        Button
      </button>
      <input type="text" id="hs-leading-button-add-on" name="hs-leading-button-add-on" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
    </div>
  </div>

  <div>
    <label for="hs-leading-button-add-on-multiple-add-ons" class="sr-only">Label</label>
    <div class="flex rounded-lg">
      <button type="button" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
        Button
      </button>
      <button type="button" class="-me-px py-3 px-4 inline-flex justify-center items-center gap-2 border border-gray-200 font-medium bg-white text-gray-700 shadow-2xs align-middle hover:bg-gray-50 focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600 transition-all text-sm dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-white">
        Button
      </button>
      <input type="text" id="hs-leading-button-add-on-multiple-add-ons" name="hs-leading-button-add-on-multiple-add-ons" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-e-md sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
    </div>
  </div>
</div>

Inline add-on
Add an inline add-on inside input.

<div class="max-w-sm space-y-3">
  <div>
    <label for="hs-inline-add-on" class="block text-sm font-medium mb-2 dark:text-white">Website URL</label>
    <div class="relative">
      <input type="text" id="hs-inline-add-on" name="hs-inline-add-on" class="py-2.5 sm:py-3 px-4 ps-16 block w-full border-gray-200 rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="www.example.com">
      <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
        <span class="text-sm text-gray-500 dark:text-neutral-500">http://</span>
      </div>
    </div>
  </div>
</div>

Add-on
Add an add-on in tandem with input.

<div class="max-w-sm space-y-3">
  <div>
    <label for="hs-input-with-add-on-url" class="block text-sm text-gray-700 font-medium dark:text-white">Website URL</label>
    <div class="flex rounded-lg">
      <div class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600">
        <span class="text-sm text-gray-500 dark:text-neutral-400">http://</span>
      </div>
      <input type="text" name="hs-input-with-add-on-url" id="hs-input-with-add-on-url" class="py-2.5 sm:py-3 px-4 pe-11 block w-full border-gray-200 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="www.example.com">
    </div>
  </div>
</div>

Leading icon
Add a leading icon inside input.

<div class="max-w-sm space-y-3">
  <div>
    <label for="hs-leading-icon" class="block text-sm font-medium mb-2 dark:text-white">Email address</label>
    <div class="relative">
      <input type="text" id="hs-leading-icon" name="hs-leading-icon" class="py-2.5 sm:py-3 px-4 ps-11 block w-full border-gray-200 rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="you@site.com">
      <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
        <svg class="shrink-0 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect width="20" height="16" x="2" y="4" rx="2"></rect>
          <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
        </svg>
      </div>
    </div>
  </div>
</div>

Sizes
Input groups stacked from small to large.

<div class="max-w-sm space-y-3">
  <div>
    <div class="flex rounded-lg">
      <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400">Small</span>
      <input type="text" class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
    </div>
  </div>

  <div>
    <div class="flex rounded-lg">
      <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400">Default</span>
      <input type="text" class="py-2.5 sm:py-3 px-4 pe-11 block w-full border-gray-200 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
    </div>
  </div>

  <div>
    <div class="flex rounded-lg">
      <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400">Large</span>
      <input type="text" class="py-3 px-4 pe-11 block w-full border-gray-200 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 sm:p-5">
    </div>
  </div>
</div>


### 23. Listado de textarea ###

Placeholder
Basic input example with placeholder.

<div class="max-w-sm space-y-3">
  <textarea class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="This is a textarea placeholder"></textarea>
</div>

Label
Basic input example with label.

<div class="max-w-sm">
  <label for="textarea-label" class="block text-sm font-medium mb-2 dark:text-white">Comment</label>
  <textarea id="textarea-label" class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Say hi..."></textarea>
</div>

Hidden label
<label> elements hidden using the .sr-only class

<div class="max-w-sm">
  <label for="textarea-email-label" class="sr-only">Comment</label>
  <textarea id="textarea-email-label" class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Say hi..."></textarea>
</div>

Gray input
Gray textarea variant.

<div class="max-w-sm space-y-3">
  <textarea class="py-2 px-3 sm:py-3 sm:px-4 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="This is a textarea placeholder"></textarea>
</div>

Default height with autoheight script
Use data-hs-default-height="*" to set the height of the textarea while maintaining the auto-height feature. Ensure to include the rows="1" attribute as well.

<!-- Textarea -->
<div class="relative max-w-sm">
  <textarea class="max-h-36 py-2.5 sm:py-3 ps-4 pe-20 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 resize-none overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500" placeholder="Message..." rows="1" data-hs-textarea-auto-height='{
    "defaultHeight": 48
  }'></textarea>

  <!-- Button Group -->
  <div class="absolute top-2 end-3 z-10">
    <button type="button" class="py-1.5 px-3 inline-flex shrink-0 justify-center items-center text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-500 focus:outline-hidden focus:bg-blue-500 disabled:opacity-50 disabled:pointer-events-none">
      Send
    </button>
  </div>
</div>
<!-- End Textarea -->

Readonly
Add the readonly boolean attribute on an input to prevent modification of the input’s value.

<div class="max-w-sm space-y-3">
  <textarea class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Readonly" readonly=""></textarea>
</div>

Disabled
Add the disabled boolean attribute on an input to remove pointer events, and prevent focusing.

<div class="max-w-sm space-y-3">
  <textarea class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Disabled textarea" disabled=""></textarea>
  <textarea class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Disabled readonly textarea" disabled="" readonly=""></textarea>
</div>

Helper text
Basic input example with helper text.

<div class="max-w-sm">
  <label for="textarea-label-with-helper-text" class="block text-sm font-medium mb-2 dark:text-white">Leave your question</label>
  <textarea id="textarea-label-with-helper-text" class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Say hi, we'll be happy to chat with you." aria-describedby="hs-textarea-helper-text"></textarea>
  <p class="mt-2 text-xs text-gray-500 dark:text-neutral-500" id="hs-textarea-helper-text">We'll get back to you soon.</p>
</div>

Corner hint
Basic input example with corner-hint.

<div class="max-w-sm">
  <div class="flex flex-wrap justify-between items-center gap-2">
    <label for="hs-textarea-with-corner-hint" class="block text-sm font-medium mb-2 dark:text-white">Contact us</label>
    <span class="block mb-2 text-sm text-gray-500 dark:text-neutral-500">100 characters</span>
  </div>
  <textarea id="hs-textarea-with-corner-hint" class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Say hi..."></textarea>
</div>

Autoheight
Autoheight example.

<div class="max-w-sm">
  <label for="hs-autoheight-textarea" class="block text-sm font-medium mb-2 dark:text-white">Contact us</label>
  <textarea id="hs-autoheight-textarea" class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Say hi..." data-hs-textarea-auto-height=""></textarea>
</div>

Modal example
Basic usage in modal window.

<!-- Modal Button -->
<button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-modal-example" data-hs-overlay="#hs-modal-example">
  Open modal
</button>
<!-- End Modal Button -->

<!-- Modal Content -->
<div id="hs-modal-example" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="hs-modal-example-label">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
      <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
        <h3 id="hs-modal-example-label" class="font-bold text-gray-800 dark:text-white">
          Modal example
        </h3>
        <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-modal-example">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
      <div class="p-4 overflow-y-auto min-h-32">
        <div>
          <label for="hs-autoheight-modal-example-textarea" class="block text-sm font-medium mb-2 dark:text-white">Contact us</label>
          <textarea id="hs-autoheight-modal-example-textarea" class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Say hi..." data-hs-textarea-auto-height=""></textarea>
        </div>
      </div>
      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-overlay="#hs-modal-example">
          Close
        </button>
        <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="#">
          Save changes
        </a>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Content -->

Textarea examples
Advanced custom examples.

<!-- Textarea -->
<div class="relative">
  <textarea id="hs-textarea-ex-1" class="p-3 sm:p-4 pb-12 sm:pb-12 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Ask me anything..." data-hs-textarea-auto-height=""></textarea>

  <!-- Toolbar -->
  <div class="absolute bottom-px inset-x-px p-2 rounded-b-md bg-white dark:bg-neutral-900">
    <div class="flex flex-wrap justify-between items-center gap-2">
      <!-- Button Group -->
      <div class="flex items-center">
        <!-- Mic Button -->
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-gray-100 focus:z-10 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-500 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="18" height="18" x="3" y="3" rx="2"></rect>
            <line x1="9" x2="15" y1="15" y2="9"></line>
          </svg>
        </button>
        <!-- End Mic Button -->

        <!-- Attach Button -->
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-gray-100 focus:z-10 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-500 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
          </svg>
        </button>
        <!-- End Attach Button -->
      </div>
      <!-- End Button Group -->

      <!-- Button Group -->
      <div class="flex items-center gap-x-1">
        <!-- Mic Button -->
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-gray-100 focus:z-10 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-500 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path>
            <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
            <line x1="12" x2="12" y1="19" y2="22"></line>
          </svg>
        </button>
        <!-- End Mic Button -->

        <!-- Send Button -->
        <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-white bg-blue-600 hover:bg-blue-500 focus:z-10 focus:outline-hidden focus:bg-blue-500">
          <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"></path>
          </svg>
        </button>
        <!-- End Send Button -->
      </div>
      <!-- End Button Group -->
    </div>
  </div>
  <!-- End Toolbar -->
</div>
<!-- End Textarea -->

Validation states
It provides valuable, actionable feedback to your users with HTML5 form validation.

<div class="max-w-sm space-y-4">
  <div>
    <label for="hs-validation-name-error" class="block text-sm font-medium mb-2 dark:text-white">Comment</label>
    <div class="relative">
      <textarea id="hs-validation-name-error" class="py-2.5 sm:py-3 px-4 block w-full border-red-500 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Say hi..." aria-describedby="hs-validation-name-error-helper" required=""></textarea>
      <div class="absolute top-0 end-0 flex items-center pointer-events-none p-3">
        <svg class="shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" x2="12" y1="8" y2="12"></line>
          <line x1="12" x2="12.01" y1="16" y2="16"></line>
        </svg>
      </div>
    </div>
    <p class="text-sm text-red-600 mt-2" id="hs-validation-name-error-helper">Your message should be at least 10 characters long.</p>
  </div>

  <div>
    <label for="hs-validation-name-success" class="block text-sm font-medium mb-2 dark:text-white">Comment</label>
    <div class="relative">
      <textarea id="hs-validation-name-success" class="py-2.5 sm:py-3 px-4 block w-full border-teal-500 rounded-lg sm:text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Say hi..." aria-describedby="hs-validation-name-success-helper" required=""></textarea>
      <div class="absolute top-0 end-0 flex items-center pointer-events-none p-3">
        <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
      </div>
    </div>
    <p class="text-sm text-teal-600 mt-2" id="hs-validation-name-success-helper">Looks good!</p>
  </div>
</div>



### 25. Listado de File Input ###

File input buttons
Button style file input example.

<div class="max-w-sm">
  <form>
    <label class="block">
      <span class="sr-only">Choose profile photo</span>
      <input type="file" class="block w-full text-sm text-gray-500
        file:me-4 file:py-2 file:px-4
        file:rounded-lg file:border-0
        file:text-sm file:font-semibold
        file:bg-blue-600 file:text-white
        hover:file:bg-blue-700
        file:disabled:opacity-50 file:disabled:pointer-events-none
        dark:text-neutral-500
        dark:file:bg-blue-500
        dark:hover:file:bg-blue-400
      ">
    </label>
  </form>
</div>

### 26. Listado de Checkbox ###

Default
By default, a checkbox input includes a selected and unselected state.

<div class="flex">
  <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-default-checkbox">
  <label for="hs-default-checkbox" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Default checkbox</label>
</div>

<div class="flex">
  <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checked-checkbox" checked="">
  <label for="hs-checked-checkbox" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Checked checkbox</label>
</div>

Disabled
Disabled checkbox.

<div class="flex opacity-40">
  <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-disabled-checkbox" disabled="">
  <label for="hs-disabled-checkbox" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Disabled checkbox</label>
</div>

<div class="flex opacity-40">
  <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-disabled-checked-checkbox" checked="" disabled="">
  <label for="hs-disabled-checked-checkbox" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Disabled checked checkbox</label>
</div>

Checkbox group
A group of checkbox components.

<div class="flex gap-x-6">
  <div class="flex">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-group-1">
    <label for="hs-checkbox-group-1" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Apple</label>
  </div>

  <div class="flex">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-group-2">
    <label for="hs-checkbox-group-2" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Pear</label>
  </div>

  <div class="flex">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-group-3">
    <label for="hs-checkbox-group-3" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Orange</label>
  </div>
</div>

<div class="flex gap-x-6">
  <div class="flex">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-group-4" checked="">
    <label for="hs-checkbox-group-4" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Apple</label>
  </div>

  <div class="flex">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-group-5" checked="">
    <label for="hs-checkbox-group-5" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Pear</label>
  </div>

  <div class="flex">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-group-6" checked="">
    <label for="hs-checkbox-group-6" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Orange</label>
  </div>
</div>

<div class="flex gap-x-6">
  <div class="flex opacity-40">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-group-7" disabled="">
    <label for="hs-checkbox-group-7" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Apple</label>
  </div>

  <div class="flex opacity-40">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-group-8" disabled="">
    <label for="hs-checkbox-group-8" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Pear</label>
  </div>

  <div class="flex opacity-40">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-group-9" disabled="">
    <label for="hs-checkbox-group-9" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Orange</label>
  </div>
</div>

List with description

<div class="grid space-y-3">
  <div class="relative flex items-start">
    <div class="flex items-center h-5 mt-1">
      <input id="hs-checkbox-delete" name="hs-checkbox-delete" type="checkbox" class="border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" aria-describedby="hs-checkbox-delete-description" checked="">
    </div>
    <label for="hs-checkbox-delete" class="ms-3">
      <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-300">Delete</span>
      <span id="hs-checkbox-delete-description" class="block text-sm text-gray-600 dark:text-neutral-500">Notify me when this action happens.</span>
    </label>
  </div>

  <div class="relative flex items-start">
    <div class="flex items-center h-5 mt-1">
      <input id="hs-checkbox-archive" name="hs-checkbox-archive" type="checkbox" class="border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" aria-describedby="hs-checkbox-archive-description">
    </div>
    <label for="hs-checkbox-archive" class="ms-3">
      <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-300">Archive</span>
      <span id="hs-checkbox-archive-description" class="block text-sm text-gray-600 dark:text-neutral-500">Notify me when this action happens.</span>
    </label>
  </div>
</div>

heckbox within form input
Checkbox components within form input stacked in a grid format.

<div class="grid sm:grid-cols-2 gap-2">
  <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form">
    <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Default checkbox</span>
  </label>

  <label for="hs-checkbox-checked-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-checked-in-form" checked="">
    <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Checked checkbox</span>
  </label>
</div>

Checkbox components within form input vertically grouped.

<div class="grid space-y-2">
  <label for="hs-vertical-checkbox-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-vertical-checkbox-in-form">
    <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Default checkbox</span>
  </label>

  <label for="vertical-checkbox-checked-in-form" class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="vertical-checkbox-checked-in-form" checked="">
    <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Checked checkbox</span>
  </label>
</div>

Validation states New
It provides valuable, actionable feedback to your users with HTML5 form validation.

<div>
  <label for="hs-error-checkbox" class="flex items-center space-x-3">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-red-600 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-red-500 dark:checked:border-red-500 dark:focus:ring-offset-gray-800" id="hs-error-checkbox" disabled="">
    <span class="text-sm text-red-500">This is an error checkbox</span>
  </label>
</div>

<div>
  <label for="hs-success-checkbox" class="flex items-center space-x-3">
    <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-teal-600 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-teal-500 dark:checked:border-teal-500 dark:focus:ring-offset-gray-800" id="hs-success-checkbox" checked="">
    <span class="text-sm text-teal-500">This is a success checkbox</span>
  </label>
</div>

### 27. Listado de Radio ###

Default
The default way to present a single option from a list.

<div class="flex">
  <input type="radio" name="hs-default-radio" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-default-radio">
  <label for="hs-default-radio" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Default radio</label>
</div>

<div class="flex">
  <input type="radio" name="hs-default-radio" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checked-radio" checked="">
  <label for="hs-checked-radio" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Checked radio</label>
</div>

Disabled
Disabled radio.

<div class="flex opacity-40">
  <input type="radio" name="hs-disabled-radio" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-disabled-radio" disabled="">
  <label for="hs-disabled-radio" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Disabled radio</label>
</div>

<div class="flex opacity-40">
  <input type="radio" name="hs-disabled-radio" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-disabled-checked-radio" checked="" disabled="">
  <label for="hs-disabled-checked-radio" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Disabled checked radio</label>
</div>

Inline radio group
A group of radio components.

<div class="flex gap-x-6">
  <div class="flex">
    <input type="radio" name="hs-radio-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-group-1" checked="">
    <label for="hs-radio-group-1" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Apple</label>
  </div>

  <div class="flex">
    <input type="radio" name="hs-radio-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-group-2">
    <label for="hs-radio-group-2" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Pear</label>
  </div>

  <div class="flex">
    <input type="radio" name="hs-radio-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-group-3">
    <label for="hs-radio-group-3" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Orange</label>
  </div>
</div>

Vertical radio group
A vertical group of radio components.

<div class="flex flex-col gap-y-3">
  <div class="flex">
    <input type="radio" name="hs-radio-vertical-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-vertical-group-1" checked="">
    <label for="hs-radio-vertical-group-1" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Apple</label>
  </div>

  <div class="flex">
    <input type="radio" name="hs-radio-vertical-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-vertical-group-2">
    <label for="hs-radio-vertical-group-2" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Pear</label>
  </div>

  <div class="flex">
    <input type="radio" name="hs-radio-vertical-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-vertical-group-3">
    <label for="hs-radio-vertical-group-3" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Orange</label>
  </div>
</div>

List with description

<div class="grid space-y-3">
  <div class="relative flex items-start">
    <div class="flex items-center h-5 mt-1">
      <input id="hs-radio-delete" name="hs-radio-with-description" type="radio" class="border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" aria-describedby="hs-radio-delete-description" checked="">
    </div>
    <label for="hs-radio-delete" class="ms-3">
      <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-300">Delete</span>
      <span id="hs-radio-delete-description" class="block text-sm text-gray-600 dark:text-neutral-500">Notify me when this action happens.</span>
    </label>
  </div>

  <div class="relative flex items-start">
    <div class="flex items-center h-5 mt-1">
      <input id="hs-radio-archive" name="hs-radio-with-description" type="radio" class="border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" aria-describedby="hs-radio-archive-description">
    </div>
    <label for="hs-radio-archive" class="ms-3">
      <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-300">Archive</span>
      <span id="hs-radio-archive-description" class="block text-sm text-gray-600 dark:text-neutral-500">Notify me when this action happens.</span>
    </label>
  </div>
</div>

Radio within form input
Radio components within form input stacked in a grid format.

<div class="grid sm:grid-cols-2 gap-2">
  <label for="hs-radio-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
    <input type="radio" name="hs-radio-in-form" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-in-form">
    <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Default radio</span>
  </label>

  <label for="hs-radio-checked-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
    <input type="radio" name="hs-radio-in-form" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-checked-in-form" checked="">
    <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Checked radio</span>
  </label>
</div>

Checkbox components within form input vertically grouped.

<div class="grid sm:grid-cols-2 gap-2">
  <label for="hs-radio-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
    <input type="radio" name="hs-radio-in-form" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-in-form">
    <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Default radio</span>
  </label>

  <label for="hs-radio-checked-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
    <input type="radio" name="hs-radio-in-form" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-checked-in-form" checked="">
    <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Checked radio</span>
  </label>
</div>

Validation states New
It provides valuable, actionable feedback to your users with HTML5 form validation.

<div>
  <label for="hs-error-radio" class="flex items-center space-x-3">
    <input type="radio" name="hs-states-radio" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-red-600 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-red-500 dark:checked:border-red-500 dark:focus:ring-offset-gray-800" id="hs-error-radio" disabled="">
    <span class="text-sm text-red-500">This is an error radio</span>
  </label>
</div>

<div>
  <label for="hs-success-radio" class="flex items-center space-x-3">
    <input type="radio" name="hs-states-radio" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-teal-600 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-teal-500 dark:checked:border-teal-500 dark:focus:ring-offset-gray-800" id="hs-success-radio" checked="">
    <span class="text-sm text-teal-500">This is a success radio</span>
  </label>
</div>


### 28. Listado de Switch/Toggle ###

Example
The default form of a toggle.

<label for="hs-basic-usage" class="relative inline-block w-11 h-6 cursor-pointer">
  <input type="checkbox" id="hs-basic-usage" class="peer sr-only">
  <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
  <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
</label>

With description
The basic usage with description.

<div class="flex items-center gap-x-3">
  <label for="hs-basic-with-description-unchecked" class="relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-basic-with-description-unchecked" class="peer sr-only">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-basic-with-description-unchecked" class="text-sm text-gray-500 dark:text-neutral-400">Unchecked</label>
</div>

<div class="flex items-center gap-x-3">
  <label for="hs-basic-with-description-checked" class="relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-basic-with-description-checked" class="peer sr-only" checked="">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-basic-with-description-checked" class="text-sm text-gray-500 dark:text-neutral-400">Checked</label>
</div>

<div class="flex items-center gap-x-3">
  <label for="hs-basic-with-description" class="text-sm text-gray-500 dark:text-neutral-400">Off</label>
  <label for="hs-basic-with-description" class="relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-basic-with-description" class="peer sr-only">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-basic-with-description" class="text-sm text-gray-500 dark:text-neutral-400">On</label>
</div>

Disabled
Disabled switch.

<div class="flex items-center gap-x-3">
  <label for="hs-basic-disabled-with-description-unchecked" class="relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-basic-disabled-with-description-unchecked" class="peer sr-only" disabled="">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-basic-disabled-with-description-unchecked" class="text-sm text-gray-500 dark:text-neutral-400">Unchecked</label>
</div>

<div class="flex items-center gap-x-3">
  <label for="hs-basic-disabled-with-description-checked" class="relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-basic-disabled-with-description-checked" class="peer sr-only" disabled="" checked="">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-basic-disabled-with-description-checked" class="text-sm text-gray-500 dark:text-neutral-400">Checked</label>
</div>

<div class="flex items-center gap-x-3">
  <label for="hs-basic-disabled-with-description" class="text-sm text-gray-500 dark:text-neutral-400">Off</label>
  <label for="hs-basic-disabled-with-description" class="relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-basic-disabled-with-description" class="peer sr-only" disabled="">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-basic-disabled-with-description" class="text-sm text-gray-500 dark:text-neutral-400">On</label>
</div>

Sizes New
Switches stacked small to large sizes.

<div class="flex items-center gap-x-3">
  <label for="hs-xs-switch" class="relative inline-block w-9 h-5 cursor-pointer">
    <input type="checkbox" id="hs-xs-switch" class="peer sr-only">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-4 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-xs-switch" class="text-sm text-gray-500 dark:text-neutral-400">Extra small</label>
</div>

<div class="flex items-center gap-x-3">
  <label for="hs-sm-switch" class="relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-sm-switch" class="peer sr-only">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-sm-switch" class="text-sm text-gray-500 dark:text-neutral-400">Small</label>
</div>

<div class="flex items-center gap-x-3">
  <label for="hs-md-switch" class="relative inline-block w-13 h-7 cursor-pointer">
    <input type="checkbox" id="hs-md-switch" class="peer sr-only">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-6 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-md-switch" class="text-sm text-gray-500 dark:text-neutral-400">Medium</label>
</div>

<div class="flex items-center gap-x-3">
  <label for="hs-lg-switch" class="relative inline-block w-15 h-8 cursor-pointer">
    <input type="checkbox" id="hs-lg-switch" class="peer sr-only">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-7 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-lg-switch" class="text-sm text-gray-500 dark:text-neutral-400">Large</label>
</div>

Soft color variant New
Soft style switch options.

<div class="flex items-center">
  <label for="hs-small-switch-soft" class="relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-small-switch-soft" class="peer sr-only">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-100 dark:bg-neutral-700 dark:peer-checked:bg-blue-800/50 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:bg-blue-600 peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-blue-500"></span>
  </label>
</div>

<div class="flex items-center">
  <label for="hs-medium-switch-soft" class="relative inline-block w-13 h-7 cursor-pointer">
    <input type="checkbox" id="hs-medium-switch-soft" class="peer sr-only">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-100 dark:bg-neutral-700 dark:peer-checked:bg-blue-800/50 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-6 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:bg-blue-600 peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-blue-500"></span>
  </label>
</div>

<div class="flex items-center">
  <label for="hs-large-switch-soft" class="relative inline-block w-15 h-8 cursor-pointer">
    <input type="checkbox" id="hs-large-switch-soft" class="peer sr-only">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-100 dark:bg-neutral-700 dark:peer-checked:bg-blue-800/50 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-7 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:bg-blue-600 peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-blue-500"></span>
  </label>
</div>

With tooltip
In this example we have added a tooltip to the switcher.
(deja este pendiente para cuando este tooltip)

<div class="hs-tooltip flex items-center gap-x-3">
  <label for="hs-tooltip-example" class="hs-tooltip-toggle relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-tooltip-example" class="peer sr-only">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-tooltip-example" class="text-sm text-gray-500 dark:text-neutral-400">Allow push notifications</label>
  <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700" role="tooltip">
    Enable push notifications
  </div>
</div>

Validation states
It provides valuable, actionable feedback to your users with HTML5 form validation.

<div class="flex items-center gap-x-3">
  <label for="hs-valid-toggle-switch" class="relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-valid-toggle-switch" class="peer sr-only" checked="">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-teal-600 dark:bg-neutral-700 dark:peer-checked:bg-teal-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-valid-toggle-switch" class="text-sm text-gray-500 dark:text-neutral-400">Valid switch</label>
</div>

<div class="flex items-center gap-x-3">
  <label for="hs-invalid-toggle-switch" class="relative inline-block w-11 h-6 cursor-pointer">
    <input type="checkbox" id="hs-invalid-toggle-switch" class="peer sr-only" checked="">
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-red-600 dark:bg-neutral-700 dark:peer-checked:bg-red-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
  </label>
  <label for="hs-invalid-toggle-switch" class="text-sm text-gray-500 dark:text-neutral-400">Invalid switch</label>
</div>

### 29. Listado de Select ###

Example
Custom styles are limited to the <select>'s initial appearance and cannot modify the <option>s due to browser limitations.

<select class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
  <option selected="">Open this select menu</option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>

Gray input
Gray select variant.

<select class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600">
  <option selected="">Open this select menu</option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>

Sizes
Selects stacked small to large sizes.

<select class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
  <option selected="">Open this select menu</option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>

<select class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
  <option selected="">Open this select menu</option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>

<select class="sm:p-5 p-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
  <option selected="">Open this select menu</option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>

Disabled
Disabled input.

<select class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" disabled="">
  <option selected="">Open this select menu</option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>

<select class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" disabled="">
  <option selected="">Open this select menu</option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>

Label
Basic input example with label.

<label for="hs-select-label" class="block text-sm font-medium mb-2 dark:text-white">Label</label>
<select id="hs-select-label" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
  <option selected="">Open this select menu</option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>

Validation states
It provides valuable, actionable feedback to your users with HTML5 form validation.

<div>
  <label for="select-1" class="block text-sm font-medium mb-2 dark:text-white">Label</label>
  <div class="relative">
    <select id="select-1" class="py-3 px-4 pe-16 block w-full border-red-500 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
      <option selected="">Open this select menu</option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
    </select>
    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-8">
      <svg class="shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" x2="12" y1="8" y2="12"></line>
        <line x1="12" x2="12.01" y1="16" y2="16"></line>
      </svg>
    </div>
  </div>
  <p class="text-sm text-red-600 mt-2">Please select a valid state.</p>
</div>

<div>
  <label for="select-2" class="block text-sm font-medium mb-2 dark:text-white">Label</label>
  <div class="relative">
    <select id="select-2" class="py-3 px-4 pe-16 block w-full border-teal-500 rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
      <option>Open this select menu</option>
      <option selected="">1</option>
      <option>2</option>
      <option>3</option>
    </select>
    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-8">
      <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </div>
  </div>
  <p class="text-sm text-teal-600 mt-2">Looks good!</p>
</div>

### 30. Listado de Time Picker ###

Custom style
Basic time picker with custom style example.Custom style
Basic time picker with custom style example.

<!-- Time Picker -->
<div class="max-w-32">
  <div class="relative w-full">
    <input type="text" class="py-2.5 sm:py-3 ps-4 pe-12 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:placeholder-neutral-400 dark:focus:ring-neutral-600" placeholder="hh:mm aa">

    <div class="absolute inset-y-0 end-0 flex items-center pe-3">
      <!-- Dropdown -->
      <div class="hs-dropdown [--auto-close:inside] relative inline-flex">
        <button id="hs-custom-style-time-picker" type="button" class="hs-dropdown-toggle size-7 shrink-0 inline-flex justify-center items-center rounded-full bg-white text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:text-neutral-200 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
          <span class="sr-only">Dropdown</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
          </svg>
        </button>

        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-30 bg-white border border-gray-200 shadow-xl rounded-lg mt-2 dark:bg-neutral-800 dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full" role="menu" aria-orientation="vertical" aria-labelledby="hs-custom-style-time-picker">
          <div class="flex flex-row divide-x divide-gray-200 dark:divide-neutral-700">
            <!-- Hours -->
            <div class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
              <!-- Checkbox -->
              <label for="hs-cbchlhh00" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh00" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  00
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh01" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh01" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  01
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh02" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh02" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  02
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh03" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh03" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  03
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh04" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh04" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  04
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh05" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh05" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  05
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh06" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh06" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  06
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh07" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh07" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  07
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh08" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh08" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  08
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh09" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh09" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  09
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh10" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh10" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  10
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh11" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh11" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  11
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh12" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh12" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  12
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh13" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh13" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  13
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh14" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh14" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  14
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh15" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh15" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  15
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh16" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh16" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  16
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh17" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh17" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  17
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh18" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh18" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  18
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh19" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh19" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  19
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh20" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh20" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  20
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh21" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh21" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  21
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh22" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh22" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  22
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlhh23" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlhh23" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlhh">
                <span class="block">
                  23
                </span>
              </label>
              <!-- End Checkbox -->
            </div>
            <!-- End Hours -->

            <!-- Minutes -->
            <div class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
              <!-- Checkbox -->
              <label for="hs-cbchlmm00" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm00" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  00
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm01" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm01" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  01
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm02" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm02" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  02
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm03" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm03" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  03
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm04" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm04" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  04
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm05" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm05" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  05
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm06" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm06" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  06
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm07" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm07" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  07
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm08" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm08" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  08
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm09" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm09" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  09
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm10" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm10" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  10
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm11" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm11" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  11
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm12" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm12" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  12
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm13" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm13" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  13
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm14" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm14" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  14
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm15" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm15" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  15
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm16" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm16" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  16
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm17" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm17" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  17
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm18" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm18" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  18
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm19" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm19" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  19
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm20" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm20" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  20
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm21" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm21" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  21
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm22" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm22" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  22
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlmm23" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlmm23" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlmm">
                <span class="block">
                  23
                </span>
              </label>
              <!-- End Checkbox -->
            </div>
            <!-- End Minutes -->

            <!-- 12-Hour Clock System -->
            <div class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
              <!-- Checkbox -->
              <label for="hs-cbchlcsam" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlcsam" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlcs">
                <span class="block">
                  AM
                </span>
              </label>
              <!-- End Checkbox -->
              <!-- Checkbox -->
              <label for="hs-cbchlcspm" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
              has-checked:text-white dark:has-checked:text-white
              has-checked:bg-blue-600 dark:has-checked:bg-blue-500
              has-disabled:pointer-events-none
              has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
              has-disabled:after:absolute
              has-disabled:after:inset-0
              has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
              dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                <input type="radio" id="hs-cbchlcspm" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="hs-cbchlcs">
                <span class="block">
                  PM
                </span>
              </label>
              <!-- End Checkbox -->
            </div>
            <!-- End 12-Hour Clock System -->
          </div>

          <!-- Footer -->
          <div class="py-2 px-3 flex flex-wrap justify-between items-center gap-2 border-t border-gray-200 dark:border-neutral-700">
            <button type="button" class="text-[13px] font-medium rounded-md bg-white text-blue-600 hover:text-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:text-blue-700 dark:bg-neutral-800 dark:text-blue-500 dark:hover:text-blue-600 dark:focus:text-blue-600">
              Now
            </button>
            <button type="button" class="py-1 px-2.5 text-[13px] font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:ring-2 focus:ring-blue-500">
              OK
            </button>
          </div>
          <!-- End Footer -->
        </div>
      </div>
      <!-- End Dropdown -->
    </div>
  </div>
</div>
<!-- End Time Picker -->