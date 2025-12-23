@php
    $modules = config('modules', []);
    $user = auth()->user();
@endphp

<div
    x-show="sidebarOpen"
    x-transition.opacity
    class="fixed inset-0 z-40 bg-black/50"
    @click="sidebarOpen = false"
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
>
    <div class="h-16 flex items-center justify-between px-4 border-b">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-bomberos.png') }}" class="w-8 h-8 object-contain" alt="Logo">
            <div class="leading-tight">
                <div class="font-semibold">Bomberos</div>
                <div class="text-xs text-gray-500">La Tebaida</div>
            </div>
        </div>

        <button @click="sidebarOpen=false" class="p-2 rounded hover:bg-gray-100">
            ✕
        </button>
    </div>

    <div class="p-4 border-b">
        <div class="text-sm text-gray-500">Sesión</div>
        <div class="font-medium">{{ $user->name }}</div>
        <div class="text-xs text-gray-500">{{ $user->email }}</div>
    </div>

    <nav class="p-3 space-y-1">
        <div class="px-2 py-2 text-xs font-semibold text-gray-400 uppercase">
            Módulos
        </div>

        @foreach($modules as $m)
            @php
                $canSee = method_exists($user, 'hasAnyRole')
                    ? $user->hasAnyRole($m['roles'])
                    : true;
            @endphp

            @if($canSee)
                <a
                    href="{{ route($m['route']) }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100
                           {{ request()->routeIs($m['route']) ? 'bg-gray-100 font-semibold' : '' }}"
                >
                    <span class="w-5 text-center">
                        {{-- Iconos simples (puedes mejorar luego con Heroicons) --}}
                        @switch($m['icon'])
                            @case('home') 🏠 @break
                            @case('truck') 🚒 @break
                            @case('box') 📦 @break
                            @case('file') 📄 @break
                            @case('users') 👥 @break
                            @case('shield') 🛡️ @break
                            @default 📌
                        @endswitch
                    </span>
                    <span>{{ $m['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    <div class="absolute bottom-0 left-0 right-0 border-t p-3 text-xs text-gray-500">
        © {{ date('Y') }} Bomberos La Tebaida
    </div>
</aside>
