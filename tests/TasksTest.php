<?php
use PHPUnit\Extensions\Selenium2TestCase;
use PHPUnit\Extensions\Selenium2TestCase\SessionCommand\Click;
//use PHPUnit\Extensions\Selenium2TestCase\ElementCommand\Click;

require_once 'Dev.php';

class TasksTest extends Selenium2TestCase
{
//    public static function setUpBeforeClass(): void
//    {
//        parent::setUpBeforeClass();
//
//        self::setBrowserUrl('http://coursesite.local/');
//        (new TasksTest)->setBrowser('chrome');
//        (new TasksTest)->setDesiredCapabilities(['chromeOptions' => ['w3c'=>false]]);
//    }


    public function setUp(): void
    {
        $this->setBrowserUrl('http://coursesite.local/');
        $this->setBrowser('chrome');
        $this->setDesiredCapabilities(['chromeOptions' => ['w3c' => false]]);
    }

    public function dataArrayLogin(): array
    {
        return array(
            "sqlInjection" => array("' or 1=1", "1234"),
            "defaultTestEmail" => array("test@test.com", "test"),
            "defaultAdminLogin" => array("admin@admin.com", "admin"),
            "defaultAdminAdmin" => array("admin", "admin")
        );
    }

    /**
     * @dataProvider  dataArrayLogin
     */
    public function testBadCaseLogin($log, $pass)
    {
        $this->url('http://coursesite.local');

        $loginField = $this->byName('loginEmail');
        $passwordField = $this->byName('loginPassword');
        $buttonConfirm = $this->byName('loginButton');

        $this->assertSame('LOGIN',$buttonConfirm->text());

        $loginField->value("{$log}");
        $passwordField->value("{$pass}");

        $this->assertSame("{$log}", $loginField->value());
        $this->assertSame("{$pass}", $passwordField->value());

        $buttonConfirm->click();

        $errorMessage = $this->elements($this->using('css selector')->value('li'));

        $this->assertEquals("- Невірні дані", $errorMessage[0]->text());

    }

    public function testFirstArg()
    {
        $this->assertTrue(true);
        return 'first';
    }

    public function testSecondArg()
    {
        $var = array(
            "fKey" => "firstKey",
            "sKey" => "secondKey",
            "tKey" => "thirdKey",
        );
        $this->assertTrue(true);
        return $var;
    }

    /**
     * @depends testFirstArg
     * @depends testSecondArg
     */
    public function testGetArgFromDepends()
    {
        //можна отримати значення через параметри або через метод нижче
        //спосіб через метод менш зручний через те, що утворюється масив з індексами
        $data = func_get_args();
        $this->assertEquals(
            array('firstKey', 'secondKey'),
            array($data[1]['fKey'], $data[1]['sKey'])
        );
    }

/*
 * Test exists login and password fields
 */
    public function testExistsLoginInputFields()
    {
        $this->url("http://coursesite.local/");

        $this->assertSame("Welcome", $this->title());

        $this->assertTrue($this->byName('loginEmail')->displayed());
        $this->assertTrue($this->byName('loginPassword')->displayed());

    }

    /*
     * Test correct login form
     */
    public function testInputLoginForm()
    {
        $this->url("http://coursesite.local/");

        $this->enterLoginData();

        $this->assertSame("Document",$this->title());

    }

    /*
     * Робота з мишкою та клавітурою, заповнюємо поля за допомогою клавіатури
     *  натискаємо кнопку відправки форми мишкою
     */
    public function testWorkWithMouseAndKeyboard()
    {
        $this->url("http://coursesite.local/");

        $this->byName('loginEmail')->click();
        $this->keys('al@al.ala1');

        $this->byName('loginPassword')->click();
        $this->keys('1234');

        $this->moveto($this->byName('loginButton'));
        $this->click(Click::LEFT);
        $this->assertSame("Document",$this->title());
    }


    public function testDownload()
    {
        $url = 'https://support.crowdin.com/assets/api/crowdin.yml';
        $fileSizeFromSite = array_change_key_case(get_headers($url,1))['content-length'];
        $this->assertEquals(filesize('crowdin.yml'), $fileSizeFromSite);


    }



    /*
     * Function for enter login and password, exclude duplicates
     */
    public function enterLoginData()
    {
        $this->byName('loginEmail')->value('al@al.ala1');
        $this->byName('loginPassword')->value('1234');
        $this->byName('loginButton')->click();
    }

}
