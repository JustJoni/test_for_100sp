<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit35c1f06e9828c006465f662871d497ed
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TestSolution\\' => 13,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Component\\DomCrawler\\' => 29,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
        ),
        'M' => 
        array (
            'Masterminds\\' => 12,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TestSolution\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Component\\DomCrawler\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/dom-crawler',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-factory/src',
            1 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'Masterminds\\' => 
        array (
            0 => __DIR__ . '/..' . '/masterminds/html5/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
<<<<<<< HEAD
=======
        'ProductsListYouSee' => __DIR__ . '/../..' . '/app/ProductsListYouSee.php',
>>>>>>> 63ad1c08207650e90c799bbebf56e395831cfab5
        'TestSolution\\App' => __DIR__ . '/../..' . '/app/App.php',
        'TestSolution\\DownloadPage' => __DIR__ . '/../..' . '/app/DownloadPage.php',
        'TestSolution\\ProductsList' => __DIR__ . '/../..' . '/app/ProductsList.php',
        'TestSolution\\ProductsListAttention' => __DIR__ . '/../..' . '/app/ProductsListAttention.php',
        'TestSolution\\ProductsListDiscount' => __DIR__ . '/../..' . '/app/ProductsListDiscount.php',
        'TestSolution\\ProductsListFastDelivery' => __DIR__ . '/../..' . '/app/ProductsListFastDelivery.php',
        'TestSolution\\ProductsListFood' => __DIR__ . '/../..' . '/app/ProductsListFood.php',
        'TestSolution\\ProductsListNew' => __DIR__ . '/../..' . '/app/ProductsListNew.php',
        'TestSolution\\ProductsListPopular' => __DIR__ . '/../..' . '/app/ProductsListPopular.php',
        'TestSolution\\ProductsListSP' => __DIR__ . '/../..' . '/app/ProductsListSP.php',
<<<<<<< HEAD
        'TestSolution\\ProductsListYouSee' => __DIR__ . '/../..' . '/app/ProductsListYouSee.php',
=======
>>>>>>> 63ad1c08207650e90c799bbebf56e395831cfab5
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit35c1f06e9828c006465f662871d497ed::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit35c1f06e9828c006465f662871d497ed::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit35c1f06e9828c006465f662871d497ed::$classMap;

        }, null, ClassLoader::class);
    }
}
