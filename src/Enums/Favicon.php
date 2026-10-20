<?php

namespace NetworkRailBusinessSystems\Common\Enums;

use NetworkRailBusinessSystems\Common\Interfaces\ImageEnum;
use NetworkRailBusinessSystems\Common\Traits\ImageEnumTrait;

enum Favicon: string implements ImageEnum
{
    use ImageEnumTrait;

    case Ico = 'favicon.ico';

    case Png16 = 'favicon-16x16.png';

    case Png32 = 'favicon-32x32.png';

    case Png48 = 'favicon-48x48.png';

    case Png64 = 'favicon-64x64.png';
}
