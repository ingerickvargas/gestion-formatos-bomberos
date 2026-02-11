<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md">Nuevo</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
						<div class="p-6 border-b">
							<p class="text-sm text-gray-600">
								Total (página): {{ $users->count() }} — Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }}
							</p>
						</div>
                        <table class="min-w-full text-sm">
                            <thead class="bg-red-600 text-white">
                                <tr class="text-left border-b">
                                    <th class="py-2 pr-4">Nombre</th>
                                    <th class="py-2 pr-4">Documento</th>
                                    <th class="py-2 pr-4">Email</th>
                                    <th class="py-2 pr-4">Rol</th>
                                    <th class="py-2 pr-4">Estado</th>
                                    <th class="py-2 pr-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="border-b">
                                        <td class="py-2 pr-4">{{ $user->first_name ?? $user->name }} {{ $user->last_name ?? '' }}</td>
                                        <td class="py-2 pr-4">{{ $user->document ?? '-' }}</td>
                                        <td class="py-2 pr-4">{{ $user->email }}</td>
                                        <td class="py-2 pr-4">{{ $user->roles->pluck('name')->join(', ') ?: '-' }}</td>
                                        <td class="py-2 pr-4">
                                            @php($active = $user->active ?? true)
                                            <span class="px-2 py-1 rounded text-xs {{ $active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $active ? 'Activo' : 'Inactivo' }}</span>
                                        </td>
                                        <td class="py-2 pr-4">
                                            <a class="text-indigo-600 hover:underline" href="{{ route('admin.users.edit', $user) }}">Editar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-4" colspan="6">No hay usuarios registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
