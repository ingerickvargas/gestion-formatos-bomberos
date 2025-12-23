<nav class="bg-white border-b border-gray-100">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-2">
                <button
                    type="button"
                    @click="sidebarOpen = true"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400"
                    aria-label="Abrir menú"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <img
					src="{{ asset('images/logo-bomberos.png') }}"
					alt="Bomberos La Tebaida"
					class="w-10 h-10 object-contain"
				/>
            </div>
            <div class="flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md
                                       text-gray-600 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
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
        class="fixed left-0 top-0 z-50 h-full w-72 bg-white shadow-xl border-r"
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
                <span>Dashboard</span>
            </a>

            <a href="{{ route('preoperacional.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('preoperacional.*') ? 'bg-gray-100 font-semibold' : '' }}">
                <span class="w-5 text-center">🚒</span>
                <span>Preoperacional Vehículos</span>
            </a>

            <a href="{{ route('inventario.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('inventario.*') ? 'bg-gray-100 font-semibold' : '' }}">
                <span class="w-5 text-center">📦</span>
                <span>Inventario de Insumos</span>
            </a>

            <a href="{{ route('formatos.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('formatos.*') ? 'bg-gray-100 font-semibold' : '' }}">
                <span class="w-5 text-center">📄</span>
                <span>Formatos</span>
            </a>

            @role('admin')
                <div class="px-2 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase">
                    Administración
                </div>

                <a href="{{ route('users.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('users.*') ? 'bg-gray-100 font-semibold' : '' }}">
                    <span class="w-5 text-center">👥</span>
                    <span>Usuarios</span>
                </a>

                <a href="{{ route('admin.access-logs.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.access-logs.*') ? 'bg-gray-100 font-semibold' : '' }}">
                    <span class="w-5 text-center">🛡️</span>
                    <span>Logs de Acceso</span>
                </a>
            @endrole
        </nav>
        <div class="absolute bottom-0 left-0 right-0 border-t p-3 text-xs text-gray-500">
            © {{ date('Y') }} Bomberos La Tebaida
        </div>
    </aside>
</nav>
