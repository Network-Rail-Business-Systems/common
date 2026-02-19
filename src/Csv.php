<?php

namespace NetworkRailBusinessSystems\Common;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Csv
{
    public static function export(
        string $filename,
        array|Arrayable $rows,
        bool $prefixDate = true,
        string $disk = 'temp',
    ): BinaryFileResponse {
        if ($rows instanceof Arrayable) {
            $rows = $rows->toArray();
        }

        if (empty($rows) === true) {
            flash()->info('Unable to create CSV; there were no rows to export');

            throw new HttpResponseException(
                redirect()->back(),
            );
        }

        $filename = Str::of($filename)
            ->when(
                $prefixDate === true,
                function (Stringable $string) {
                    return $string->start(
                        Carbon::now()->format('Y_m_d'),
                    );
                },
            )
            ->snake()
            ->when(
                str_ends_with($filename, '.csv') === false,
                function (Stringable $string) {
                    return $string->finish('.csv');
                },
            )
            ->lower();

        $path = Storage::disk($disk)->path($filename);
        $csv = SimpleExcelWriter::create($path, 'csv');

        foreach ($rows as $row) {
            $csv->addRow((array) $row);
        }

        $csv->close();

        return Response::download($path);
    }

    /**
     * Validate an uploaded CSV
     * @returns SimpleExcelReader|array The CSV Reader, or an array of errors
     */
    public static function import(
        UploadedFile $file,
        array $expectedHeaders,
        array $validationRules,
        array $validationMessages = [],
    ): SimpleExcelReader|array {
        $reader = SimpleExcelReader::create(
            $file->getRealPath(),
            $file->getClientOriginalExtension(),
        );

        $errors = static::validateHeaders(
            $reader,
            $expectedHeaders,
        );

        if (empty($errors) === false) {
            return $errors;
        }

        $errors = static::validateRows(
            $reader,
            $validationRules,
            $validationMessages,
        );

        if (empty($errors) === false) {
            return $errors;
        }

        return $reader;
    }

    protected static function validateHeaders(
        SimpleExcelReader $reader,
        array $expectedHeaders,
    ): array {
        $errors = [];
        $actualHeaders = $reader->getHeaders();

        foreach ($expectedHeaders as $header) {
            if (in_array($header, $actualHeaders) === false) {
                $errors[] = "The \"$header\" column is missing.";
            }
        }

        return $errors;
    }

    protected static function validateRows(
        SimpleExcelReader $reader,
        array $rules,
        array $messages,
    ): array {
        $errors = [];

        $reader->getRows()->each(function (array $row, int $index) use ($messages, $rules, &$errors) {
            $validator = Validator::make($row, $rules, $messages);

            if ($validator->passes() === false) {
                $index += 2;
                $errors[] = "Row $index: {$validator->errors()->first()}";
            }
        });

        return $errors;
    }
}
