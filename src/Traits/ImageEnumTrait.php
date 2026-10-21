<?php

namespace NetworkRailBusinessSystems\Common\Traits;

use Illuminate\Support\Facades\Response;
use NetworkRailBusinessSystems\Common\Interfaces\ImageEnum;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/** @mixin ImageEnum */
trait ImageEnumTrait
{
    public const int HEIGHT = 1;

    public const int WIDTH = 0;

    public function assetPath(): string
    {
        return 'file://' . $this->realPath();
    }

    public function download(): BinaryFileResponse
    {
        return Response::file($this->realPath())
            ->setAutoEtag()
            ->setAutoLastModified()
            ->setMaxAge(0)
            ->setPublic();
    }

    public function height(): int
    {
        return $this->getImageDimension(self::HEIGHT);
    }

    public function realPath(): string
    {
        return realpath(__DIR__ . '/../Resources/Images/' . $this->value);
    }

    public function width(): int
    {
        return $this->getImageDimension(self::WIDTH);
    }

    protected function getImageDimension(int $axis): int
    {
        return getimagesize($this->realPath())[$axis] ?? 0;
    }
}
