# MyHonors-Backend 

[![Travis Build System](https://img.shields.io/travis/fiuhonors/myhonors.svg?style=flat-square)](https://travis-ci.org/fiuhonors/myhonors-backend)

MyHonors-Backend tackles all of the server-side needs of the MyHonors platform. From initializing/authorizing sessions, file uploads, sending emails and more, MyHonors-Backend tackles all of these tasks.

## Starting Development

1. Setup the appropriate configuration settings (keys, URLs, etc.) at `.config.js`.
2. `composer install --dev` to install all of our dependencies - both client AND development modules.
4. `robo all` to run robo, our PHP task runner that automates PHP linting, executing unit tests, making sure our codebase follows PSR specification and many more.

## Technology
MyHonors-Backend uses a myriad of web technologies. Some frameworks, tools, and libraries that are used are:

Libraries
* [Firebase\PHP-JWT](https://github.com/firebase/php-jwt) JSON Web Token Generator for stateless authentication and session handling
* [Ktamas77\Firebase-PHP](https://github.com/ktamas77/firebase-php) Firebase client for PHP
* [Corneltek\Pux](https://github.com/c9s/Pux) High-performance router for URL paths
* [Level-2\Dice](https://github.com/Level-2/Dice) Powerful dependency-injection container, preventing us from coupling our classes
* [Dreamscapes\Ldap-Core](https://github.com/Dreamscapes/Ldap-Core) LDAP Abstraction library

Extensions
* [php-ldap](http://php.net/manual/en/book.ldap.php) Lightweight Directory Access Protocol Extension for PHP, for FIU Authentication
* [php-gd](http://php.net/manual/en/book.image.php) Image GD Extension for PHP, for manipulating image files

Build Process
* [Codegyre\Robo](http://robo.li/) for automating tasks - a PHP task runner (like Gulp, but with PHP)
* [PHPUnit\PHPUnit](https://phpunit.de/) for unit-testing our PHP code
* [Composer](https://getcomposer.org/) for handling our dependencies
* [Travis CI](https://travis-ci.org/) for continous-integration, ensuring the quality of our production code

## Ground rules
To keep MyHonors-Backend highly scalable, it needs to follow a certain discipline in its development environment. Here are some ground rules to follow:

* Always write your tests before you write your code - Test Driven Development!
* Make sure that tests pass and that you are in sync with the current master branch before making a pull request/merge to the master branch!
* Follow the PHP Framework Interop Group's [PSR-2 specification](http://www.php-fig.org/psr/psr-2/) coding style (which means that you must also follow the [PSR-1](http://www.php-fig.org/psr/psr-1/) coding style) as well as the [PSR-4 specification](http://www.php-fig.org/psr/psr-4/) autoloading specification for classes, namespaces and directory structure.