<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Support\Facades\Cache;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Controllers\BannerController;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class SetBannerTest extends TestCase
{
    protected CommonServiceProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);
    }

    #[DataProvider('expectations')]
    public function testSetsInfoBanner(string $type): void
    {
        Cache::put(BannerController::CACHE_KEY, [
            'type' => $type,
            'message' => 'Potato',
            'ends_at' => null,
        ]);

        $this->provider->setBanner();
        $messages = flash()->messages;

        $this->assertCount(1, $messages);

        $this->assertEquals(
            $type,
            $messages->first()->level,
        );

        $this->assertEquals(
            'Potato',
            $messages->first()->message,
        );
    }

    public static function expectations(): array
    {
        return [
            ['type' => 'info'],
            ['type' => 'danger'],
            ['type' => 'warning'],
        ];
    }

    public function testDoesntWhenFlashExists(): void
    {
        flash()->info('Carrot');

        Cache::put(BannerController::CACHE_KEY, [
            'type' => 'info',
            'message' => 'Potato',
            'ends_at' => null,
        ]);

        $this->provider->setBanner();
        $messages = flash()->messages;

        $this->assertCount(1, $messages);

        $this->assertEquals(
            'Carrot',
            $messages->first()->message,
        );
    }
}
