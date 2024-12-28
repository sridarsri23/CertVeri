<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
class EditorController extends Controller
{
    public function index()
    {
        // Editor dashboard logic
       // return redirect()->intended('/certificates');
       //return view('certificates.editor-index');
       //dd($user = Auth::user());
       $certificates = Certificate::latest()->take(10)->orderBy('created_at', 'desc')->get();   
            // return view('certificates.index', compact('certificates'));
      // $certificates = Certificate::all();
       return view('certificates.index', compact('certificates'));
    }
    
    public function login()
    {
        return view('auth.editor-login');
    }
    
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Log user login activity
            $user = Auth::user();
            $this->logUserActivity("Editor Logged In: " . $user->email);

           // return redirect()->intended('/editor/index');
            $certificates = Certificate::all();
              return view('certificates.index', compact('certificates'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our recordss.',
        ]);
    }
    
    public function logout(Request $request)
    {
        // Log user logout activity
        $user = Auth::user();
        $this->logUserActivity("Editor Logged Out: " . $user->email);
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('auth.editor-login');
    }
    
    private function logUserActivity($message)
    {
        // Log user activity to Laravel log
        \Illuminate\Support\Facades\Log::info($message);
    }
}
