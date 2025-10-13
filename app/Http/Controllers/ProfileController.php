<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Exception;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_photo' => 'nullable|boolean',  // Validasi checkbox (opsional)
        ]);

        try {
            // Update nama
            $user->name = $request->name;

            // Handling delete photo (jika dicentang)
            if ($request->has('delete_photo') && $request->delete_photo) {
                if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }
                $user->profile_photo_path = null;  // Set null di DB
            }
            // **Prioritas: Jika ada upload baru, override delete (upload dulu)**
            elseif ($request->hasFile('photo')) {
                $photo = $request->file('photo');

                // Hapus foto lama jika ada
                if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                // Simpan foto baru
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                $request->file('photo')->storeAs('profile', $filename, 'public');
                $user->profile_photo_path = 'profile/' . $filename;
            }

            // Simpan perubahan
            $user->save();

            return redirect()->route('profile.edit')->with('success', 'Profile berhasil diperbarui.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal update profile: ' . $e->getMessage())->withInput();
        }
    }

    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function destroy(): RedirectResponse
    {
        $user = Auth::user();

        try {
            // Hapus foto jika ada
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->delete();
            Auth::logout();

            return redirect('/login')->with('success', 'Akun berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus akun: ' . $e->getMessage());
        }
    }
}