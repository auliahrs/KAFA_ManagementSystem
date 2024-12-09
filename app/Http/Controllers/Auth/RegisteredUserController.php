<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'phoneNum' => ['required', 'string', 'max:20'],
        'role' => ['required', 'string'],
        'icNum' => ['required', 'string', 'max:20'],
        'address' => ['required', 'string', 'max:255'],
        'gender' => ['required', Rule::in(['male', 'female', 'other'])],
        'race' => ['required', 'string', 'max:50'],
        'age' => ['required', 'integer', 'min:0'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);
    
    // Determine the status based on the role
    $status = $request->role === 'teacher' ? 'processing' : 'approved';

    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'phoneNum' => $request->phoneNum,
        'role' => $request->role,
        'icNum' => $request->icNum,
        'address' => $request->address,
        'gender' => $request->gender,
        'race' => $request->race,
        'age' => $request->age,
        'status' => $status,
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    Auth::login($user);

    if($request->user()->role == 'kafa')
        {
            return redirect(route('kafa.manageActivity'));
        }
        elseif($request->user()->role == 'muip')
        {
            return redirect(route('muip.manageActivity'));
        }
        elseif($request->user()->role == 'guardian')
        {
            return redirect(route('guardian.manageActivity'));
        }
        elseif($request->user()->role == 'teacher')
        {
            return redirect(route('teacher.manageActivity'));
        }
}
}
