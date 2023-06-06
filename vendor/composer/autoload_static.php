<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit69f34f89f904c844f369124e62eb9d0d
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Container\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit69f34f89f904c844f369124e62eb9d0d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit69f34f89f904c844f369124e62eb9d0d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit69f34f89f904c844f369124e62eb9d0d::$classMap;

        }, null, ClassLoader::class);
    }
}
