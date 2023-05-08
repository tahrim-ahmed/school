<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita48055d0087cb4dff685f8846377f820
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'Ozdemir\\Datatables\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ozdemir\\Datatables\\' => 
        array (
            0 => __DIR__ . '/..' . '/ozdemir/datatables/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita48055d0087cb4dff685f8846377f820::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita48055d0087cb4dff685f8846377f820::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}