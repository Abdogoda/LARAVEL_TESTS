<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $user = Auth::user();

    $userPosts = Post::with('category')
      ->where('user_id', $user->id)
      ->latest()
      ->paginate(5);

    return view('dashboard', compact('userPosts'));
  }
}
