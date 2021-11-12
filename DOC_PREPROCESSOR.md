Syntax for content for the preprocessor
=======================================

The preprocessor can analyse any file, and produce a resulting file after interpreting some preprocessor statements
that are into the source file. These statements can use some environment variables.

A statement starts always with a `#` on a line, without blank character before it. The `#` is followed by a 
statement name and by possible parameters.

## `#ifdef`, `#ifndef`, `#else`, `#elifdef`, `#endif`

Allow to test if an environment variable exists. They should be used with  `#endif`, and optionnally with `#else` or `#elifdef`.


Here is an example in a php source file:
```php
$rox = new MyObject();
#ifdef PROD_VERSION
$foo = funcA($rox);
#else
if (is_empty($foo)) {
    trigger_error('foo undefined !',E_USER_ERROR);
} else {    
    $foo = funcA($rox);
}
#endif
$foo->bar();
```

If the `PROD_VERSION` environment variable does exist, then the generated file will be:

```php
$rox = new MyObject();
$foo = funcA($rox);
$foo->bar();
```

Else it will be:

```php
$rox = new MyObject();
if (is_empty($foo)) {
    trigger_error('foo undefined !',E_USER_ERROR);
} else {    
    $foo = funcA($rox);
}
$foo->bar();
```

`#ifndef` check that a variable does not exists.

## `#expand`

It allow to insert the value of one or more environment variables. The statement should be followed by any content.
The content may contains any environment variable name, framed by a double underscore like that: `__My_VARIABLE__`.

Example:

```
#expand define ('JELIX_VERSION', '__LIB_VERSION__');
```

If `LIB_VERSION` is equals to `1.0`, then the generated content will be:

```
define ('JELIX_VERSION', '1.0');
```



## `#define`, `#undef`

`#define` allow to define a new variable or to change the value of an existing variable.
`#undef` delete a variable.

## `#include`, `#includephp`

Allow to include the content of an other file.

Example of a fileA.txt:

```
aaaa

#include fileB.txt

bbbb
```

And the content of fileB.txt:

```
cccc
dddd
```

Then the result given by the preprocessor on A will be:

```
aaaa

cccc
dddd

bbbb
```

The path indicated to `#include` is relative to the path of the current file.

`#includephp` include also a file, but remove `<?php` and `?>` from the start and the end of the included file.



# using the preprocessor 

## in the command line

You should launch `bin/preprocess.php`, with the path of the source file, and the path to the target file.
 
```
php bin/preprocess.php lib/jelix/init.php ../../target/lib/jelix/init.php
```

To specify environment variables, you can use `export` (linux/mac) or `set` (windows):

```
export LIB_VERSION=1.0
php bin/preprocess.php lib/jelix/init.php ../../target/lib/jelix/init.php
```

# from a php script


Example:

```php

// instancie the preprocessor
$proc = new \Jelix\BuildTools\PreProcessor\PreProcessor();

// set variables into it
$proc->setVars($_ENV);

// generate the content
$generatedContent = $proc->parseFile($sourcefile);

\Jelix\FileUtilities\Directory::create(dirname($distfile));
file_put_contents($distfile, $dist);
```


