<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function show()
  {
    $user = Auth::user();

    $userPosts = Post::with('category')
      ->where('user_id', $user->id)
      ->latest()
      ->paginate(5);

    $firstPostDate = $user->posts()->oldest()->first()?->created_at;
    $memberSince = $firstPostDate ? $firstPostDate->diffForHumans() : 'No posts yet';

    return view('profile', compact(
      'user',
      'userPosts',
      'memberSince'
    ));
  }

  public function update(Request $request)
  {
    $user = Auth::user();

    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
      'bio' => ['nullable', 'string', 'max:500'],
      'location' => ['nullable', 'string', 'max:100'],
      'website' => ['nullable', 'url', 'max:255'],
      'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
    ]);

    $updateData = $request->only(['name', 'email', 'bio', 'location', 'website']);

    // Handle avatar upload
    if ($request->hasFile('avatar')) {
      $avatar = $request->file('avatar');
      $avatarName = time() . '_' . $user->id . '.' . $avatar->getClientOriginalExtension();
      $avatar->move(public_path('storage/avatars'), $avatarName);
      $updateData['avatar'] = '/storage/avatars/' . $avatarName;
    }

    $user->update($updateData);

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
  }

  public function updatePassword(Request $request)
  {
    $request->validate([
      'current_password' => ['required'],
      'password' => ['required', 'min:8', 'confirmed'],
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
      return back()->withErrors(['current_password' => 'Current password is incorrect.']);
    }

    $user->update([
      'password' => Hash::make($request->password)
    ]);

    return redirect()->route('profile.show')->with('success', 'Password updated successfully!');
  }
}
