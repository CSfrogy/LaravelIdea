<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // 1. Validation
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'min:8'], // Optional: only validate if they type something
            'image' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        // 2. Handle Password (only if they typed one)
        if ($request->filled('password')) {
            $attributes['password'] = bcrypt($attributes['password']);
        } else {
            // Remove it from the attributes so we don't overwrite with null
            unset($attributes['password']);
        }

        // 3. Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete the old photo from storage if it exists
            if ($user->image_path) {
                Storage::disk('public')->delete($user->image_path);
            }

            // Store the new one in 'public/profiles'
            $path = $request->file('image')->store('profiles', 'public');
            $attributes['image_path'] = $path;
        }

        // 4. Update SQLite Database
        $user->update($attributes);

        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        // delete old image if exists
        if ($user->image_path) {
            Storage::disk('public')->delete($user->image_path);
        }

        // store new image
        $path = $request->file('image')->store('images', 'public');

        $user->update([
            'image_path' => $path,
        ]);

        // changed the from 'status' to 'success',because in our layout we have the @session('susscess')
        // it just flash messages so we don't need write a new one for each submition
        return back()->with('success', 'Profile image updated!');
    }
}