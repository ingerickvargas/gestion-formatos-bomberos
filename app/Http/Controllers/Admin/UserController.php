<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
	public function index()
	{
		$users = User::with('roles')->paginate(10);
		return view('admin.users.index', compact('users'));
	}

	public function create()
	{
		$roles = Role::all();
		return view('admin.users.create', compact('roles'));
	}
	
	public function edit(User $user)
	{
		$roles = Role::all();
		return view('admin.users.edit', compact('user', 'roles'));
	}


	public function store(Request $request)
	{
		$data = $request->validate([
			'first_name' => 'required',
			'last_name' => 'required',
			'document' => 'required|unique:users',
			'email' => 'required|email|unique:users',
			'phone' => 'nullable',
			'password' => 'required|min:6',
			'role' => 'required'
		]);
		
		$creatorId = auth()->id();

		$user = User::create([
		'name'       => trim($data['first_name'].' '.$data['last_name']),
        'first_name' => $data['first_name'],
        'last_name'  => $data['last_name'],
        'document'   => $data['document'],
        'phone'      => $data['phone'] ?? null,
        'email'      => $data['email'],
        'password'   => bcrypt($data['password']),
        'active'     => true,
		'created_by' => $creatorId,
		'updated_by' => $creatorId,
		]);

		$user->syncRoles([$data['role']]);

		return redirect()->route('admin.users.index')->with('success', 'Usuario creado');
	}
	
	public function update(Request $request, User $user)
	{
		$data = $request->validate([
			'first_name' => ['required', 'string', 'max:120'],
			'last_name'  => ['required', 'string', 'max:120'],
			'document'   => ['required', 'string', 'max:30', 'unique:users,document,' . $user->id],
			'phone'      => ['nullable', 'string', 'max:30'],
			'email'      => ['required', 'email', 'max:190', 'unique:users,email,' . $user->id],
			'role'       => ['required', 'string', 'exists:roles,name'],
			'active'     => ['nullable', 'boolean'],
			'password'   => ['nullable', 'string', 'min:6'],
		]);
		
		$data['name'] = trim($data['first_name'] . ' ' . $data['last_name']);

		if (!empty($data['password'])) {
			$data['password'] = bcrypt($data['password']);
		} else {
			unset($data['password']);
		}
		
		if ($user->id === auth()->id()) {
			unset($data['active']);
		} else {
			if (!array_key_exists('active', $data)) {
				unset($data['active']);
			}
		}
		$data['updated_by'] = auth()->id();
		$wasActive = (bool) $user->active;
		$newActive = array_key_exists('active', $data) ? (bool)$data['active'] : $wasActive;

		if ($wasActive === true && $newActive === false) {
			$data['disabled_by'] = auth()->id();
			$data['disabled_at'] = now();
		}

		$user->update([
        'name'       => $data['name'],
        'first_name' => $data['first_name'],
        'last_name'  => $data['last_name'],
        'document'   => $data['document'],
        'phone'      => $data['phone'] ?? null,
        'email'      => $data['email'],
        'active'     => $data['active'] ?? $user->active,
        ... (isset($data['password']) ? ['password' => $data['password']] : []),
    ]);

		$user->syncRoles([$data['role']]);

		return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado');
	}

}
