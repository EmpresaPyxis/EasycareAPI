<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit351cfb4131a264972df4fde203cd2595
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Source\\' => 7,
        ),
        'C' => 
        array (
            'CoffeeCode\\DataLayer\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Source\\' => 
        array (
            0 => __DIR__ . '/../..' . '/source',
        ),
        'CoffeeCode\\DataLayer\\' => 
        array (
            0 => __DIR__ . '/..' . '/coffeecode/datalayer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit351cfb4131a264972df4fde203cd2595::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit351cfb4131a264972df4fde203cd2595::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}