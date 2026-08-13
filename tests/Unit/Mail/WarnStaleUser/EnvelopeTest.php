<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Mail\WarnStaleUser;

use Carbon\Carbon;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Mail;
use NetworkRailBusinessSystems\Common\Mail\WarnStaleUser;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class EnvelopeTest extends TestCase
{
    protected WarnStaleUser $mail;

    protected Envelope $envelope;

    protected User $user;

    protected Carbon $cutoff;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->useDatabase();

        $this->user = User::factory()->create();
        $this->cutoff = Carbon::today();

        $this->mail = new WarnStaleUser($this->user, $this->cutoff);
        $this->envelope = $this->mail->envelope();
    }

    public function test(): void
    {
        $this->assertTrue(
            $this->envelope->hasTo($this->user->email),
        );

        $this->assertEquals(
            "Your elevated access rights will be revoked on {$this->cutoff->format('d/m/Y')}",
            $this->envelope->subject,
        );
    }
}
