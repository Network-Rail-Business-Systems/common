<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Csv;

use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Csv;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportTest extends TestCase
{
    protected BinaryFileResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $now = Carbon::create(2026, 2, 13);
        Carbon::setTestNow($now);

        config()->set('filesystems.disks.temp', [
            'driver' => 'local',
            'root' => storage_path('app/temp'),
        ]);
    }

    public function testHandlesEmpty(): void
    {
        $this->expectException(HttpResponseException::class);

        Csv::export(
            'My csv',
            new Collection([]),
        );

        $this->assertFlashed(
            'Unable to create CSV; there were no rows to export',
            'info',
        );
    }

    public function testGeneratesCsv(): void
    {
        $this->response = Csv::export(
            'My csv',
            [
                [
                    'Name' => 'Bob',
                ],
                [
                    'Name' => 'George',
                ],
                [
                    'Name' => 'Logan',
                ],
            ],
        );

        $this->assertEquals(
            'attachment; filename=2026_02_13_my_csv.csv',
            $this->response->headers->get('content-disposition'),
        );

        $names = [];
        $csv = $this->processRawCsv(
            $this->response->getFile()->getContent(),
        );

        foreach ($csv as $item) {
            foreach ($item as $value) {
                $names[] = $value;
            }
        }

        $this->assertEquals(
            [
                'Bob',
                'George',
                'Logan',
                '',
            ],
            $names,
        );
    }
}
