<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use NetworkRailBusinessSystems\Common\Enums\Favicon;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FaviconController extends Controller
{
    public function ico(): BinaryFileResponse
    {
        return Favicon::Ico->download();
    }

    public function png16(): BinaryFileResponse
    {
        return Favicon::Png16->download();
    }

    public function png32(): BinaryFileResponse
    {
        return Favicon::Png32->download();
    }

    public function png48(): BinaryFileResponse
    {
        return Favicon::Png48->download();
    }

    public function png64(): BinaryFileResponse
    {
        return Favicon::Png64->download();
    }
}
