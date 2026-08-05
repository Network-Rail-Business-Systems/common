<?php

namespace NetworkRailBusinessSystems\Common;

use Psr\Http\Message\RequestInterface;

/**
 * The version of CURL on our servers is limited to an insecure build
 * Once the servers are updated past RHEL 7x, this should be removable
 */
class CurlVersion
{
    public static function supportsCurlHandler(): bool
    {
        return true;
    }

    public static function supportsTls12(): bool
    {
        return true;
    }

    public static function supportsTls13(): bool
    {
        return false;
    }

    public static function supportsMultiplex(): bool
    {
        return false;
    }

    public static function supportsHttpVersionReuseMatching(): bool
    {
        return false;
    }

    public static function supportsRequiredHttp2Multiplex(): bool
    {
        return false;
    }

    public static function supportsHttp2(): bool
    {
        return false;
    }

    public static function supportsHttp3(): bool
    {
        return false;
    }

    public static function supportsRequiredHttp3Multiplex(): bool
    {
        return false;
    }

    public static function supportsHttpsProxy(): bool
    {
        return false;
    }

    public static function supportsHandlerSharing(): bool
    {
        return false;
    }

    public static function ensureHandlerSharingSupported(): void
    {
        //
    }

    public static function supportsSslSessionSharing(): bool
    {
        return false;
    }

    public static function ensureSslSessionSharingSupported(): void
    {
        //
    }

    public static function supportsConnectionSharing(): bool
    {
        return false;
    }

    public static function ensureConnectionSharingSupported(): void
    {
        //
    }

    public static function supportsShareConnectionCaches(): bool
    {
        return false;
    }

    public static function supportsProxyTlsCredentialAwareConnectionReuse(): bool
    {
        return false;
    }

    public static function supportsProxyCredentialAwareConnectionReuse(): bool
    {
        return false;
    }

    public static function supportsSocksProxyCredentialAwareConnectionReuse(): bool
    {
        return false;
    }

    public static function supportsProxyHeaderSeparation(): bool
    {
        return false;
    }

    public static function supportsProtocolsStr(): bool
    {
        return false;
    }

    public static function supportsProxyTunneling(): bool
    {
        return false;
    }

    public static function ensureSupported(RequestInterface $request): void
    {
        //
    }

    public static function supportsConnectionCaps(): bool
    {
        return false;
    }

    public static function ensureConnectionCapsSupported(string $option): void
    {
        //
    }

    public static function supportsRequiredMultiplex(): bool
    {
        return false;
    }

    public static function supportsNtlm(): bool
    {
        return false;
    }

    public static function getVersion(): string
    {
        return '7.29.0';
    }
}
