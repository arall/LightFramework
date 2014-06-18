LightFramework
==============

[![Build Status](https://travis-ci.org/arall/LightFramework.svg)](https://travis-ci.org/arall/LightFramework) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/arall/LightFramework/badges/quality-score.png)](https://scrutinizer-ci.com/g/arall/LightFramework/)

LightFramework is a lightweight and simple web application framework.

Installation
------------

###Composer
Also you can start a new project using this command:

    $ composer create-project light-framework/light-framework --stability="dev"

###GIT
Cloning this repo with:

    $ git clone https://github.com/arall/LightFramework.git

###ZIP Download
You also can download a ZIP file with all the framework from [here](https://github.com/arall/LightFramework/archive/master.zip).

Requirements
------------

LightFramework requires Composer to work. Simply install composer and run composer inside the base LightFramework directory.

    $ composer install

Also, it needs the following

- PHP 5.3+
- PDO
- mod_rewrite

Tests
-----

To run the test suite, you need PHPUnit (and also Selenium):

    $ php composer.phar install --dev
    $ vendor/bin/phpunit

TO-DO
-----
- Menu system
- Less code
