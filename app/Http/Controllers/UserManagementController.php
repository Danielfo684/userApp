<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(middleware: 'auth');
        //$this->middleware(middleware: 'check.role:admin');
    }

    public function index()
    {
        $users = User::where('id', '!=', 1)->get();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (auth()->user()->id !== 1 && $user->id === 1) {
            return redirect()->route('users.index');
        }
        return view('users.edit', compact('user'));
    }

    public function destroy(User $user)
    {
        if (auth()->user()->id === $user->id || $user->id === 1) {
            return redirect()->route('users.index');
        }
        $user->delete();
        return redirect()->route('users.index');
    }
        
    public function create()
    {
        return view('users.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:user,admin'],
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
    
        return redirect()->route('users.index')
            ->with('status', 'Usuario creado correctamente');
    }
    
    public function update(Request $request, User $user)
    {
        if (auth()->user()->id !== 1 && $user->id === 1) {
            return redirect()->route('users.index');
        }
    
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:user,admin'],
        ]);
    
        $user->update($request->only(['name', 'email', 'role']));
        
        return redirect()->route('users.index')
            ->with('status', 'Usuario actualizado correctamente');
    }
}