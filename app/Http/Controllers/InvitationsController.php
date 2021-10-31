<?php

namespace App\Http\Controllers;

use App\Mail\SendInvitationToJoinTeam;
use App\Models\Invitation;
use App\Models\Team;
use App\Repositories\Contracts\IInvitation;
use App\Repositories\Contracts\ITeam;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InvitationsController extends Controller
{
    //
    protected IInvitation $invitationRepo;
    protected ITeam $teamRepo;
    protected IUser $userRepo;

    public function __construct(IInvitation $invitationRepo, ITeam $teamRepo, IUser $userRepo)
    {
        $this->invitationRepo = $invitationRepo;
        $this->teamRepo = $teamRepo;
        $this->userRepo = $userRepo;
    }

    public function invite(Request $request, Team $team)
    {
        $data = $request->validate([
            'email' => ['required', 'email']
        ]);
        $user = Auth::user();
        // check if user owns the team
        if (!$user->isOwnerOfTeam($team)) {
            return response()->json([
                'email' => 'You are not the team owner'
            ], 401);
        }

        // check if the email has a pending invitation
        if ($team->hasPendingInvite($data['email'])) {
            return response()->json([
                'email' => 'Email already has a pending invite'
            ], 422);
        }

        // get the recipient by email
        $recipient = $this->userRepo->findWhereFirst('email', $data['email']);

        // if the recipient does not exist, send invitation to join the team
        if (!$recipient) {
            $this->createInvitation(false, $team, $data['email']);

            return response()->json([
                'message' => 'Invitation sent to user'
            ]);
        }

        // check if the team already has the user
        if ($team->hasUser($recipient)) {
            return response()->json([
                'message' => 'This user seems to be a team member already'
            ], 422);
        }

        // send the invitation to the user
        $this->createInvitation(true, $team, $data['email']);

        return response()->json([
            'message' => 'Invitation sent to user'
        ]);
    }

    public function resend(Invitation $invitation): \Illuminate\Http\JsonResponse
    {
        // check if user is the sender
        $this->authorize('resend', $invitation);

        // get the recipient by email
        $recipient = $this->userRepo->findWhereFirst('email', $invitation->recipient_email);

        Mail::to($invitation->recipient_email)->send(new SendInvitationToJoinTeam($invitation, !is_null($recipient)));

        return response()->json([
            'message' => 'Invitation sent to user'
        ]);
    }

    public function respond(Request $request, Invitation $invitation)
    {
        $data = $request->validate([
            'token' => ['required'],
            'decision' => ['required']
        ]);

        $token = $data['token'];
        $decision = $data['decision'];

        //check if the invitation belongs to this user
        $this->authorize('respond', $invitation);

        // check to make sure that tokens match
        if ($invitation->token !== $token) {
            return response()->json([
                'message' => 'Invalid Token'
            ], 401);
        }

        //check if accepted
        if ($decision !== 'deny') {
            $this->invitationRepo->addUserToTeam($invitation->team, Auth::id());
        }

        $invitation->delete();

        return response()->json([
            'message' => 'Successful'
        ], 200);
    }

    public function destroy(Invitation $invitation)
    {
        $this->authorize('delete', $invitation);
        $invitation->delete();

        return response()->json(['message' => 'Deleted', 200]);
    }

    protected function createInvitation(bool $user_exist, Team $team, string $email)
    {
        $invitation = $this->invitationRepo->create([
            'team_id' => $team->id,
            'sender_id' => Auth::id(),
            'recipient_email' => $email,
            'token' => md5(uniqid(microtime())),
        ]);

        Mail::to($email)->send(new SendInvitationToJoinTeam($invitation, $user_exist));
    }
}
