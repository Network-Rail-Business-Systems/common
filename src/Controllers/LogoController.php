<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LogoController extends Controller
{
    public function header(): BinaryFileResponse
    {
        return $this->download(__DIR__ . '/../Resources/Images/logo-header.svg');
    }

    public function footer(): BinaryFileResponse
    {
        return $this->download(__DIR__ . '/../Resources/Images/logo-footer.svg');
    }

    protected function download(string $path): BinaryFileResponse
    {
        return Response::file($path)->setCache([
            'last_modified' => Carbon::createFromTimestamp(
                File::lastModified($path),
            ),
            'public' => true,
        ]);
    }
}
