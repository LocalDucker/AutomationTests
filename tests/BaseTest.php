<?php
namespace Course\Basic;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;
require_once('vendor/autoload.php');

class BaseTest extends TestCase
{
    public const HOST = 'http://localhost:4444';

    public static $driver;

    public static function setUpBeforeClass(): void
    {
        $capabilities = DesiredCapabilities::chrome();
        self::$driver = RemoteWebDriver::create(self::HOST, $capabilities);
        self::$driver->get('https://accounts.crowdin.com/login');
    }

    public static function tearDownAfterClass(): void
    {
        self::$driver->quit();
    }

}