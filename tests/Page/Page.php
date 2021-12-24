<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;

abstract class Page
{
    protected $driver;

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }
}