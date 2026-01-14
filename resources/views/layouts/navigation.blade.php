<nav class="bg-white border-b border-gray-100 transition-all duration-200" :class="sidebarOpen ? 'lg:pl-72' : 'lg:pl-0'">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-2">
				<button
                    type="button"
                    @click="sidebarOpen = true"
					x-show="!sidebarOpen"
					x-transition.opacity
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400"
                    aria-label="Abrir menú"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
					<img
						src="{{ asset('images/logo-bomberos.png') }}"
						alt="Bomberos La Tebaida"
						class="w-10 h-10 object-contain"
					/>
				</a>
            </div>
            <div class="flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md
                                       text-gray-600 bg-red hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

        </div>
    </div>
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        @keydown.window.escape="sidebarOpen = false"
        style="display:none;"
    ></div>
    <aside
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed left-0 top-0 z-50 h-full w-72 bg-white shadow-xl border-r h-screen overflow-y-auto"
        style="display:none;"
        role="dialog"
        aria-modal="true"
    >
        <div class="h-16 flex items-center justify-between px-4 border-b">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-bomberos.png') }}" class="w-8 h-8 object-contain" alt="Logo">
                <div class="leading-tight">
                    <div class="font-semibold">Bomberos</div>
                    <div class="text-xs text-gray-500">La Tebaida</div>
                </div>
            </div>

            <button @click="sidebarOpen=false" class="p-2 rounded hover:bg-gray-100" aria-label="Cerrar menú">
                ✕
            </button>
        </div>
        <div class="p-4 border-b">
            <div class="text-sm text-gray-500">Sesión</div>
            <div class="font-medium">{{ Auth::user()->name }}</div>
            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
        </div>
        <nav class="p-3 space-y-1">
            <div class="px-2 py-2 text-xs font-semibold text-gray-400 uppercase">
                Módulos
            </div>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100 font-semibold' : '' }}">
                <span class="w-5 text-center">🏠</span>
                <span>Inicio</span>
            </a>

            <a href="{{ route('modules.vehicle-preoperational-checks.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('preoperacional.*') ? 'bg-gray-100 font-semibold' : '' }}">
                <span class="w-5 text-center">🚒</span>
                <span>Preoperacional Vehículos</span>
            </a>

            <a href="{{ route('admin.supplies.index') }}"
			   class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.supplies.*') ? 'bg-gray-100 font-semibold' : '' }}">
				<span class="w-5 text-center">📦</span>
				<span>Inventario de Insumos</span>
			</a>
			<div x-data="{ openFormats: {{ request()->is('formatos/*') ? 'true' : 'false' }} }" class="space-y-1">
				<button
					type="button"
					@click="openFormats = !openFormats"
					class="w-full flex items-center justify-between px-3 py-2 rounded-md hover:bg-gray-100
						   {{ request()->is('formatos/*') ? 'bg-gray-100 font-semibold' : '' }}"
				>
					<span class="flex items-center gap-3">
						<span class="w-5 text-center">📄</span>
						<span>Formatos</span>
					</span>
					<svg class="w-4 h-4 text-gray-500 transform transition"
						 :class="openFormats ? 'rotate-180' : ''"
						 fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
					</svg>
				</button>

				<div x-show="openFormats" x-collapse class="pl-9 space-y-1">
					<a
						href="{{ route('formats.vehicle-inventories.index') }}"
						class="block px-3 py-2 rounded-md hover:bg-gray-100
							   {{ request()->routeIs('formats.vehicle-inventories.index.*') ? 'bg-gray-100 font-semibold' : '' }}"
					>
						Inventario por vehículo
					</a>

					<a
						href="{{ route('formats.vehicle-environment-logs.index') }}"
						class="block px-3 py-2 rounded-md hover:bg-gray-100
							   {{ request()->routeIs('formats.vehicle-inventories.index.*') ? 'bg-gray-100 font-semibold' : '' }}"
					>
						Temperatura - Humedad Vehículos
					</a>
					<a
						href="{{ route('formats.vehicle-shift-handoffs.index') }}"
						class="block px-3 py-2 rounded-md hover:bg-gray-100
							   {{ request()->routeIs('formats.vehicle-inventories.index.*') ? 'bg-gray-100 font-semibold' : '' }}"
					>
						Entrega de turno
					</a>
					<a
						href="{{ route('formats.vehicle-cleanings.index') }}"
						class="block px-3 py-2 rounded-md hover:bg-gray-100
							   {{ request()->routeIs('formats.vehicle-inventories.index.*') ? 'bg-gray-100 font-semibold' : '' }}"
					>
						Formato aseo
					</a>
					<a
						href="{{ route('formats.patient-records.index') }}"
						class="block px-3 py-2 rounded-md hover:bg-gray-100
							   {{ request()->routeIs('formats.vehicle-inventories.index.*') ? 'bg-gray-100 font-semibold' : '' }}"
					>
						Registro pacientes
					</a>
					@hasanyrole('admin|operativo')
					<a
						href="{{ route('formats.vehicle-exit-reports.index') }}"
						class="block px-3 py-2 rounded-md hover:bg-gray-100
							   {{ request()->routeIs('formats.vehicle-inventories.index.*') ? 'bg-gray-100 font-semibold' : '' }}"
					>
						Informe salida vehicular
					</a>
					@endhasanyrole
					@hasanyrole('admin|conductor|operativo')
					<a
						href="{{ route('formats.vehicle-exit-reports.pending') }}"
						class="block px-3 py-2 rounded-md hover:bg-gray-100
							   {{ request()->routeIs('formats.vehicle-inventories.index.*') ? 'bg-gray-100 font-semibold' : '' }}"
					>
						Mis informes pendientes
					</a>
					@endhasanyrole
					<a href="{{ route('formats.patient-care-forms.index') }}"
					   class="block px-3 py-2 rounded-md hover:bg-gray-100">
					   Formulario atención pacientes
					</a>
				</div>
            @role('admin')
                <div class="px-2 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">
                    Administración
                </div>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('users.*') ? 'bg-gray-100 font-semibold' : '' }}">
                    <span class="w-5 text-center">👥</span>
                    <span>Usuarios</span>
                </a>
				<a href="{{ route('admin.vehicles.index') }}"
				   class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.vehicles.*') ? 'bg-gray-100 font-semibold' : '' }}">
				  <span class="w-5 text-center">🚑</span>
				  <span>Vehículos</span>
				</a>
                <a href="{{ route('admin.access-logs.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.access-logs.*') ? 'bg-gray-100 font-semibold' : '' }}">
                    <span class="w-5 text-center">🛡️</span>
                    <span>Logs de Acceso</span>
                </a>
            @endrole
        </nav>
    </aside>
</nav>
