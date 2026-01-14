<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear usuario
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="first_name" value="Nombres" />
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                                              value="{{ old('first_name') }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>

                            <div>
                                <x-input-label for="last_name" value="Apellidos" />
                                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                                              value="{{ old('last_name') }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                            </div>

                            <div>
                                <x-input-label for="document" value="Cédula" />
                                <x-text-input id="document" name="document" type="text" class="mt-1 block w-full"
                                              value="{{ old('document') }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('document')" />
                            </div>

                            <div>
                                <x-input-label for="phone" value="Teléfono" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                              value="{{ old('phone') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="email" value="Email" />
                                <x-text-input id="email" name="email" type="email" autocomplete="off" class="mt-1 block w-full"
                                              value="{{ old('email') }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="role" value="Rol" />
                                <select id="role" name="role"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <option value="">Seleccione...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" @selected(old('role') === $role->name)>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('role')" />
                            </div>

                            <div>
                                <x-input-label for="password" value="Contraseña" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded border bg-sky-800 text-white">Cancelar</a>
                            <button class="px-4 py-2 bg-red-600 text-white rounded">Guardar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
