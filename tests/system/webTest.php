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
        $this->url("login");

        //Login form
        $form = $this->byCssSelector("form");

        //Check form
        $action = $form->attribute("action");
        $this->assertStringEndsWith("/login/doLogin", $action);

        //Form login
        $this->byName("login")->value("admin");
        $this->byName("password")->value("admin");
        $form->submit();

        //Check login
        $user = $this->byCssSelector("div.container .nav.navbar-right li.exit>a>small>i")->text();
        $this->assertContains("admin", $user);
    }
}
