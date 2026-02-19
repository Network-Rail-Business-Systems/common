<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Csv;

use Illuminate\Http\Exceptions\HttpResponseException;
use NetworkRailBusinessSystems\Common\Csv;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportTest extends TestCase
{
    protected BinaryFileResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('filesystems.disks.temp', [
            'driver' => 'local',
            'root' => storage_path('app/temp'),
        ]);
    }

    public function testHandlesEmpty(): void
    {
        $this->expectException(HttpResponseException::class);

        Csv::export(
            'My CSV',
            [],
        );

        $this->assertFlashed(
            'Unable to create CSV; there were no rows to export',
            'info',
        );
    }

    public function testGeneratesCsv(): void
    {
        $this->response = Csv::export(
            'My CSV',
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
