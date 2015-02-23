JelixBuildTools
=================

JelixBuildTools is a set of scripts 

- to generate final source file from source file which needs a preprocessing step.
- to generate package to distribute sources
- to create "makefile" like in PHP


Creating a "makefile"
---------------------

jBuildTools contains classes to ease to write build scripts.

A build script accept in parameters the name of an ini file containing some build options.

To create a script:

- You should define first an array, containing all options that can be in the ini file
- Then you call \Jelix\BuildTools\Cli\Bootstrap::start() with the array. It then read
  the ini file and other options in the command line.
- Then you can write your instructions

You can use several classes:

- \Jelix\BuildTools\Cli\Environment to read options value of the ini file
- \Jelix\BuildTools\Manifest\Manager to use manifest files.
   A manifest file is a file containing a list of files to copy in a specific directory.
   The syntax in a manifest file allows to indicate if a file should be preprocessed or not
   and how.


For scripts written for JelixBuildTools lower than 2.0 (jBuildTools), include the file
lib/legacy/init.php instead of the old jBuild.inc.php.

More documentation later.


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

History
--------

This library has just been extract from an other repository, http://github.com/jelix/jelix.
So its history may contain some cryptic commit comments, that have signification only for the Jelix Framework.
This library has been used for long time to build packages of Jelix.

