<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('status', 'profile-updated');
    }

    public function destroy(Request $request)
    {
        $request->validate(['password' => 'required']);
        
        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
