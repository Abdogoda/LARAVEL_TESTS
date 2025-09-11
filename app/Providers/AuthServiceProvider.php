<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Policies\CategoryPolicy;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  protected $policies = [
    Category::class => CategoryPolicy::class,
    Post::class => PostPolicy::class,
  ];

  public function boot(): void
  {
    $this->registerPolicies();
  }
}
