<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function dd;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\Certificate;
class AdminController extends Controller
{
    public function index()
    {
        // Admin dashboard logic
      //  return redirect()->intended('/certificates');
      $certificates = Certificate::latest()->take(50)->orderBy('created_at', 'desc')->get();   
      return view('certificates.index', compact('certificates')); 
     // return view('certificates.index');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => ['required', 'string', 'confirmed', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[0-9\W]).*$/'],
        ], [
            'current_password.required' => 'The current password is required.',
            'new_password.required' => 'The new password is required.',
            'new_password.string' => 'The new password must be a string.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
            'new_password.min' => 'The new password must be at least 8 characters.',
            'new_password.regex' => 'The new password must contain at least one uppercase letter, one number, or special symbol.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Check if the current password matches
        $currentPassword = $request->input('current_password');
        $user = Auth::user();

        if (!Hash::check($currentPassword, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the password
        $newPassword = $request->input('new_password');
        $user->password = Hash::make($newPassword);
        $user->save();
        $this->logUserActivity("Admin password changed: " . $user->email);
        return redirect()->back()->with('success', 'Admin password reset successful.');
    }
    

    
    public function login()
    {
        return view('auth.login');
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
            
        if ($user->role === 'admin') {
            $this->logUserActivity("Admin Logged in: " . $user->email);
            Log::channel('daily')->notice('This is an info log message.');
        }
        if ($user->role === 'editor') {
            $this->logUserActivity("Editor Logged in: " . $user->email);
        }

            //return redirect()->intended('/admin/index');
            //return view('admin.index');
            $certificates = Certificate::latest()->take(50)->orderBy('created_at', 'desc')->get();   
           // return view('certificates.index', compact('certificates')); 
            return redirect()->route('certificates-index')->with('certificates',  $certificates)->with('success', 'Welcome!');

        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    
    
    
    public function logout(Request $request)
    {
        // Log user logout activity
        $user = Auth::user();

        if ($user->role === 'admin') {
            $this->logUserActivity("Admin Logged Out: " . $user->email);
        }
        if ($user->role === 'editor') {
            $this->logUserActivity("Editor Logged Out: " . $user->email);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        //delete generated QR codes
        $directoryPath = '/home/bstgtcom/certv.bstgt.com/qr_codes';
       
        // Get all files in the directory
        $files = glob($directoryPath . '/*');
        
        // Loop through the files and delete each one
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        return view('auth.login');
        //return redirect('/');
    }
    
    public function resetPassword()
    {
        //return view('admin.password_reset');
       // $editors = User::where('role', 'editor')->get();

        //return view('admin.password_reset', ['editors' => $editors]);
        return view('admin.password_reset');
    }

    private function logUserActivity($message)
    {
        // Log user activity to Laravel log
        \Illuminate\Support\Facades\Log::info($message);
    }

    public function showEditorPasswordResetForm()
    {
        $editors = User::where('role', 'editor')->get();
        return view('admin.editor-password-reset', compact('editors'));
    }

    public function resetEditorPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_editor_password' => ['required', 'string', 'confirmed', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[0-9\W]).*$/'],
        ], [
            'new_editor_password.required' => 'The new password is required.',
            'new_editor_password.string' => 'The new password must be a string.',
            'new_editor_password.confirmed' => 'The new password confirmation does not match.',
            'new_editor_password.min' => 'The new password must be at least 8 characters.',
            'new_editor_password.regex' => 'The new password must contain at least one uppercase letter, one number, or special symbol.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $editorId = $request->input('editor_id');
        $newPassword = $request->input('new_editor_password');

        $editor = User::findOrFail($editorId);
        $editor->password = Hash::make($newPassword);
        $editor->save();

        return redirect()->back()->with('success', 'Editor password reset successful.');
    }
    


}
