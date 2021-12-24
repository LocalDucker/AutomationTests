<?php

namespace Course\Basic;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\WebDriverRadios;
use PHPUnit\Extensions\Selenium2TestCase;
require_once 'Dev.php';

class CrowdinTest extends BaseTest
{
    public function testLogin()
    {
        $loginField = WebDriverBy::cssSelector("#login_login");
        $passwordField = WebDriverBy::cssSelector("#login_password");

        self::$driver->findElement($loginField)->sendKeys("alkaiiah909@gmail.com");
        self::$driver->findElement($passwordField)->sendKeys("alximik909");
        self::$driver->findElement(WebDriverBy::cssSelector("button[type='submit']"))->click();
        $this->assertEquals("Crowdin", self::$driver->getTitle());

        self::$driver->findElement(WebDriverBy::xpath("//button[@id='remember-me']"))->click();

        $this->assertEquals("https://crowdin.com/profile", self::$driver->getCurrentURL());



    }

    /**
     * @depends testLogin
     */
    public function testCreateProject()
    {

        $buttonCreateProject = WebDriverBy::xpath("/html/body/div[1]/div[4]/div/div/div[2]/div[2]/div/div[1]/div/div[2]/a");

        self::$driver->findElement($buttonCreateProject)->click();


        $this->assertEquals("https://crowdin.com/createproject", self::$driver->getCurrentURL());

        $nameProjectField = WebDriverBy::cssSelector("#project_name");
        $stringName = "Test project" . $this->generatingName();
        self::$driver->findElement($nameProjectField)->sendKeys($stringName);

        self::$driver->findElement(WebDriverBy::xpath("//input[@id='join-policy-open']"))->click();

        self::$driver->findElement(WebDriverBy::xpath("//span[normalize-space()='English']"))->click();
        self::$driver->findElement(WebDriverBy::cssSelector("div[class='chosen-search'] input[type='text']"))->sendKeys("Ukrainian");
        self::$driver->getKeyboard()->sendKeys(WebDriverKeys::ENTER);

        self::$driver->findElement(WebDriverBy::cssSelector("input[placeholder='Search languages']"))->clear();
        self::$driver->findElement(WebDriverBy::cssSelector("input[placeholder='Search languages']"))->sendKeys("English");
        sleep(2);
        self::$driver->findElement(WebDriverBy::xpath("/html/body/div[1]/div[3]/div/div[2]/div[2]/form/div[4]/div[2]/div[1]/div/div[1]/div[2]/div/ul/li"))->click();


        self::$driver->findElement(WebDriverBy::cssSelector("input[placeholder='Search languages']"))->clear();
        self::$driver->findElement(WebDriverBy::cssSelector("input[placeholder='Search languages']"))->sendKeys("italian");
        sleep(2);
        self::$driver->findElement(WebDriverBy::xpath("/html/body/div[1]/div[3]/div/div[2]/div[2]/form/div[4]/div[2]/div[1]/div/div[1]/div[2]/div/ul/li[1]"))->click();
        self::$driver->findElement(WebDriverBy::xpath("//span[normalize-space()='Create Project']"))->click();
        sleep(7);

        self::$driver->get("https://crowdin.com/profile");
        sleep(2);
        $nameproj = self::$driver->findElement(WebDriverBy::xpath("//a[normalize-space()='$stringName']"))->isDisplayed();
        $this->assertTrue($nameproj);


    }

    public function generatingName(): string
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = substr(str_shuffle($permitted_chars), 0, 8);
        return $result;
    }
}