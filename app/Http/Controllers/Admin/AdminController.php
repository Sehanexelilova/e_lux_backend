<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;






class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {

        
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|min:6'
            ]
;
$customMessages = [
    'email.required' => 'Email is required',
    'email.email' => 'Valid email is required',
    'password.required' => 'Password is required'
];

            $request->validate( $rules, $customMessages);
            
            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with('error', 'Invalid Username or Password');
            }
        }
        
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
 
    
        public function update_password(Request $request)
        {
            $admin = Auth::guard('admin')->user();
    
        
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required|min:6|confirmed',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            if (!Hash::check($request->currentPassword, $admin->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }
    
  
            $admin->password = Hash::make($request->newPassword);
    
            if ($request->hasFile('image')) {
              
                if ($admin->image) {
                    Storage::delete($admin->image);
                }
                $admin->image = $request->file('image')->store('photos', 'public');
            }
    
            $admin->save();
    
            return redirect()->route('admin.update_password')->with('success', 'Password and photo updated successfully.');
        }
    }
    
