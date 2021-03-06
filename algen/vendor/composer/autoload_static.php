<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit224e17d4eb2066c4f9087a7605d60f90
{
    public static $files = array (
        'c24a5916292692a00cad92fd4c447a92' => __DIR__ . '/../..' . '/main.php',
    );

    public static $prefixLengthsPsr4 = array (
        1 => 
        array (
            '1\\Algen\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        '1\\Algen\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Analytics' => __DIR__ . '/../..' . '/utils/analytics.php',
        'Catalogue' => __DIR__ . '/../..' . '/app/Catalogue.php',
        'Chromosome' => __DIR__ . '/../..' . '/app/Chromosome.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Crossover' => __DIR__ . '/../..' . '/app/Crossover.php',
        'Elitism' => __DIR__ . '/../..' . '/app/Selection.php',
        'Fitness' => __DIR__ . '/../..' . '/app/Fitness.php',
        'InitialPopulation' => __DIR__ . '/../..' . '/app/Population.php',
        'KoneksiDatabase' => __DIR__ . '/../..' . '/app/DBConnection.php',
        'Miscellaneous' => __DIR__ . '/../..' . '/utils/misc.php',
        'Mutation' => __DIR__ . '/../..' . '/app/Mutation.php',
        'Quotation' => __DIR__ . '/../..' . '/app/Quotation.php',
        'Randomizer' => __DIR__ . '/../..' . '/utils/randomizer.php',
        'RouletteWheel' => __DIR__ . '/../..' . '/app/Selection.php',
        'Selection' => __DIR__ . '/../..' . '/app/Selection.php',
        'SelectionFactory' => __DIR__ . '/../..' . '/app/Selection.php',
        'VatRate' => __DIR__ . '/../..' . '/app/Quotation.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit224e17d4eb2066c4f9087a7605d60f90::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit224e17d4eb2066c4f9087a7605d60f90::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit224e17d4eb2066c4f9087a7605d60f90::$classMap;

        }, null, ClassLoader::class);
    }
}
