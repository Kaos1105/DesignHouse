<?php

namespace App\Providers;

use App\Repositories\Contracts\IComment;
use App\Repositories\Contracts\IDesign;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\DesignRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public array $bindings = [
        IDesign::class => DesignRepository::class,
        IUser::class => UserRepository::class,
        IComment::class => CommentRepository::class
    ];

    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
