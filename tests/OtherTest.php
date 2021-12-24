<?php
namespace Facebook\WebDriver;

use Course\Basic\BaseTest;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;

require_once 'Dev.php';

class OtherTest extends BaseTest
{

    private $loginField;
    private $passwordFiled;

    public function testLogin()
    {
          $loginField = WebDriverBy::xpath("/html[1]/body[1]/div[1]/div[3]/form[1]/div[1]/div[1]/div[1]/div[2]/div[2]/input[1]");
//        $passwordFiled = WebDriverBy::xpath("//input[@id='pass']");
//        $submitButtom = WebDriverBy::cssSelector("input[value='Вхід']");
//
//        $exitButton = WebDriverBy::cssSelector("a[href='/logout.php']");
        self::$driver->findElement($loginField)->sendKeys("yandex");
//        self::$driver->findElement($passwordFiled)->sendKeys("alkaiiah909");
//        self::$driver->findElement($submitButtom)->click();

        echo self::$driver->findElement($loginField)->getAttribute("value");
        $this->assertEquals("https://www.google.com/", self::$driver->getCurrentURL());

    }


}