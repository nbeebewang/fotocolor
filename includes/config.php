<?php

    /**
     * config.php
     *
     * Computer Science 50
     * FINAL PROJECT
     *
     * Configures app.
     */

    // display errors, warnings, and notices
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    // requirements
    require("helpers.php");

    // CS50 Library
    require("vendor/library50-php-5/CS50/CS50.php");
    CS50::init(__DIR__ . "/../config.json");

?>
