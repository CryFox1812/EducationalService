<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit7f97fc9c4d2beaf06d019ba50f7efcbc
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit7f97fc9c4d2beaf06d019ba50f7efcbc', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit7f97fc9c4d2beaf06d019ba50f7efcbc', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit7f97fc9c4d2beaf06d019ba50f7efcbc::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
