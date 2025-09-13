<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

  public function update(UpdateProfileRequest $request)
  {
    $user = Auth::user();

    $updateData = $request->only(['name', 'email', 'bio', 'location', 'website']);

    // Handle avatar upload
    if ($request->hasFile('avatar')) {
      $avatar = $request->file('avatar');
      $avatarName = time() . '_' . $user->id . '.' . $avatar->getClientOriginalExtension();
      $avatar->move(public_path('storage/avatars'), $avatarName);
      $updateData['avatar'] = '/storage/avatars/' . $avatarName;
    }

    if ($request->email !== $user->email) {
      $updateData['email_verified_at'] = null;
    }

    $user->update($updateData);

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
  }

  public function updatePassword(ChangePasswordRequest $request)
  {
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
