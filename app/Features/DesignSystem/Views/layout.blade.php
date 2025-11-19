<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Design System') - Liniu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brandWhite-50 min-h-screen">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-brandNeutral-50 flex-shrink-0 overflow-y-auto">
            <!-- Header del Sidebar -->
            <div class="p-6 border-b border-brandNeutral-50">
                <h4 class="h4 text-brandNeutral-400">Design System</h4>
                <p class="caption text-brandNeutral-200 mt-1">Powered by Preline UI</p>
                <div class="flex gap-2 mt-2">
                    <span class="caption bg-brandWarning-50 text-brandWarning-300 px-2 py-1 rounded-full border border-brandWarning-200">
                        LOCAL
                    </span>
                    <span class="caption bg-brandSuccess-50 text-brandSuccess-300 px-2 py-1 rounded-full border border-brandSuccess-200">
                        Preline
                    </span>
                </div>
            </div>

            <!-- Navegación -->
            <nav class="p-4">
                <ul class="space-y-1">
                    <!-- Fundamentos -->
                    <li class="mb-4">
                        <p class="caption-strong text-brandNeutral-300 px-3 py-2 uppercase tracking-wide">Fundamentos</p>
                        <ul class="space-y-1 mt-2">
                            <li>
                                <a href="{{ route('design-system.colores') }}" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.colores') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="palette" class="w-4 h-4"></i>
                                    <span class="body-small">Colores</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.tipografias') }}" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.tipografias') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="type" class="w-4 h-4"></i>
                                    <span class="body-small">Tipografías</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.estados') }}" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.estados') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="toggle-left" class="w-4 h-4"></i>
                                    <span class="body-small">Estados</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.iconos') }}" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.iconos') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                                    <span class="body-small">Iconos</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <!-- Componentes Preline UI -->
                    <li class="mb-4">
                        <p class="caption-strong text-brandNeutral-300 px-3 py-2 uppercase tracking-wide">
                            Preline Components 
                            <span class="ml-2 text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Active</span>
                        </p>
                        <ul class="space-y-1 mt-2">
                            <li>
                                <a href="{{ route('design-system.inputs-preline') }}" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.inputs-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="type" class="w-4 h-4"></i>
                                    <span class="body-small">Inputs</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.alerts-preline') }}" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.alerts-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    <span class="body-small">Alerts</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.badges-preline') }}" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.badges-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="tag" class="w-4 h-4"></i>
                                    <span class="body-small">Badges</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.buttons-preline') }}" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.buttons-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="mouse-pointer-click" class="w-4 h-4"></i>
                                    <span class="body-small">Buttons</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.cards-preline') }}" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.cards-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="square" class="w-4 h-4"></i>
                                    <span class="body-small">Cards</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                                    <li>
                                        <a href="{{ route('design-system.datepicker-preline') }}"
                                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.datepicker-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                            <i data-lucide="calendar" class="w-4 h-4"></i>
                                            <span class="body-small">Datepicker</span>
                                            <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('design-system.lists-preline') }}"
                                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.lists-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                            <i data-lucide="list" class="w-4 h-4"></i>
                                            <span class="body-small">Lists</span>
                                            <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('design-system.listgroup-preline') }}"
                                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.listgroup-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                            <i data-lucide="list-ordered" class="w-4 h-4"></i>
                                            <span class="body-small">List Groups</span>
                                            <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('design-system.legend-preline') }}"
                                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.legend-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                            <i data-lucide="circle" class="w-4 h-4"></i>
                                            <span class="body-small">Legend Indicator</span>
                                            <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('design-system.progress-preline') }}"
                                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.progress-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                            <i data-lucide="gauge" class="w-4 h-4"></i>
                                            <span class="body-small">Progress</span>
                                            <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('design-system.fileupload-preline') }}"
                                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.fileupload-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                            <i data-lucide="upload" class="w-4 h-4"></i>
                                            <span class="body-small">File Uploading Progress</span>
                                            <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('design-system.ratings-preline') }}"
                                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.ratings-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                            <i data-lucide="star" class="w-4 h-4"></i>
                                            <span class="body-small">Ratings</span>
                                            <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('design-system.spinners-preline') }}"
                                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.spinners-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                            <i data-lucide="loader-2" class="w-4 h-4"></i>
                                            <span class="body-small">Spinners</span>
                                            <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                        </a>
                                    </li>
                            <li>
                                <a href="{{ route('design-system.toasts-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.toasts-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="bell" class="w-4 h-4"></i>
                                    <span class="body-small">Toasts</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.timeline-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.timeline-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="clock" class="w-4 h-4"></i>
                                    <span class="body-small">Timeline</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.navs-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.navs-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="menu" class="w-4 h-4"></i>
                                    <span class="body-small">Navs</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.tabs-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.tabs-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="layout-list" class="w-4 h-4"></i>
                                    <span class="body-small">Tabs</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.sidebar-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.sidebar-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="panel-left" class="w-4 h-4"></i>
                                    <span class="body-small">Sidebar</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.breadcrumb-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.breadcrumb-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    <span class="body-small">Breadcrumb</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.pagination-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.pagination-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="chevrons-left-right" class="w-4 h-4"></i>
                                    <span class="body-small">Pagination</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.stepper-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.stepper-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="arrow-right-left" class="w-4 h-4"></i>
                                    <span class="body-small">Stepper</span>
                                    <span class="ml-auto text-caption bg-brandWarning-200 text-white px-2 py-0.5 rounded-full">Pending</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.input-group-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.input-group-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="layers" class="w-4 h-4"></i>
                                    <span class="body-small">Input Groups</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.textarea-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.textarea-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                    <span class="body-small">Textarea</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.file-input-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.file-input-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="upload" class="w-4 h-4"></i>
                                    <span class="body-small">File Input</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.checkbox-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.checkbox-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="square-check" class="w-4 h-4"></i>
                                    <span class="body-small">Checkbox</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.radio-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.radio-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="circle-dot" class="w-4 h-4"></i>
                                    <span class="body-small">Radio</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.switch-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.switch-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="toggle-left" class="w-4 h-4"></i>
                                    <span class="body-small">Switch/Toggle</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.select-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.select-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                    <span class="body-small">Select</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.time-picker-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.time-picker-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="clock" class="w-4 h-4"></i>
                                    <span class="body-small">Time Picker</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.searchbox-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.searchbox-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="search" class="w-4 h-4"></i>
                                    <span class="body-small">Searchbox</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.input-number-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.input-number-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="hash" class="w-4 h-4"></i>
                                    <span class="body-small">Input Number</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.toggle-password-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.toggle-password-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    <span class="body-small">Toggle Password</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.copy-markup-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.copy-markup-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="copy-plus" class="w-4 h-4"></i>
                                    <span class="body-small">Copy Markup</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.pin-input-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.pin-input-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="hash" class="w-4 h-4"></i>
                                    <span class="body-small">PIN Input</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.dropdown-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.dropdown-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                    <span class="body-small">Dropdown</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.modal-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.modal-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="square-slash" class="w-4 h-4"></i>
                                    <span class="body-small">Modal</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.popover-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.popover-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                    <span class="body-small">Popover</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.tooltip-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.tooltip-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="info" class="w-4 h-4"></i>
                                    <span class="body-small">Tooltip</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.table-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.table-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="table" class="w-4 h-4"></i>
                                    <span class="body-small">Table</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.chart-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.chart-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="bar-chart" class="w-4 h-4"></i>
                                    <span class="body-small">Charts</span>
                                    <span class="ml-auto text-caption bg-brandWarning-200 text-white px-2 py-0.5 rounded-full">Requires ApexCharts</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.clipboard-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.clipboard-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="clipboard" class="w-4 h-4"></i>
                                    <span class="body-small">Clipboard</span>
                                    <span class="ml-auto text-caption bg-brandSuccess-200 text-white px-2 py-0.5 rounded-full">Ready</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('design-system.file-upload-preline') }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('design-system.file-upload-preline') ? 'bg-brandPrimary-200 text-white' : 'text-brandNeutral-300 hover:bg-brandWhite-200' }}">
                                    <i data-lucide="upload" class="w-4 h-4"></i>
                                    <span class="body-small">File Upload</span>
                                    <span class="ml-auto text-caption bg-brandWarning-200 text-white px-2 py-0.5 rounded-full">Requires Dropzone</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors opacity-50 cursor-not-allowed text-brandNeutral-200">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                    <span class="body-small">Date Pickers</span>
                                    <span class="ml-auto text-caption bg-brandWarning-200 text-white px-2 py-0.5 rounded-full">Soon</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" 
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors opacity-50 cursor-not-allowed text-brandNeutral-200">
                                    <i data-lucide="upload" class="w-4 h-4"></i>
                                    <span class="body-small">File Upload</span>
                                    <span class="ml-auto text-caption bg-brandWarning-200 text-white px-2 py-0.5 rounded-full">Soon</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Footer del Sidebar -->
            <div class="p-4 border-t border-brandNeutral-50 mt-auto">
                <a href="{{ route('tenant.admin.dashboard', ['store' => request()->route('store') ?? 'default']) }}" 
                   class="flex items-center gap-2 text-brandPrimary-200 hover:text-brandPrimary-300 body-small transition-colors">
                    <x-lucide-arrow-left class="w-4 h-4" />
                    Volver al Dashboard
                </a>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header de la página -->
            <header class="bg-white border-b border-brandNeutral-50 px-8 py-6 sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 text-brandNeutral-400">@yield('page-title')</h4>
                        <p class="body-small text-brandNeutral-200 mt-1">@yield('page-description')</p>
                    </div>
                    @yield('page-actions')
                </div>
            </header>

            <!-- Contenido -->
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts que deben cargarse ANTES de Preline UI -->
    @stack('scripts-before-preline')
    
    <!-- Preline UI JavaScript -->
    <script src="{{ asset('js/preline.js') }}"></script>
    
    <!-- Scripts que se cargan DESPUÉS de Preline UI -->
    @stack('scripts')
    
    <script>
        // Inicializar Preline UI después de que todos los scripts se carguen
        (function() {
            function initPreline() {
                if (typeof window.HSStaticMethods !== 'undefined' && window.HSStaticMethods.autoInit) {
                    window.HSStaticMethods.autoInit();
                }
            }
            
            // Intentar múltiples veces para asegurar que Preline UI esté listo
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(initPreline, 100);
                });
            } else {
                setTimeout(initPreline, 100);
            }
            
            window.addEventListener('load', function() {
                setTimeout(initPreline, 200);
            });
        })();
    </script>
</body>
</html>

