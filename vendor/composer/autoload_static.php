<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite87ad7546fc701f32dde8f94f8ac089a
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'admin\\foro\\Models\\' => 18,
            'admin\\foro\\Helpers\\' => 19,
            'admin\\foro\\Entities\\' => 20,
            'admin\\foro\\Database\\' => 20,
            'admin\\foro\\Controllers\\' => 23,
            'admin\\foro\\Config\\' => 18,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'admin\\foro\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/models',
        ),
        'admin\\foro\\Helpers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/helpers',
        ),
        'admin\\foro\\Entities\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/entities',
        ),
        'admin\\foro\\Database\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/database',
        ),
        'admin\\foro\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/controllers',
        ),
        'admin\\foro\\Config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/config',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite87ad7546fc701f32dde8f94f8ac089a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite87ad7546fc701f32dde8f94f8ac089a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite87ad7546fc701f32dde8f94f8ac089a::$classMap;

        }, null, ClassLoader::class);
    }
}
