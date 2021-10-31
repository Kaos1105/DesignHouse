<?php

namespace App\Providers;

use App\Repositories\Contracts\IChat;
use App\Repositories\Contracts\IComment;
use App\Repositories\Contracts\IDesign;
use App\Repositories\Contracts\IInvitation;
use App\Repositories\Contracts\IMessage;
use App\Repositories\Contracts\ITeam;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\ChatRepository;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\DesignRepository;
use App\Repositories\Eloquent\InvitationRepository;
use App\Repositories\Eloquent\MessageRepository;
use App\Repositories\Eloquent\TeamRepository;
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
        IComment::class => CommentRepository::class,
        ITeam::class => TeamRepository::class,
        IInvitation::class => InvitationRepository::class,
        IChat::class => ChatRepository::class,
        IMessage::class => MessageRepository::class
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
