<?php

namespace NetworkRailBusinessSystems\Common\Interfaces;

use BackedEnum;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface ImageEnum extends BackedEnum
{
    public function assetPath(): string;

    public function download(): BinaryFileResponse;

    public function height(): int;

    public function realPath(): string;

    public function width(): int;
}
