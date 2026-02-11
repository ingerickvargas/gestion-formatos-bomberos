<x-guest-layout>
    <div class="min-h-screen w-full relative overflow-hidden">
        <div class="absolute inset-0 bg-center bg-cover bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/login-bomberos.jpg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/5 via-black/55 to-black/70"></div>
        <div class="relative min-h-screen flex items-center justify-center px-4">
            <div class="w-full max-w-sm">
                <div class="bg-black/35 backdrop-blur-md border border-white/20 shadow-2xl rounded-xl px-8 py-10">
                    <div class="flex justify-center -mt-16 mb-3">
                        <div class="w-20 h-20 shadow-xl flex items-center justify-center">
                            <img src="{{ asset('images/logo-bomberos.png') }}" alt="Bomberos La Tebaida" class="w-26 h-26 object-contain" />
                        </div>
                    </div>

                    <h1 class="text-center text-white text-xl font-semibold mb-6">Sistema de gestión de formatos</h1>
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    @if($errors->any())
                        <div class="mb-4 text-sm text-red-200">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-white/90 text-sm font-medium mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Ingrese email" class="w-full bg-transparent text-white placeholder-white/50 border-0 border-b border-white/40 focus:border-blue-300 focus:ring-0 px-0 py-2" />
                        </div>

                        <div>
                            <label class="block text-white/90 text-sm font-medium mb-1">Contraseña</label>
                            <input type="password" name="password" required autocomplete="current-password" placeholder="Ingrese contraseña" class="w-full bg-transparent text-white placeholder-white/50 border-0 border-b border-white/40 focus:border-blue-300 focus:ring-0 px-0 py-2" />
                        </div>

                        <button type="submit" class="w-full mt-2 py-2.5 rounded-full bg-red-500 text-white font-semibold hover:bg-blue-600 transition">INICIAR SESIÓN</button>

                        <div class="flex items-center justify-between text-sm mt-2">
                            <label class="inline-flex items-center text-white/80">
                                <input type="checkbox" name="remember" class="rounded border-white/40 bg-white/10 text-blue-500 focus:ring-blue-400" />
                                <span class="ml-2">Recuérdame</span>
                            </label>
                        </div>
                    </form>
                </div>

                <p class="text-center text-white/60 text-xs mt-4">© {{ date('Y') }} Bomberos La Tebaida</p>
            </div>
        </div>
    </div>
</x-guest-layout>
