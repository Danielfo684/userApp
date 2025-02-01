<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\AdminMiddleware;


class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(middleware: 'auth');
        $this->middleware(AdminMiddleware::class);
        // $this->middleware([ 'auth', 'checkRole:admin']);

        }

    public function index(User $user)
    {
        // if ($user->role !== 'admin') {
        //     return redirect()->route('home')->with('error', 'You cannot access this page');
        // }
        $users = User::orderBy('id')->get();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if ($user->id  === 1) {
            return redirect()->back()->with('error', 'You cannot edit superadmin');
        }
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'You cannot access this page');
        }
        return view('users.edit', compact('user'));
    }

    public function destroy(User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('users.index');
        }
        $user->delete();
        return redirect()->route('users.index')->with('status', 'Usuario eliminado correctamente');;
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
            ->with('status', 'User created successfully');
    }
    
    public function verify (Request $request, User $user) {
        if ($user->id === 1) {
            return redirect()->back()->with('error', 'You cannot verify superadmin');
        }
        if ($user->email_verified_at !== null) {
            return redirect()->back()->with('error', 'User already verified');
        }
        $user->email_verified_at = now();
        $user->save();
        return redirect()->back()->with('status', 'Verified properly');


    }
    public function update(Request $request, User $user)
    {

        if ($user->id === 1) {
            return redirect()->back()->with('error', 'You cannot edit superadmin');

        }
 
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);
        $user->update($request->only(['name', 'email']));
        if ($request->has('role')) {
            $user->update($request->only('name', 'email', 'role'));
        }
        return redirect()->route('users.index')
            ->with('status', 'Usuario actualizado correctamente');
    }
}