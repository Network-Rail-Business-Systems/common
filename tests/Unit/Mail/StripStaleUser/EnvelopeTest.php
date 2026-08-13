<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Mail\StripStaleUser;

use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Mail;
use NetworkRailBusinessSystems\Common\Mail\StripStaleUser;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class EnvelopeTest extends TestCase
{
    protected StripStaleUser $mail;

    protected Envelope $envelope;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->useDatabase();

        $this->user = User::factory()->create();

        $this->mail = new StripStaleUser($this->user);
        $this->envelope = $this->mail->envelope();
    }

    public function test(): void
    {
        $this->assertTrue(
            $this->envelope->hasTo($this->user->email),
        );

        $this->assertEquals(
            'Your elevated access rights have been revoked',
            $this->envelope->subject,
        );
    }
}
