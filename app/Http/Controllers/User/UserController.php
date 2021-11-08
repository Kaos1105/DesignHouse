<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\Criterion\EagerLoad;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    protected IUser $userRepo;

    public function __construct(IUser $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = $this->userRepo->withCriteria([new EagerLoad(['designs'])])->all();
        return UserResource::collection($users);
    }

    public function search(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $designers = $this->userRepo->search($request);
        return UserResource::collection($designers);
    }

    public function findByUsername(string $username)
    {
        $user = $this->userRepo->findWhereFirst('username', $username);
        return new UserResource($user);
    }
}
