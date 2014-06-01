<?php

class webTest extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * Set Up
     */
    public function setUp()
    {
        //Load Selenium Config
        $cfg = new SeleniumConfig();
        $this->url = $cfg->host . $cfg->path;
        $this->setBrowser($cfg->browser);
        $this->setBrowserUrl($cfg->host . $cfg->path);
        //Screenshots
        if (isset($cfg->captureScreenshotOnFailure) && $cfg->captureScreenshotOnFailure) {
            $this->captureScreenshotOnFailure = true;
            $this->screenshotPath = $cfg->folder . $cfg->path . $cfg->screenShotPath;
            $this->screenshotUrl = $cfg->host . $cfg->path . $cfg->screenShotPath;
        }
    }

    /**
     * Login
     */
    public function testLogin()
    {
        //Login
        $this->doLogin();

        //Check login
        $user = $this->byCssSelector("div.container .nav.navbar-right li.exit>a>small>i")->text();
        $this->assertContains("admin", $user);
    }

    /**
     * Account edit
     */
    public function testAccount()
    {
        //Login
        $this->doLogin();

        //Account form
        $this->url("account");

        //Edit
        $input = $this->byName('username');
        $input->clear();
        $input->value('admin2');

        $input = $this->byName('email');
        $input->clear();
        $input->value('admin2@LightFramework.localhost');

        $input = $this->byName('password');
        $input->clear();
        $input->value('admin2');

        $this->select($this->byName("language"), "es_ES");
        $this->byCssSelector("form")->submit();

        //Logout
        $this->doLogout();

        //Login
        $this->doLogin("admin2", "admin2");

        //Check login
        $user = $this->byCssSelector("div.container .nav.navbar-right li.exit>a>small>i")->text();
        $this->assertContains("admin2", $user);

        //Edit
        //$this->url("account");

        //Check fields
        //$this->assertEquals("admin2", $input->value());
    }

    /**
     * Login action
     *
     * @param string $username Username / email
     * @param string $password Password
     *
     * @return void
     */
    private function doLogin($username="admin", $password="admin")
    {
        //login
        $this->url("login");
        //Form login
        $this->byName("login")->value($username);
        $this->byName("password")->value($password);
        $this->byCssSelector("form")->submit();
    }

    /**
     * Logout action
     *
     * @return void
     */
    private function doLogout()
    {
        $this->byCssSelector("div.container .nav.navbar-right li.exit>a>small>i")->click();
    }

    /**
     * Takes a screenshot
     *
     * @param string $name Filename
     *
     * @return void
     */
    private function doScreenshot($name = "test.png")
    {
        $fp = fopen($this->screenshotPath."/".$name,'wb');
        fwrite($fp,$this->currentScreenshot());
        fclose($fp);
    }
}
