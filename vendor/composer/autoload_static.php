<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc74e4d1edf5503eb58d208ac9b2d6891
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Library\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Library\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Library',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc74e4d1edf5503eb58d208ac9b2d6891::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc74e4d1edf5503eb58d208ac9b2d6891::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc74e4d1edf5503eb58d208ac9b2d6891::$classMap;

        }, null, ClassLoader::class);
    }
}
