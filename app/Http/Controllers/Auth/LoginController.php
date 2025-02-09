<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        // Validate the user input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials, $request->remember)) {
            // Regenerate session to prevent fixation attacks
            $request->session()->regenerate();

            // Redirect user based on their role
            return $this->redirectBasedOnRole();
        }

        // If login fails, return back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out!');
    }

    /**
     * Redirect user based on their role.
     */
    protected function redirectBasedOnRole()
    {
        $user = Auth::user();

        switch ($user->role->name) {
            case "Admin":
                return redirect()->route('admin.dashboard');
            case "Teacher":
                return redirect()->route('teacher.dashboard');
            case "Student":
                return redirect()->route('student.dashboard');
            case "Parent":
                return redirect()->route('parent.dashboard');
            default:
                return redirect('/');
        }
    }
}
