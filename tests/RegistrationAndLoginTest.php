<?php

use PHPUnit\Extensions\Selenium2TestCase;
use PHPUnit\Extensions\Selenium2TestCase\WebDriverException;

class RegistrationAndLoginTest extends Selenium2TestCase
{
    public function setUp(): void
    {
        $this->setBrowserUrl('http://coursesite.local/');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(['chromeOptions' => ['w3c'=>false]]);
    }


    public function testRegisterAndLogin()
    {
        $this->url("http://coursesite.local/");

        if ($this->title() == "Document") {
            $this->logout();
        }

        $registerLink = $this->byId("regLink");
        $this->assertSame("Create an account", $registerLink->text());


        $registerLink->click();

        $registerNameField = $this->byName("name");
        $registerPasswordField = $this->byName("password");
        $registerConfirmPasswordField = $this->byName("confirmPassword");
        $registerEmailField = $this->byName("email");
        $registerAdressField = $this->byName("adress");
        $registerPhoneField = $this->byName("phoneNumber");

        $registerNameField->value("Carabas");
        $registerPasswordField->value("1234");
        $registerConfirmPasswordField->value("1234");
        $registerEmailField->value("qwert@qwe.asdf");
        $registerAdressField->value("asdggas");
        $registerPhoneField->value("0321654987");

        $this->assertSame("Carabas", $registerNameField->value());
        $this->assertSame("1234", $registerPasswordField->value());
        $this->assertSame("1234", $registerConfirmPasswordField->value());
        $this->assertSame("qwert@qwe.asdf", $registerEmailField->value());
        $this->assertSame("asdggas", $registerAdressField->value());
        $this->assertSame("0321654987", $registerPhoneField->value());


        $radioMale = $this->byId('male');
        $radioFemale = $this->byId('female');
        $radioMale->click();
        $this->assertTrue($radioMale->selected());
        $this->assertFalse($radioFemale->selected());

        $radioFemale->click();
        $this->assertTrue($radioFemale->selected());
        $this->assertFalse($radioMale->selected());

        $acceptCheckboxField = $this->byName("accept");
        $acceptCheckboxField->click();
        $this->assertTrue($acceptCheckboxField->selected());

        $confirmButton = $this->byName("regButt");
        $this->assertTrue($confirmButton->enabled());

        $confirmButton->click();

        $this->logout();


            $loginField = $this->byName('loginEmail');
            $passwordField = $this->byName('loginPassword');
            $buttonConfirm = $this->byName('loginButton');


        $this->assertSame('LOGIN', $buttonConfirm->text());

        $loginField->value("qwert@qwe.asdf");
        $passwordField->value("1234");

        $this->assertSame("qwert@qwe.asdf", $loginField->value());
        $this->assertSame("1234", $passwordField->value());

        $buttonConfirm->click();

        $this->assertSame("Document", $this->title());

        $buttonDelete = $this->byId("buttDel");
        $this->assertSame("DELETE", $buttonDelete->text());
        $buttonDelete->click();

        $this->assertSame("Welcome", $this->title());
    }

    public function logout()
    {
        $this->assertSame("Document", $this->title());

        $buttonDelete = $this->byId("buttLogout");
        $this->assertSame("LOGOUT", $buttonDelete->text());
        $buttonDelete->click();

        $this->assertSame("Welcome", $this->title());
    }
}