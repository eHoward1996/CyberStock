<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit57df568a50ae8c607dcf3f9d444165a8
{
    public static $files = array (
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
        '3a37ebac017bc098e9a86b35401e7a68' => __DIR__ . '/..' . '/mongodb/mongodb/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Spatie\\TwitterStreamingApi\\' => 27,
            'Scheb\\YahooFinanceApi\\' => 22,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'M' => 
        array (
            'MongoDB\\' => 8,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Spatie\\TwitterStreamingApi\\' => 
        array (
            0 => __DIR__ . '/..' . '/spatie/twitter-streaming-api/src',
        ),
        'Scheb\\YahooFinanceApi\\' => 
        array (
            0 => __DIR__ . '/..' . '/scheb/yahoo-finance-api/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'MongoDB\\' => 
        array (
            0 => __DIR__ . '/..' . '/mongodb/mongodb/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
    );

    public static $classMap = array (
        'OauthPhirehose' => __DIR__ . '/..' . '/fennb/phirehose/lib/OauthPhirehose.php',
        'Phirehose' => __DIR__ . '/..' . '/fennb/phirehose/lib/Phirehose.php',
        'PhirehoseConnectLimitExceeded' => __DIR__ . '/..' . '/fennb/phirehose/lib/Phirehose.php',
        'PhirehoseException' => __DIR__ . '/..' . '/fennb/phirehose/lib/Phirehose.php',
        'PhirehoseNetworkException' => __DIR__ . '/..' . '/fennb/phirehose/lib/Phirehose.php',
        'UserstreamPhirehose' => __DIR__ . '/..' . '/fennb/phirehose/lib/UserstreamPhirehose.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit57df568a50ae8c607dcf3f9d444165a8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit57df568a50ae8c607dcf3f9d444165a8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit57df568a50ae8c607dcf3f9d444165a8::$classMap;

        }, null, ClassLoader::class);
    }
}
