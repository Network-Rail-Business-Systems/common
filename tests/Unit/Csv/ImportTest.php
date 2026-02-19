<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Csv;

use Illuminate\Http\UploadedFile;
use NetworkRailBusinessSystems\Common\Csv;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImportTest extends TestCase
{
    protected SimpleExcelReader|array $result;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testValidatesHeaders(): void
    {
        $this->process('invalid_headers');

        $this->assertEquals(
            [
                'The "email" column is missing.',
            ],
            $this->result,
        );
    }

    public function testValidatesRows(): void
    {
        $this->process('invalid_rows');

        $this->assertEquals(
            [
                'Row 2: The email field must be a valid email address.',
            ],
            $this->result,
        );
    }

    public function testImports(): void
    {
        $this->process('valid');

        $this->assertInstanceOf(
            SimpleExcelReader::class,
            $this->result,
        );
    }

    protected function process(string $file): void
    {
        $file = new UploadedFile(
            base_path("../../../../tests/Data/$file.csv"),
            'uploaded.csv',
        );

        $this->result = Csv::import(
            $file,
            [
                'email',
            ],
            [
                'email' => [
                    'required',
                    'string',
                    'email',
                ],
            ],
        );
    }
}
