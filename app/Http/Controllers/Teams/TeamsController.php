<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Models\User;
use App\Repositories\Contracts\IInvitation;
use App\Repositories\Contracts\ITeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TeamsController extends Controller
{
    //
    protected ITeam $teamRepo;
    protected IInvitation $invitationRepo;

    public function __construct(ITeam $teamRepo, IInvitation $invitationRepo)
    {
        $this->teamRepo = $teamRepo;
        $this->invitationRepo = $invitationRepo;
    }

    public function index(Request $request)
    {

    }

    public function findById(string $id): TeamResource
    {
        $team = $this->teamRepo->find($id);
        return new TeamResource($team);
    }

    public function findBySlug(Request $request, string $slug)
    {
        $teams = $this->teamRepo->fetchUserTeams();
        return TeamResource::collection($teams);
    }

    public function fetchUserTeams(Request $request)
    {

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:80|unique:teams'
        ]);

        $team = $this->teamRepo->create([
            'owner_id' => auth()->id(),
            'name' => $data['name'],
            'slug' => Str::slug($data['name'])
        ]);

        return new TeamResource($team);
    }

    public function update(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:teams']
        ]);

        $this->teamRepo->update($team, [
            'name' => $data['name'],
            'slug' => Str::slug($data['name'])
        ]);

        return new TeamResource($team);
    }

    public function destroy(Team $team)
    {

    }

    public function removeUserFromTeam(Team $team, User $user)
    {
        // check that the user not the owner
        if ($user->isOwnerOfTeam($team)) {
            return response()->json(['message' => 'You are the team owner'], 401);
        }

        // check that the person sending the request is either the owner of the team or the person who wants to leave the team
        if (Auth::user()->isOwnerOfTeam($team) && Auth::id() !== $user->id) {
            return response()->json(['message' => 'You cannot do this'], 401);
        }

        $this->invitationRepo->removeUserFromTeam($team, $user->id);

        return response()->json(['message' => 'Success'], 200);
    }
}
