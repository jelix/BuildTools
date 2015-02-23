<?php
/**
* @author      Laurent Jouanneau
* @contributor Dominique Papin
* @copyright   2006-2015 Laurent Jouanneau
* @copyright   2008 Dominique Päpin
* @link        http://www.jelix.org
* @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
*/

if (!class_exists('Composer\\Autoload\\ClassLoader', false)) {
    require_once(__DIR__.'/autoloader.php');    
}

if(!isset($GLOBALS['BUILD_OPTIONS'])) {
    \Jelix\BuildTools\Cli\Bootstrap::help('$BUILD_OPTIONS variable is missing in your build file');
}
else {
    \Jelix\BuildTools\Cli\Bootstrap::start($GLOBALS['BUILD_OPTIONS']);
}
