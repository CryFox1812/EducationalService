<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7f97fc9c4d2beaf06d019ba50f7efcbc
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7f97fc9c4d2beaf06d019ba50f7efcbc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7f97fc9c4d2beaf06d019ba50f7efcbc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7f97fc9c4d2beaf06d019ba50f7efcbc::$classMap;

        }, null, ClassLoader::class);
    }
}
