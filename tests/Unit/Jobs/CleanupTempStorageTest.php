<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Jobs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use NetworkRailBusinessSystems\Common\Jobs\CleanupTempStorage;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class CleanupTempStorageTest extends TestCase
{
    public const array INTERVALS = [
        'file_one.txt' => '25 hours',
        'file_two.txt' => '24 hours',
        'file_three.txt' => '1 hour',
        'file_four.txt' => '1 week',
    ];

    protected CleanupTempStorage $job;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('temp');

        foreach (self::INTERVALS as $fileName => $interval) {
            Storage::disk('temp')->put($fileName, 'Aha!');

            touch(
                Storage::disk('temp')->path($fileName),
                Carbon::now()->sub($interval)->timestamp,
            );
        }

        $this->job = new CleanupTempStorage();
        $this->job->handle();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'file_three.txt',
                'file_two.txt',
            ],
            Storage::disk('temp')->files(),
        );
    }
}
