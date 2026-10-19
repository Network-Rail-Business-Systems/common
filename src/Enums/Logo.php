<?php

namespace NetworkRailBusinessSystems\Common\Enums;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

enum Logo: string
{
    case Header = 'logo-header.svg';

    case Footer = 'logo-footer.svg';

    case MailHeader = 'logo-mail-header.png';

    case MailFooter = 'logo-mail-footer.png';

    public function download(): BinaryFileResponse
    {
        return Response::file($this->path())
            ->setAutoEtag()
            ->setAutoLastModified()
            ->setMaxAge(0)
            ->setPublic();
    }

    public function height(): int
    {
        return match ($this) {
            Logo::Header => 44,
            Logo::Footer => 55,
            default => getimagesize($this->path())[1] ?? 0,
        };
    }

    public function path(): string
    {
        return realpath(__DIR__ . '/../Resources/Images/' . $this->value);
    }

    public function width(): int
    {
        return match ($this) {
            Logo::Header => 117,
            Logo::Footer => 146,
            default => getimagesize($this->path())[0] ?? 0,
        };
    }
}
