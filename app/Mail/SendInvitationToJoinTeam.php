<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvitationToJoinTeam extends Mailable
{
    use Queueable, SerializesModels;

    public Invitation $invitation;
    public bool $user_exist;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invitation $invitation, bool $user_exist)
    {
        //
        $this->invitation = $invitation;
        $this->user_exist = $user_exist;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): SendInvitationToJoinTeam
    {
        if ($this->user_exist) {
            $url = config('app.client_url') . '/settings/teams';
            return $this->markdown('emails.invitation.invite-existing-user')->subject('Invitation to join team' . $this->invitation->team->name)
                ->with([
                    'invitation' => $this->invitation,
                    'url' => $url
                ]);
        } else {
            $url = config('app.client_url') . '/register?invitation=' . $this->invitation->recipient_email;
            return $this->markdown('emails.invitation.invite-new-user')->subject('Invitation to join team' . $this->invitation->team->name)
                ->with([
                    'invitation' => $this->invitation,
                    'url' => $url
                ]);
        }
    }
}
