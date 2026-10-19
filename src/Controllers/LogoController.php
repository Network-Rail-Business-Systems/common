<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use NetworkRailBusinessSystems\Common\Enums\Logo;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LogoController extends Controller
{
    public function header(): BinaryFileResponse
    {
        return Logo::Header->download();
    }

    public function footer(): BinaryFileResponse
    {
        return Logo::Footer->download();
    }

    public function mailHeader(): BinaryFileResponse
    {
        return Logo::MailHeader->download();
    }

    public function mailFooter(): BinaryFileResponse
    {
        return Logo::MailFooter->download();
    }
}
