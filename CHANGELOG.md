CHANGELOG
==========

2.1.0
-----

- New method Preprocessor::parseString()
- Fix php deprecated syntax (PHP 8)
- Fix preprocessor: ParserError should be catch during expression evaluation
- update PHPUnit to 8.5 to test against php 8
- drop support of PHP 5.5 and lower.

2.0.5
-----

- Fix some syntax issue when an exception occurs
- Environment class: new parameter `exportToGlobal`. Allows to not set globals variables with values from
  ini parameters

2.0.4
-----

- manifests: fix the copy of executable
- update PHPUnit to 4.8

2.0.3
-----

- update jelix/file-utilities
- Fix PHP7 support: T_CHARACTER constant is not defined anymore in PHP 7
- manifests:  Fix path when 'cd .'
- 
2.0.2
-----

- Manifests: support of recursive copy of directories with the keywork `__ALL_RECURSIVELY__`
- Fix bad path into legacy/init.php
- Use jelix/file-utilities

2.0.1
-----

- Fix JavascriptPacker loading

2.0.0
-----

- classes are now into the `Jelix\BuildTools` namespace. So all names are changed.
- scripts are now into a bin/ directory.
- tests have been improved


1.2.0
------

The version as it was into Jelix 1.6, and installable with Composer.