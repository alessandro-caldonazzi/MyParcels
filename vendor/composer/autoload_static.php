<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite3a7220a258b16a136b3c0e8ca5bcd1d
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite3a7220a258b16a136b3c0e8ca5bcd1d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite3a7220a258b16a136b3c0e8ca5bcd1d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
