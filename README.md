JelixBuildTools
=================

JelixBuildTools is a set of scripts 

- to generate final source file from source file which needs a preprocessing step.
- to generate package to distribute sources
- to create "makefile" like in PHP


preprocess.php
----------------

This is a tool to preprocess source file. It generates source file from other source file which
contain preprocessing instruction. So you can generate source file according to parameters 
(environment variables). see http://developer.jelix.org/wiki/en/preprocessor

usage :

```
     php preprocess.php source_file target_file
```

mkdist.php
-----------

Copy some source file from a directory to another, according to a "manifest" file. 
So it can be used to generate packages.
In the manifest, you write the list of files, and indicates where it should be copied,
if a preprocessor should be applied etc..
see http://developer.jelix.org/wiki/en/mkdist

usage :

```
    php mkdist.php [-v] manifest_file.mn source_dir target_dir
```

mkmanifest.php
----------------

generate a manifest file

```
   php mkmanifest.php [-v] source_dir [base_path] file.mn
```

jBuild.inc.php
----------------

Library to use in a script, to create a build file (a kind of makefile).

Create a script :

- It should contains first a $BUILD_OPTIONS array, containing all options that can be in the ini file
- You then should initialize JelixBuildTools:

With Composer, just call in your PHP script:

```php
\Jelix\BuildTools\Legacy::inc();
```

Without Composer, include the lib/jBuild.inc.php file.

More documentation later.

History
--------

This library has just been extract from an other repository, http://github.com/jelix/jelix.
So its history may contain some cryptic commit comments, that have signification only for the Jelix Framework.
This library has been used for long time to build packages of Jelix. Its code may appear "old style".
Futur version of JelixBuildTools will be with namespaced classes and with other modern stuff.

