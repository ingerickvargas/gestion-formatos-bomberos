<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar usuario</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium">Nombre</label>
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" value="{{ old('first_name', $user->first_name) }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium">Apellido</label>
                                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" value="{{ old('last_name', $user->last_name) }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                            </div>

                            <div>
                                <label for="document" class="block text-sm font-medium">Cédula</label>
                                <x-text-input id="document" name="document" type="text" class="mt-1 block w-full" value="{{ old('document', $user->document) }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('document')" />
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium">Teléfono</label>
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', $user->phone) }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium">Email</label>
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $user->email) }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium">Rol</label>
                                <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" @selected(old('role', $user->roles->first()?->name) === $role->name)>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('role')" />
                            </div>

                            <div>
                                <label for="active" class="block text-sm font-medium">Estado</label>
                                @if(auth()->id() !== $user->id)
                                    <select id="active" name="active" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="1" @selected((int)old('active', $user->active ?? 1) === 1)>Activo</option>
                                        <option value="0" @selected((int)old('active', $user->active ?? 1) === 0)>Inactivo</option>
                                    </select>
                                @else
                                    <p class="text-sm text-gray-500">No puedes desactivar tu propio usuario.</p>
                                @endif
                                <x-input-error class="mt-2" :messages="$errors->get('active')" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="password" class="block text-sm font-medium">Nueva contraseña (opcional)</label>
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Dejar en blanco para no cambiar" />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded border bg-sky-800 text-white">Cancelar</a>
                            <button class="px-4 py-2 bg-red-600 text-white rounded">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
