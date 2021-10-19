<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\IUser;
use App\Rules\CheckSamePassword;
use App\Rules\MatchOldPassword;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    //
    protected IUser $userRepo;

    public function __construct(IUser $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function updateProfile(Request $request): UserResource
    {
        $user = Auth::user();

        $data = $request->validate([
            'tagline' => 'required',
            'name' => 'required',
            'about' => 'required|string|min:20',
            'formatted_address' => 'required',
            'location.latitude' => 'required|numeric|min:-90|max:90',
            'location.longitude' => 'required|numeric|min:-180|max:180',
            'available_to_hire' => 'boolean'
        ]);

        $location = new Point($data['location']['latitude'], $data['location']['longitude']);
        $this->userRepo->updateUser($user, $data, $location);
        return new UserResource($user);
    }

    public function updatePassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'current_password' => ['required', new CheckSamePassword],
            'password' => ['required', 'confirmed', 'min:6', new MatchOldPassword]
        ]);
        $this->userRepo->update(Auth::user(), [
            'password' => bcrypt($data['password'])
        ]);

        return response()->json(['message' => 'Password updated'], 200);
    }
}
