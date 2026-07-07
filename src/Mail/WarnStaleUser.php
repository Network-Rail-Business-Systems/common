<?php

namespace NetworkRailBusinessSystems\Common\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use NetworkRailBusinessSystems\Common\Models\User;

/** @property User $user */
class WarnStaleUser extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Model $user,
        public Carbon $cutoff,
    ) {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [$this->user->email],
            subject: "Your elevated access rights will be revoked on {$this->cutoff->format('d/m/Y')}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'common::mail.warn-stale-user',
        );
    }
}
