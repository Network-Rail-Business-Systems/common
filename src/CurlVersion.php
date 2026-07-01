<?php

namespace NetworkRailBusinessSystems\Common;

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

    public static function supportsHttp2(): bool
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

    public static function supportsProxyTlsCredentialAwareConnectionReuse(): bool
    {
        return false;
    }

    public static function supportsProxyCredentialAwareConnectionReuse(): bool
    {
        return false;
    }

    public static function supportsProxyHeaderSeparation(): bool
    {
        return false;
    }

    public static function getVersion(): ?string
    {
        return '7.29.0';
    }
}
