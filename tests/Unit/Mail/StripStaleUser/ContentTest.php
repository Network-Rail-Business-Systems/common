<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Mail\StripStaleUser;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Mail;
use NetworkRailBusinessSystems\Common\Mail\StripStaleUser;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ContentTest extends TestCase
{
    protected StripStaleUser $mail;

    protected Content $content;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->useDatabase();

        $this->user = User::factory()->create();

        $this->mail = new StripStaleUser($this->user);
        $this->content = $this->mail->content();
    }

    public function test(): void
    {
        $this->assertMailRenders($this->mail);

        $this->assertEquals(
            'common::mail.strip-stale-user',
            $this->content->markdown,
        );
    }
}
