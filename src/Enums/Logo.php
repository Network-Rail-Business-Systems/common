<?php

namespace NetworkRailBusinessSystems\Common\Enums;

use NetworkRailBusinessSystems\Common\Interfaces\ImageEnum;
use NetworkRailBusinessSystems\Common\Traits\ImageEnumTrait;

enum Logo: string implements ImageEnum
{
    use ImageEnumTrait;

    case Header = 'logo-header.svg';

    case Footer = 'logo-footer.svg';

    case MailHeader = 'logo-mail-header.png';

    case MailFooter = 'logo-mail-footer.png';

    public function height(): int
    {
        return match ($this) {
            Logo::Header => 44,
            Logo::Footer => 55,
            default => $this->getImageDimension(self::HEIGHT),
        };
    }

    public function width(): int
    {
        return match ($this) {
            Logo::Header => 117,
            Logo::Footer => 146,
            default => $this->getImageDimension(self::WIDTH),
        };
    }
}
