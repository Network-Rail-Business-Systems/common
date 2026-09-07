<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LogoController extends Controller
{
    public function header(): BinaryFileResponse
    {
        return Response::file(__DIR__ . '/../Resources/Images/logo-header.svg');
    }

    public function footer(): BinaryFileResponse
    {
        return Response::file(__DIR__ . '/../Resources/Images/logo-footer.svg');
    }

    public function mailHeader(): BinaryFileResponse
    {
        return Response::file(__DIR__ . '/../Resources/Images/logo-mail-header.png');
    }

    public function mailFooter(): BinaryFileResponse
    {
        return Response::file(__DIR__ . '/../Resources/Images/logo-mail-footer.png');
    }
}
