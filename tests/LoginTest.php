<?php

use PHPUnit\Extensions\Selenium2TestCase\WebDriverException;

class LoginTest extends \PHPUnit\Extensions\Selenium2TestCase
{
    public function setUp(): void
    {
        $this->setBrowserUrl('http://coursesite.local/');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(['chromeOptions' => ['w3c'=>false]]);
    }
    public function testRegister()
    {
        $this->assertTrue(true);
        return 'aa';
    }

    /**
     * @depends testRegister
     */
    public function testLogin($var)
    {
        print_r($var);
        die();

        $this->url('http://coursesite.local');

        try {
            $loginField = $this->byName('loginEmail');
            $passwordField = $this->byName('loginPassword');
            $buttonConfirm = $this->byName('loginButton');
        } catch (WebDriverException $e) {
            $this->assertEquals(WebDriverException::NoSuchElement, $e->getCode());
            return;
        }

        $this->assertSame('LOGIN',$buttonConfirm->text());

        $loginField->value("al@al.ala1");
        $passwordField->value("1234");

        $this->assertSame("al@al.ala1", $loginField->value());
        $this->assertSame("1234", $passwordField->value());

        $buttonConfirm->click();

        $this->assertSame('http://coursesite.local/profile', $this->url());
    }
}