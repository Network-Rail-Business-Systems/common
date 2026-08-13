<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Mail\WarnStaleUser;

use Carbon\Carbon;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Mail;
use NetworkRailBusinessSystems\Common\Mail\WarnStaleUser;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ContentTest extends TestCase
{
    protected WarnStaleUser $mail;

    protected Content $content;

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
        $this->content = $this->mail->content();
    }

    public function test(): void
    {
        $this->assertMailRenders($this->mail);

        $this->assertEquals(
            'common::mail.warn-stale-user',
            $this->content->markdown,
        );
    }
}
