<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit980a184401f6a22c1173406d89148d34
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit980a184401f6a22c1173406d89148d34::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit980a184401f6a22c1173406d89148d34::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit980a184401f6a22c1173406d89148d34::$classMap;

        }, null, ClassLoader::class);
    }
}
