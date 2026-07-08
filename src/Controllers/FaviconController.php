<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FaviconController extends Controller
{
    public function ico(): BinaryFileResponse
    {
        return Response::file(__DIR__ . '/../Resources/Images/favicon.ico');
    }

    public function png16(): BinaryFileResponse
    {
        return Response::file(__DIR__ . '/../Resources/Images/favicon-16x16.png');
    }

    public function png32(): BinaryFileResponse
    {
        return Response::file(__DIR__ . '/../Resources/Images/favicon-32x32.png');
    }

    public function png48(): BinaryFileResponse
    {
        return Response::file(__DIR__ . '/../Resources/Images/favicon-48x48.png');
    }

    public function png64(): BinaryFileResponse
    {
        return Response::file(__DIR__ . '/../Resources/Images/favicon-64x64.png');
    }
}
