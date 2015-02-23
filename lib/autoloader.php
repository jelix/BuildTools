<?php
/**
* @author   Laurent Jouanneau
* @copyright 2014 Laurent Jouanneau
* @link     http://www.jelix.org
*/
namespace Jelix\BuildTools;
/**
 * Class to load classes when not using Composer
 */
class Autoloader {

    static protected $classList = array(
        "Jelix\\BuildTools\\Manifest\\Manager"      => "Manifest/Manager.php",
        "Jelix\\BuildTools\\Manifest\\Modifier"     => "Manifest/Modifier.php",
        "Jelix\\BuildTools\\Manifest\\Reader"       => "Manifest/Reader.php",
        "Jelix\\BuildTools\\FileSystem\\FsInterface" => "FileSystem/FsInterface.php",
        "Jelix\\BuildTools\\FileSystem\\Git"        => "FileSystem/Git.php",
        "Jelix\\BuildTools\\FileSystem\\Mercurial"  => "FileSystem/Mercurial.php",
        "Jelix\\BuildTools\\FileSystem\\Os"         => "FileSystem/Os.php",
        "Jelix\\BuildTools\\FileSystem\\Subversion"        => "FileSystem/Subversion.php",
        "Jelix\\BuildTools\\FileSystem\\DirUtils"   => "FileSystem/DirUtils.php",
        "Jelix\\BuildTools\\Preprocessor\\Exception"        => "Preprocessor/Exception.php",
        "Jelix\\BuildTools\\Preprocessor\\PhpCommentsRemover" => "Preprocessor/PhpCommentsRemover.php",
        "Jelix\\BuildTools\\Preprocessor\\Preprocessor"     => "Preprocessor/Preprocessor.php",
        "Jelix\\BuildTools\\Cli\\Params"            => "Cli/Params.php",
        "Jelix\\BuildTools\\Cli\\Environment"       => "Cli/Environment.php",
        //"Jelix\\BuildTools\\\\" => ".php",
        "jManifest" => "legacy/jManifest.php",
        "ManifestParser" => "legacy/ManifestParser.php",
        "JavaScriptPacker" => "class.JavaScriptPacker.php",
        "jCmdUtils" => "legacy/jCmdUtils.php",
        "jBuildUtils" => "legacy/jBuildUtils.php",
        "Env" => "legacy/Env.php"
    );

    static function loadClass($class) {
        if (isset(self::$classList[$class])) {
            $f = __DIR__.'/'.self::$classList[$class];
            if (file_exists($f)) {
                require($f);
            }
        }
    }
}

spl_autoload_register(__NAMESPACE__."\Autoloader::loadClass");