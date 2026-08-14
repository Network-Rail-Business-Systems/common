<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

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
        return Response::file($path)
            ->setAutoLastModified()
            ->setMaxAge(86400)
            ->setPublic();
    }
}
